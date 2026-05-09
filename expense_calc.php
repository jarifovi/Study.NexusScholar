<?php
// FILE: expense_calc.php
require_once 'auth_check.php';

$page_title = "Dynamic Expense Calculator";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-calculator" style="color:var(--primary); margin-right:15px;"></i> Dynamic Expense Calculator</h1>
    <p>Convert and calculate your study abroad expenses in real-time.</p>
</div>

<div class="grid grid-2">
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-coins"></i> Conversion Tool</h2>
        <div class="grid grid-2">
            <div class="form-group">
                <label>Amount</label>
                <input type="number" id="base-amount" value="1000" oninput="calcExchange()">
            </div>
            <div class="form-group">
                <label>From Currency</label>
                <select id="from-currency" onchange="calcExchange()">
                    <option value="USD">USD ($)</option>
                    <option value="GBP">GBP (£)</option>
                    <option value="EUR">EUR (€)</option>
                    <option value="CAD">CAD ($)</option>
                    <option value="AUD">AUD ($)</option>
                    <option value="JPY">JPY (¥)</option>
                </select>
            </div>
        </div>
        
        <div style="text-align:center; padding: 20px; background:rgba(255,255,255,0.03); border-radius:16px; border:1px solid var(--border-glass);">
            <div style="font-size:14px; color:var(--text-muted); margin-bottom:10px;">In BDT (approximate)</div>
            <div style="font-size:42px; font-weight:800; color:var(--primary);" id="result-bdt">120,000</div>
            <div style="font-size:12px; color:var(--text-dim); margin-top:5px;">*Rate: 1 <span id="rate-label">USD</span> = <span id="rate-value">120</span> BDT</div>
        </div>
        
        <p class="help-text mt-3">Note: Rates are simulated for demonstration. Real-time API integration can be added.</p>
    </div>

    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-chart-pie"></i> Budget Breakdown</h2>
        <canvas id="budgetChart" style="max-height:200px;"></canvas>
        <div class="mt-3">
            <div class="form-group">
                <label>Monthly Rent</label>
                <input type="range" min="300" max="2000" step="50" value="800" id="rent" oninput="updateChart()">
                <span id="rent-val" style="float:right; color:var(--primary);">$800</span>
            </div>
            <div class="form-group">
                <label>Food & Groceries</label>
                <input type="range" min="100" max="1000" step="20" value="400" id="food" oninput="updateChart()">
                <span id="food-val" style="float:right; color:var(--primary);">$400</span>
            </div>
        </div>
    </div>
</div>

<script>
const rates = {
    USD: 120,
    GBP: 152,
    EUR: 130,
    CAD: 88,
    AUD: 80,
    JPY: 0.8
};

function calcExchange() {
    const amt = document.getElementById('base-amount').value;
    const curr = document.getElementById('from-currency').value;
    const rate = rates[curr];
    const res = amt * rate;
    
    document.getElementById('result-bdt').innerText = res.toLocaleString();
    document.getElementById('rate-label').innerText = curr;
    document.getElementById('rate-value').innerText = rate;
}

let budgetChart;
function updateChart() {
    const rent = parseInt(document.getElementById('rent').value);
    const food = parseInt(document.getElementById('food').value);
    const misc = 300; // fixed misc

    document.getElementById('rent-val').innerText = '$' + rent;
    document.getElementById('food-val').innerText = '$' + food;

    if (budgetChart) budgetChart.destroy();

    const ctx = document.getElementById('budgetChart').getContext('2d');
    budgetChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Rent', 'Food', 'Misc'],
            datasets: [{
                data: [rent, food, misc],
                backgroundColor: ['#10b981', '#34d399', '#38bdf8'],
                borderWidth: 0
            }]
        },
        options: {
            plugins: {
                legend: { position: 'right', labels: { color: '#fff' } }
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    calcExchange();
    updateChart();
});
</script>

<?php include 'footer.php'; ?>
