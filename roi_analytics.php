<?php
// FILE: roi_analytics.php
require_once 'auth_check.php';

$page_title = "ROI Analytics";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-hand-holding-dollar" style="color:var(--primary); margin-right:15px;"></i> Scholarship ROI Analytics</h1>
    <p>Calculate the long-term value and break-even point of your degree.</p>
</div>

<div class="grid grid-2">
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-sliders"></i> Investment Variables</h2>
        <div class="form-group">
            <label>Total Tuition Fee (per year)</label>
            <input type="number" id="tuition" value="15000" oninput="calculateROI()">
        </div>
        <div class="form-group">
            <label>Estimated Living Cost (per year)</label>
            <input type="number" id="living" value="10000" oninput="calculateROI()">
        </div>
        <div class="form-group">
            <label>Target Starting Salary (Graduate Level)</label>
            <input type="number" id="salary" value="45000" oninput="calculateROI()">
        </div>
        <div class="form-group">
            <label>Program Duration (Years)</label>
            <select id="duration" onchange="calculateROI()">
                <option value="1">1 Year (Masters)</option>
                <option value="2">2 Years (Masters/MBA)</option>
                <option value="3">3 Years (Undergraduate)</option>
                <option value="4" selected>4 Years (Undergraduate)</option>
            </select>
        </div>
    </div>

    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-chart-line"></i> ROI Forecast</h2>
        <div style="text-align:center; padding:30px; background:rgba(16,185,129,0.05); border-radius:24px; border:1px solid var(--border-glass-bright);">
            <div style="font-size:14px; color:var(--text-muted); text-transform:uppercase; letter-spacing:2px;">Break-Even Period</div>
            <div style="font-size:56px; font-weight:800; color:var(--primary);" id="breakeven-years">2.4</div>
            <div style="font-size:18px; font-weight:700;">Years of Professional Work</div>
        </div>
        
        <div class="mt-4 grid grid-2">
            <div style="background:rgba(255,255,255,0.03); padding:15px; border-radius:15px; text-align:center;">
                <div style="font-size:12px; color:var(--text-muted);">Total Investment</div>
                <div style="font-size:20px; font-weight:800; color:#fff;" id="total-investment">$100,000</div>
            </div>
            <div style="background:rgba(255,255,255,0.03); padding:15px; border-radius:15px; text-align:center;">
                <div style="font-size:12px; color:var(--text-muted);">Net Yearly Profit</div>
                <div style="font-size:20px; font-weight:800; color:#fff;" id="yearly-profit">$35,000</div>
            </div>
        </div>
        
        <p class="help-text mt-3" style="text-align:center; font-size:12px; color:var(--text-dim);">*Assuming 25% of salary goes to living expenses after graduation.</p>
    </div>
</div>

<script>
function calculateROI() {
    const tuition = parseFloat(document.getElementById('tuition').value) || 0;
    const living = parseFloat(document.getElementById('living').value) || 0;
    const salary = parseFloat(document.getElementById('salary').value) || 0;
    const duration = parseInt(document.getElementById('duration').value);

    const totalInvest = (tuition + living) * duration;
    const netSalary = salary * 0.75; // 25% for living post-grad
    const years = totalInvest / netSalary;

    document.getElementById('total-investment').innerText = '$' + totalInvest.toLocaleString();
    document.getElementById('yearly-profit').innerText = '$' + netSalary.toLocaleString();
    document.getElementById('breakeven-years').innerText = years.toFixed(1);
}

document.addEventListener('DOMContentLoaded', calculateROI);
</script>

<?php include 'footer.php'; ?>
