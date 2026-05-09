<?php
// FILE: financial_planner.php
require_once 'auth_check.php';

$page_title = "Financial Gap Analyzer";
$userId = $_SESSION['user_id'];

// Get countries for dropdown
$countriesStmt = $pdo->query("SELECT name, estimated_cost_min, estimated_cost_max FROM countries ORDER BY name ASC");
$countries = $countriesStmt->fetchAll(PDO::FETCH_ASSOC);

// Get user's target country if any
$userStmt = $pdo->prepare("SELECT target_country FROM users WHERE id = ?");
$userStmt->execute([$userId]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);
$targetCountry = $user['target_country'] ?? '';

include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-coins" style="color:var(--primary); margin-right:10px;"></i> Financial Gap Analyzer</h1>
    <p>Estimate your funding gap and part-time work requirements.</p>
</div>

<div class="grid grid-2 mt-3">
    <!-- Calculator Form -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-calculator" style="margin-right:10px; color:var(--secondary);"></i> Input Your Funds</h2>
        
        <label><i class="fa-solid fa-globe" style="margin-right:5px; color:var(--text-muted);"></i> Target Country</label>
        <select id="countrySelect" onchange="calculateGap()">
            <option value="">-- Select Country --</option>
            <?php foreach($countries as $c): ?>
                <option value="<?= htmlspecialchars(json_encode([$c['estimated_cost_min'], $c['estimated_cost_max']])) ?>" <?= ($targetCountry === $c['name']) ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        
        <label><i class="fa-solid fa-piggy-bank" style="margin-right:5px; color:var(--text-muted);"></i> Personal Savings ($)</label>
        <input type="number" id="savings" value="5000" oninput="calculateGap()">
        
        <label><i class="fa-solid fa-hand-holding-dollar" style="margin-right:5px; color:var(--text-muted);"></i> Family Support / Sponsors ($)</label>
        <input type="number" id="sponsor" value="10000" oninput="calculateGap()">
        
        <label><i class="fa-solid fa-graduation-cap" style="margin-right:5px; color:var(--text-muted);"></i> Scholarship Amount ($)</label>
        <input type="number" id="scholarship" value="0" oninput="calculateGap()">
    </div>

    <!-- Results & Chart -->
    <div class="glass-card animate-gravity delay-2" style="display:flex; flex-direction:column; align-items:center;">
        <h2><i class="fa-solid fa-chart-pie" style="margin-right:10px; color:var(--primary);"></i> Funding Analysis</h2>
        
        <div id="resultBox" style="width:100%; text-align:center; padding:15px; margin-bottom:20px; border-radius:12px; border:1px solid var(--border-glass); background:rgba(255,255,255,0.02);">
            <p style="color:var(--text-muted); font-size:14px; margin-bottom:5px;">Select a country to analyze</p>
        </div>
        
        <div style="height:220px; width:100%; position:relative;">
            <canvas id="financeChart"></canvas>
            <div id="chartCenterText" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:24px; font-weight:800; color:#fff;"></div>
        </div>
        
        <div id="partTimeBox" style="margin-top:20px; font-size:14px; color:var(--text-muted); text-align:center; width:100%; display:none;">
            <div style="background:rgba(239, 68, 68, 0.1); padding:12px; border-radius:10px; border:1px solid rgba(239, 68, 68, 0.2);">
                <i class="fa-solid fa-briefcase" style="color:#ef4444; margin-right:5px;"></i> You will need to work approx <strong style="color:#fff;" id="ptHours">0</strong> hours/week (at $15/hr) to cover the gap over 1 year.
            </div>
        </div>
    </div>
</div>

<script>
let chartInstance = null;

function calculateGap() {
    const sel = document.getElementById('countrySelect');
    if(!sel.value) return;
    
    const costs = JSON.parse(sel.value);
    const avgCost = (costs[0] + costs[1]) / 2;
    if(avgCost === 0) {
        document.getElementById('resultBox').innerHTML = '<p>Cost data not available for this country.</p>';
        if(chartInstance) chartInstance.destroy();
        document.getElementById('chartCenterText').innerText = '';
        document.getElementById('partTimeBox').style.display = 'none';
        return;
    }
    
    const savings = parseFloat(document.getElementById('savings').value) || 0;
    const sponsor = parseFloat(document.getElementById('sponsor').value) || 0;
    const scholarship = parseFloat(document.getElementById('scholarship').value) || 0;
    
    const totalFunds = savings + sponsor + scholarship;
    const gap = avgCost - totalFunds;
    const hasGap = gap > 0;
    
    const resBox = document.getElementById('resultBox');
    const ptBox = document.getElementById('partTimeBox');
    
    if(hasGap) {
        resBox.innerHTML = `
            <p style="color:var(--text-muted); font-size:14px;">Total Required: <strong style="color:#fff;">$${avgCost.toLocaleString()}</strong></p>
            <p style="color:var(--text-muted); font-size:14px;">Total Funds: <strong style="color:#10b981;">$${totalFunds.toLocaleString()}</strong></p>
            <h3 style="color:#ef4444; margin-top:10px;">Shortfall: $${gap.toLocaleString()}</h3>
        `;
        const weeksInYear = 52;
        const ptWage = 15; // assumption
        const hoursNeeded = gap / (ptWage * weeksInYear);
        document.getElementById('ptHours').innerText = Math.ceil(hoursNeeded);
        ptBox.style.display = 'block';
    } else {
        resBox.innerHTML = `
            <p style="color:var(--text-muted); font-size:14px;">Total Required: <strong style="color:#fff;">$${avgCost.toLocaleString()}</strong></p>
            <p style="color:var(--text-muted); font-size:14px;">Total Funds: <strong style="color:#10b981;">$${totalFunds.toLocaleString()}</strong></p>
            <h3 style="color:#10b981; margin-top:10px;">Surplus: $${Math.abs(gap).toLocaleString()}</h3>
        `;
        ptBox.style.display = 'none';
    }
    
    renderChart(totalFunds, hasGap ? gap : 0);
}

function renderChart(funded, gap) {
    Chart.defaults.color = '#ffffff';
    Chart.defaults.borderColor = 'rgba(255,255,255,0.1)';

    const ctx = document.getElementById('financeChart');
    if(chartInstance) chartInstance.destroy();
    
    const total = funded + gap;
    const pct = total > 0 ? Math.round((funded / total) * 100) : 0;
    document.getElementById('chartCenterText').innerText = pct + '% Funded';
    document.getElementById('chartCenterText').style.fontSize = '18px';
    
    chartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Funded', 'Gap'],
            datasets: [{
                data: [funded, gap],
                backgroundColor: ['#10b981', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '75%',
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}

// init
setTimeout(calculateGap, 100);
</script>

<?php include 'footer.php'; ?>
