<?php
// FILE: admin_broadcast.php
require_once 'admin_auth.php';
require_once 'config.php';

$page_title = "Broadcast Center";
include 'admin_header.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-tower-broadcast" style="color:var(--primary); margin-right:15px;"></i> Broadcast Center</h1>
    <p>Send urgent notifications and updates to all registered students.</p>
</div>

<div class="grid grid-2">
    <!-- BROADCAST FORM -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-paper-plane"></i> New Broadcast</h2>
        <div class="form-group">
            <label>Message Type</label>
            <select>
                <option>General Update</option>
                <option>Urgent Alert</option>
                <option>Scholarship Deadline</option>
                <option>Visa News</option>
            </select>
        </div>
        <div class="form-group">
            <label>Subject</label>
            <input type="text" placeholder="e.g., UK Student Visa Update May 2026">
        </div>
        <div class="form-group">
            <label>Message Body</label>
            <textarea rows="6" placeholder="Write your announcement here..."></textarea>
        </div>
        <button class="btn-primary full-width mt-3" onclick="alert('Broadcast sent to 1,245 students!')">
            <i class="fa-solid fa-bullhorn"></i> Send to All Students
        </button>
    </div>

    <!-- HISTORY -->
    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-clock-rotate-left"></i> Recent Broadcasts</h2>
        <div class="broadcast-item">
            <div class="date">May 01, 2026</div>
            <div class="subject">KCL Application Deadline Extension</div>
            <div class="stats">Opened by 850 students</div>
        </div>
        <div class="broadcast-item mt-3">
            <div class="date">Apr 25, 2026</div>
            <div class="subject">New Scholarship Scraper Live</div>
            <div class="stats">Opened by 1,120 students</div>
        </div>
    </div>
</div>

<style>
.broadcast-item {
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
}
.broadcast-item .date { font-size: 11px; color: var(--primary); font-weight: 700; margin-bottom: 5px; }
.broadcast-item .subject { font-size: 16px; font-weight: 600; color: #fff; }
.broadcast-item .stats { font-size: 12px; color: var(--text-muted); margin-top: 10px; }
</style>

<?php include 'admin_footer.php'; ?>
