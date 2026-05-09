<?php
// FILE: motivation_vault.php
require_once 'auth_check.php';

$page_title = "Motivation Vault";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-fire" style="color:var(--primary); margin-right:15px;"></i> Motivation Vault</h1>
    <p>Keep your dreams alive. Curate your vision of the future.</p>
</div>

<div class="grid grid-4" id="vault-grid">
    <!-- Static Items for demo -->
    <div class="glass-card animate-gravity delay-1 p-0 overflow-hidden" style="height:250px;">
        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&q=80&w=400" style="width:100%; height:100%; object-fit:cover;">
    </div>
    <div class="glass-card animate-gravity delay-2 p-0 overflow-hidden" style="height:250px; background:linear-gradient(135deg, var(--primary), var(--secondary)); display:flex; align-items:center; justify-content:center; padding:30px; text-align:center;">
        <h3 style="color:#fff; font-style:italic;">"The beautiful thing about learning is that no one can take it away from you."</h3>
    </div>
    <div class="glass-card animate-gravity delay-3 p-0 overflow-hidden" style="height:250px;">
        <img src="https://images.unsplash.com/photo-1541339907198-e08759df9a73?auto=format&fit=crop&q=80&w=400" style="width:100%; height:100%; object-fit:cover;">
    </div>
    <div class="glass-card animate-gravity delay-4 p-0 overflow-hidden" style="height:250px; border:2px dashed var(--border-glass); display:flex; flex-direction:column; align-items:center; justify-content:center; cursor:pointer;" onclick="alert('Upload feature coming soon!')">
        <i class="fa-solid fa-plus" style="font-size:40px; color:var(--text-dim); margin-bottom:10px;"></i>
        <span style="color:var(--text-dim);">Add Inspiration</span>
    </div>
</div>

<div class="glass-card mt-4 animate-gravity delay-5">
    <h2><i class="fa-solid fa-calendar-check"></i> Daily Manifestation</h2>
    <p style="color:var(--text-muted); font-size:18px;">Target Date: <strong>September 1, 2027</strong> - First Day of University in <strong>London</strong>.</p>
</div>

<?php include 'footer.php'; ?>
