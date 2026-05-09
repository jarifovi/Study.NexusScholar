<?php
// FILE: standardized_tests.php
require_once 'auth_check.php';

$page_title = "Standardized Tests";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-pen-to-square" style="color:var(--primary); margin-right:15px;"></i> Standardized Test Tracker</h1>
    <p>Track your GRE, GMAT, and SAT progress.</p>
</div>

<div class="grid grid-2">
    <!-- GRE TRACKER -->
    <div class="glass-card animate-gravity delay-1">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
            <h2><i class="fa-solid fa-brain" style="color:var(--primary);"></i> GRE Tracker</h2>
            <span class="badge badge-active">Target: 325</span>
        </div>
        
        <div class="grid grid-3 mb-4" style="text-align:center;">
            <div style="background:rgba(255,255,255,0.03); padding:15px; border-radius:15px;">
                <div style="font-size:12px; color:var(--text-muted);">Verbal</div>
                <div style="font-size:24px; font-weight:800; color:var(--primary);">158</div>
            </div>
            <div style="background:rgba(255,255,255,0.03); padding:15px; border-radius:15px;">
                <div style="font-size:12px; color:var(--text-muted);">Quant</div>
                <div style="font-size:24px; font-weight:800; color:var(--primary);">164</div>
            </div>
            <div style="background:rgba(255,255,255,0.03); padding:15px; border-radius:15px;">
                <div style="font-size:12px; color:var(--text-muted);">Total</div>
                <div style="font-size:24px; font-weight:800; color:var(--primary);">322</div>
            </div>
        </div>

        <div class="form-group">
            <label>Mock Exam 1 Score</label>
            <input type="range" min="260" max="340" value="315" style="accent-color:var(--primary);">
        </div>
        <button class="btn-primary full-width mt-2">Log New Mock Score</button>
    </div>

    <!-- GMAT TRACKER -->
    <div class="glass-card animate-gravity delay-2">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
            <h2><i class="fa-solid fa-chart-simple" style="color:var(--secondary);"></i> GMAT Tracker</h2>
            <span class="badge badge-active" style="background:rgba(129,140,248,0.1); color:var(--secondary); border-color:rgba(129,140,248,0.2);">Target: 700</span>
        </div>
        
        <canvas id="gmatChart" style="max-height:180px;"></canvas>
        
        <p class="mt-3" style="font-size:14px; color:var(--text-muted);">Your last GMAT Focus Edition score: <strong>645</strong></p>
        <button class="btn-primary full-width mt-2" style="background:linear-gradient(135deg, var(--secondary), var(--accent));">Update GMAT Progress</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('gmatChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mock 1', 'Mock 2', 'Mock 3', 'Mock 4'],
            datasets: [{
                label: 'Score',
                data: [580, 610, 645, 660],
                borderColor: '#818cf8',
                backgroundColor: 'rgba(129,140,248,0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { ticks: { color: '#94a3b8' } }
            }
        }
    });
});
</script>

<?php include 'footer.php'; ?>
