<?php
// FILE: achievements.php
require_once 'auth_check.php';

$page_title = "Achievements & Badges";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-trophy" style="color:var(--primary); margin-right:15px;"></i> Achievements & Badges</h1>
    <p>Track your progress and unlock legendary status as you complete your journey.</p>
</div>

<div class="glass-card animate-gravity mb-4" style="background:linear-gradient(135deg, rgba(16,185,129,0.1), rgba(4,120,87,0.1)); border:1px solid var(--primary);">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div style="display:flex; gap:25px; align-items:center;">
            <div style="font-size:48px;">🏅</div>
            <div>
                <h2 style="margin:0;">Elite Scholar (Level 4)</h2>
                <p style="color:var(--text-muted);">2,450 XP / 3,000 XP to Level 5</p>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:32px; font-weight:800; color:var(--primary);">78%</div>
            <p style="font-size:11px; text-transform:uppercase; letter-spacing:1px;">Journey Completion</p>
        </div>
    </div>
</div>

<div class="grid grid-4">
    <!-- Badge 1 -->
    <div class="glass-card animate-gravity delay-1 text-center">
        <div class="badge-icon">🏛️</div>
        <h4 style="margin:15px 0 5px;">The Architect</h4>
        <p style="font-size:11px; color:var(--text-muted);">SOP Finalized</p>
        <div class="badge-status unlocked">Unlocked</div>
    </div>

    <!-- Badge 2 -->
    <div class="glass-card animate-gravity delay-2 text-center">
        <div class="badge-icon">🛡️</div>
        <h4 style="margin:15px 0 5px;">Vault Keeper</h4>
        <p style="font-size:11px; color:var(--text-muted);">5+ Docs Secured</p>
        <div class="badge-status unlocked">Unlocked</div>
    </div>

    <!-- Badge 3 -->
    <div class="glass-card animate-gravity delay-3 text-center">
        <div class="badge-icon">🔎</div>
        <h4 style="margin:15px 0 5px;">Scholarship Hunter</h4>
        <p style="font-size:11px; color:var(--text-muted);">10 Scholarships Shortlisted</p>
        <div class="badge-status locked">Locked</div>
    </div>

    <!-- Badge 4 -->
    <div class="glass-card animate-gravity delay-4 text-center">
        <div class="badge-icon">🎤</div>
        <h4 style="margin:15px 0 5px;">The Orator</h4>
        <p style="font-size:11px; color:var(--text-muted);">5 Audio Sessions Complete</p>
        <div class="badge-status locked">Locked</div>
    </div>
</div>

<style>
.badge-icon {
    font-size: 50px;
    margin-bottom: 10px;
    filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
}
.badge-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    margin-top: 15px;
}
.unlocked { background: rgba(16,185,129,0.2); color: var(--primary); border: 1px solid var(--primary); }
.locked { background: rgba(255,255,255,0.05); color: var(--text-dim); border: 1px solid var(--border-glass); opacity: 0.6; }
</style>

<?php include 'footer.php'; ?>
