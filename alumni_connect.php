<?php
// FILE: alumni_connect.php
require_once 'auth_check.php';

$page_title = "Alumni Connect";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-graduation-cap" style="color:var(--primary); margin-right:15px;"></i> Alumni Connect</h1>
    <p>Visualize the success paths of students who walked before you.</p>
</div>

<div class="grid grid-3">
    <!-- Profile 1 -->
    <div class="glass-card animate-gravity delay-1">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:80px; height:80px; background:linear-gradient(135deg, var(--primary), var(--secondary)); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 15px; font-size:32px; font-weight:800; color:#fff;">TH</div>
            <h3 style="margin:0;">Tahmid Hasan</h3>
            <span style="color:var(--primary); font-size:12px; font-weight:700;">University of Toronto</span>
        </div>
        <div class="alumni-path">
            <div class="path-step"><span>CGPA:</span> <strong>3.40</strong></div>
            <div class="path-step"><span>Program:</span> <strong>MSc Computer Science</strong></div>
            <div class="path-step"><span>Current:</span> <strong style="color:var(--accent);">AI Engineer @ Meta</strong></div>
        </div>
        <button class="btn-primary full-width mt-3">View Blueprint</button>
    </div>

    <!-- Profile 2 -->
    <div class="glass-card animate-gravity delay-2">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:80px; height:80px; background:linear-gradient(135deg, var(--secondary), var(--accent)); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 15px; font-size:32px; font-weight:800; color:#fff;">SR</div>
            <h3 style="margin:0;">Sultana Razia</h3>
            <span style="color:var(--primary); font-size:12px; font-weight:700;">King's College London</span>
        </div>
        <div class="alumni-path">
            <div class="path-step"><span>CGPA:</span> <strong>3.85</strong></div>
            <div class="path-step"><span>Program:</span> <strong>MA International Relations</strong></div>
            <div class="path-step"><span>Current:</span> <strong style="color:var(--accent);">Policy Advisor @ UN</strong></div>
        </div>
        <button class="btn-primary full-width mt-3">View Blueprint</button>
    </div>

    <!-- Profile 3 -->
    <div class="glass-card animate-gravity delay-3">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:80px; height:80px; background:linear-gradient(135deg, var(--accent), var(--primary)); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 15px; font-size:32px; font-weight:800; color:#fff;">ZK</div>
            <h3 style="margin:0;">Zubayer Khan</h3>
            <span style="color:var(--primary); font-size:12px; font-weight:700;">University of Melbourne</span>
        </div>
        <div class="alumni-path">
            <div class="path-step"><span>CGPA:</span> <strong>3.10</strong></div>
            <div class="path-step"><span>Program:</span> <strong>Master of Finance</strong></div>
            <div class="path-step"><span>Current:</span> <strong style="color:var(--accent);">Analyst @ Goldman Sachs</strong></div>
        </div>
        <button class="btn-primary full-width mt-3">View Blueprint</button>
    </div>
</div>

<style>
.alumni-path {
    background: rgba(255,255,255,0.03);
    border-radius: 16px;
    padding: 15px;
}
.path-step {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid var(--border-glass);
    font-size: 13px;
}
.path-step:last-child { border-bottom: none; }
.path-step span { color: var(--text-muted); }
.path-step strong { color: #fff; }
</style>

<?php include 'footer.php'; ?>
