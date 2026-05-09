<?php
// FILE: admin_heatmap.php
require_once 'admin_auth.php';
require_once 'config.php';

$page_title = "Global Insight Heatmap";
include 'admin_header.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-earth-africa" style="color:var(--primary); margin-right:15px;"></i> Global Insight Heatmap</h1>
    <p>Visualize student interest and application trends across the globe.</p>
</div>

<div class="grid grid-3 mb-4">
    <div class="glass-card stat-card animate-gravity delay-1">
        <h3>Top Destination</h3>
        <p class="stat-value">UK</p>
        <p style="font-size:13px; color:var(--text-muted);">42% of all applications</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-2">
        <h3>Most Popular Uni</h3>
        <p class="stat-value" style="font-size:24px;">KCL, London</p>
        <p style="font-size:13px; color:var(--text-muted);">156 Active Applicants</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-3">
        <h3>Global Readiness</h3>
        <p class="stat-value">B+</p>
        <p style="font-size:13px; color:var(--text-muted);">Average student XP: 420</p>
    </div>
</div>

<div class="grid grid-2">
    <!-- INTEREST MAP -->
    <div class="glass-card animate-gravity delay-4">
        <h2><i class="fa-solid fa-chart-line"></i> Interest Trends</h2>
        <canvas id="interestChart" style="max-height:300px;"></canvas>
    </div>

    <!-- COUNTRY BREAKDOWN -->
    <div class="glass-card animate-gravity delay-5">
        <h2><i class="fa-solid fa-list-check"></i> Regional Breakdown</h2>
        <div class="cost-item"><span>United Kingdom</span> <div style="width:150px; height:8px; background:rgba(16,185,129,0.1); border-radius:10px;"><div style="width:85%; height:100%; background:var(--primary); border-radius:10px;"></div></div> <strong>85%</strong></div>
        <div class="cost-item"><span>Canada</span> <div style="width:150px; height:8px; background:rgba(16,185,129,0.1); border-radius:10px;"><div style="width:65%; height:100%; background:var(--secondary); border-radius:10px;"></div></div> <strong>65%</strong></div>
        <div class="cost-item"><span>USA</span> <div style="width:150px; height:8px; background:rgba(16,185,129,0.1); border-radius:10px;"><div style="width:45%; height:100%; background:var(--accent); border-radius:10px;"></div></div> <strong>45%</strong></div>
        <div class="cost-item"><span>Australia</span> <div style="width:150px; height:8px; background:rgba(16,185,129,0.1); border-radius:10px;"><div style="width:30%; height:100%; background:var(--text-muted); border-radius:10px;"></div></div> <strong>30%</strong></div>
    </div>
</div>

<style>
.cost-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid var(--border-glass);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('interestChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Registrations',
                data: [120, 190, 300, 250, 420, 380],
                backgroundColor: '#10b981',
                borderRadius: 8
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
            }
        }
    });
});
</script>

<?php include 'admin_footer.php'; ?>
