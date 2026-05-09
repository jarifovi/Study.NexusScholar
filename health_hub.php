<?php
// FILE: health_hub.php
require_once 'auth_check.php';

$page_title = "Global Health Hub";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-heart-pulse" style="color:var(--primary); margin-right:15px;"></i> Global Health Hub</h1>
    <p>Understand mandatory student health insurance and stay safe abroad.</p>
</div>

<div class="grid grid-2">
    <!-- Insurance Guide -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-shield-heart"></i> Mandatory Insurance</h2>
        <div class="cost-item">
            <div><strong>IHS (UK)</strong><br><small>Immigration Health Surcharge</small></div>
            <div style="text-align:right;"><strong>£776</strong><br><small>/year</small></div>
        </div>
        <div class="cost-item">
            <div><strong>OSHC (Australia)</strong><br><small>Overseas Student Health Cover</small></div>
            <div style="text-align:right;"><strong>A$600+</strong><br><small>/year</small></div>
        </div>
        <div class="cost-item">
            <div><strong>UHIP (Canada)</strong><br><small>University Health Insurance Plan</small></div>
            <div style="text-align:right;"><strong>C$756</strong><br><small>/year</small></div>
        </div>
        
        <p class="help-text mt-3">Insurance is usually required before the visa can be issued or upon arrival at university.</p>
    </div>

    <!-- Health Checklist -->
    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-laptop-medical"></i> Health Prep Checklist</h2>
        <div class="check-item"><i class="fa-solid fa-circle-check" style="color:var(--primary);"></i> <span>Full Medical Checkup</span></div>
        <div class="check-item"><i class="fa-solid fa-circle-check" style="color:var(--primary);"></i> <span>TB Test (if required for visa)</span></div>
        <div class="check-item"><i class="fa-solid fa-circle-check" style="color:var(--primary);"></i> <span>Carry Prescription Copies</span></div>
        <div class="check-item"><i class="fa-solid fa-circle-check" style="color:var(--primary);"></i> <span>Emergency Contacts Card</span></div>
        <div class="check-item"><i class="fa-solid fa-circle-check" style="color:var(--primary);"></i> <span>Dental Checkup (Abroad is expensive!)</span></div>
    </div>
</div>

<style>
.cost-item {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
    margin-bottom: 15px;
}
.check-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid var(--border-glass);
    color: var(--text-muted);
}
</style>

<?php include 'footer.php'; ?>
