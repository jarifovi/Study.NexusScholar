<?php
// FILE: flight_scout.php
require_once 'auth_check.php';

$page_title = "Global Flight Scout";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-plane-departure" style="color:var(--primary); margin-right:15px;"></i> Global Flight Scout</h1>
    <p>Monitor seasonal flight trends to plan your arrival budget.</p>
</div>

<div class="glass-card animate-gravity mb-4">
    <div class="grid grid-3" style="align-items:flex-end;">
        <div class="form-group">
            <label>Origin</label>
            <input type="text" value="Dhaka (DAC)" readonly>
        </div>
        <div class="form-group">
            <label>Destination</label>
            <select>
                <option>London (LHR)</option>
                <option>New York (JFK)</option>
                <option>Toronto (YYZ)</option>
                <option>Sydney (SYD)</option>
            </select>
        </div>
        <button class="btn-primary" style="height:55px; margin-bottom:25px;">Search Best Season</button>
    </div>
</div>

<div class="grid grid-2">
    <!-- TREND CHART -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-chart-area"></i> Price Trends (Yearly)</h2>
        <canvas id="flightChart" style="max-height:250px;"></canvas>
    </div>

    <!-- RECOMMENDATIONS -->
    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-tags"></i> Scout's Verdict</h2>
        <div class="alert warning" style="margin-bottom:20px;">
            <i class="fa-solid fa-triangle-exclamation"></i> <strong>Peak Season Warning:</strong> September prices are 40% higher due to student arrivals.
        </div>
        
        <div class="flight-deal">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h3 style="margin:0;">Qatar Airways</h3>
                    <span style="font-size:12px; color:var(--text-muted);">via Doha (DOH)</span>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:24px; font-weight:800; color:var(--primary);">$920</div>
                    <span style="font-size:11px; color:var(--text-dim);">Best Value</span>
                </div>
            </div>
        </div>

        <div class="flight-deal mt-3">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h3 style="margin:0;">Emirates</h3>
                    <span style="font-size:12px; color:var(--text-muted);">via Dubai (DXB)</span>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:24px; font-weight:800; color:var(--text-main);">$1,150</div>
                    <span style="font-size:11px; color:var(--text-dim);">Premium Service</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.flight-deal {
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    transition: var(--transition);
}
.flight-deal:hover {
    background: rgba(255,255,255,0.05);
    border-color: var(--primary);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('flightChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Mar', 'May', 'Jul', 'Sep', 'Nov'],
            datasets: [{
                label: 'Price ($)',
                data: [850, 780, 920, 1100, 1350, 900],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
            }
        }
    });
});
</script>

<?php include 'footer.php'; ?>
