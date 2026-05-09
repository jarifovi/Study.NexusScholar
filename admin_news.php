<?php
// FILE: admin_news.php
require_once 'admin_auth.php';
require_once 'config.php';

$page_title = "Global News Manager";
include 'admin_header.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-newspaper" style="color:var(--primary); margin-right:15px;"></i> Global News Manager</h1>
    <p>Manage the live industry news feed displayed on student dashboards.</p>
</div>

<div class="grid grid-2">
    <!-- NEWS FORM -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-pen-to-square"></i> Publish News</h2>
        <div class="form-group">
            <label>Headline</label>
            <input type="text" placeholder="e.g., UK Government announces new Graduate Route changes">
        </div>
        <div class="form-group">
            <label>Category</label>
            <select>
                <option>Visa Updates</option>
                <option>University News</option>
                <option>Scholarship Alerts</option>
                <option>Travel Info</option>
            </select>
        </div>
        <div class="form-group">
            <label>External URL (Optional)</label>
            <input type="text" placeholder="https://bbc.com/news/...">
        </div>
        <button class="btn-primary full-width mt-3" onclick="alert('News published successfully!')">
            <i class="fa-solid fa-rss"></i> Publish to Feed
        </button>
    </div>

    <!-- LIVE FEED -->
    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-bolt"></i> Live Feed Preview</h2>
        <div class="news-preview-item">
            <span class="badge" style="background:var(--primary);">Visa</span>
            <h4>New CAS Issuance Rules for Fall 2026</h4>
            <p>Posted 2 hours ago by System Admin</p>
        </div>
        <div class="news-preview-item mt-3">
            <span class="badge" style="background:var(--accent);">Scholarship</span>
            <h4>Commonwealth Scholarship Applications Now Open</h4>
            <p>Posted 1 day ago by System Admin</p>
        </div>
    </div>
</div>

<style>
.news-preview-item {
    padding: 15px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 12px;
}
.news-preview-item h4 { margin: 10px 0 5px; color: #fff; }
.news-preview-item p { font-size: 11px; color: var(--text-muted); }
</style>

<?php include 'admin_footer.php'; ?>
