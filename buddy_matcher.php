<?php
// FILE: buddy_matcher.php
require_once 'auth_check.php';

$page_title = "Buddy Matcher";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-users-viewfinder" style="color:var(--primary); margin-right:15px;"></i> Nexus Buddy Matcher</h1>
    <p>Discover other students applying to the same universities or countries.</p>
</div>

<div class="glass-card animate-gravity mb-4">
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2><i class="fa-solid fa-magnifying-glass"></i> Search Criteria</h2>
            <p style="color:var(--text-muted);">Finding peers applying for Fall 2027...</p>
        </div>
        <div style="display:flex; gap:10px;">
            <select style="width:200px; margin:0;">
                <option>UK Universities</option>
                <option>USA Universities</option>
                <option>Canada Universities</option>
            </select>
            <button class="btn-primary" style="padding:12px 20px;">Find Buddies</button>
        </div>
    </div>
</div>

<div class="grid grid-3">
    <!-- Buddy 1 -->
    <div class="glass-card animate-gravity delay-1">
        <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
            <div style="width:50px; height:50px; background:#1e293b; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; color:var(--primary); border:1px solid var(--primary);">AS</div>
            <div>
                <h4 style="margin:0;">Adnan Sami</h4>
                <span style="font-size:12px; color:var(--text-muted);">From: Dhaka, BD</span>
            </div>
        </div>
        <div class="buddy-stats">
            <div class="tag">King's College London</div>
            <div class="tag">MSc Data Science</div>
        </div>
        <button class="btn-primary full-width mt-3" style="font-size:12px; padding:10px;"><i class="fa-solid fa-paper-plane"></i> Connect</button>
    </div>

    <!-- Buddy 2 -->
    <div class="glass-card animate-gravity delay-2">
        <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
            <div style="width:50px; height:50px; background:#1e293b; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; color:var(--secondary); border:1px solid var(--secondary);">NM</div>
            <div>
                <h4 style="margin:0;">Nabila M.</h4>
                <span style="font-size:12px; color:var(--text-muted);">From: Chittagong, BD</span>
            </div>
        </div>
        <div class="buddy-stats">
            <div class="tag">University of Oxford</div>
            <div class="tag">MBA</div>
        </div>
        <button class="btn-primary full-width mt-3" style="font-size:12px; padding:10px;"><i class="fa-solid fa-paper-plane"></i> Connect</button>
    </div>

    <!-- Buddy 3 -->
    <div class="glass-card animate-gravity delay-3">
        <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
            <div style="width:50px; height:50px; background:#1e293b; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; color:var(--accent); border:1px solid var(--accent);">RI</div>
            <div>
                <h4 style="margin:0;">Rafid Islam</h4>
                <span style="font-size:12px; color:var(--text-muted);">From: Sylhet, BD</span>
            </div>
        </div>
        <div class="buddy-stats">
            <div class="tag">KCL</div>
            <div class="tag">BSc Economics</div>
        </div>
        <button class="btn-primary full-width mt-3" style="font-size:12px; padding:10px;"><i class="fa-solid fa-paper-plane"></i> Connect</button>
    </div>
</div>

<style>
.tag {
    display: inline-block;
    padding: 5px 12px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    font-size: 11px;
    color: var(--text-muted);
    margin-bottom: 5px;
    margin-right: 5px;
}
</style>

<?php include 'footer.php'; ?>
