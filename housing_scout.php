<?php
// FILE: housing_scout.php
require_once 'auth_check.php';

$page_title = "Housing Scout";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-hotel" style="color:var(--primary); margin-right:15px;"></i> Student Housing Scout</h1>
    <p>Find and shortlist verified student accommodations near your campus.</p>
</div>

<div class="grid grid-3">
    <!-- Property 1 -->
    <div class="glass-card animate-gravity delay-1 p-0 overflow-hidden">
        <div style="height:180px; background: url('https://images.unsplash.com/photo-1555854816-80572886f44d?auto=format&fit=crop&q=80&w=400') center/cover;">
            <div style="padding:10px;"><span class="badge badge-active" style="background:rgba(16,185,129,0.9);">Verified</span></div>
        </div>
        <div style="padding:20px;">
            <h3 style="margin-bottom:5px;">Chapter Spitalfields</h3>
            <p style="font-size:12px; color:var(--text-muted); margin-bottom:15px;"><i class="fa-solid fa-location-dot"></i> London, UK (Near KCL)</p>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:20px; font-weight:800; color:var(--primary);">£285<small style="font-size:12px; font-weight:400; color:var(--text-dim);">/wk</small></span>
                <button class="btn-primary" style="padding:8px 16px; font-size:12px;">Shortlist</button>
            </div>
        </div>
    </div>

    <!-- Property 2 -->
    <div class="glass-card animate-gravity delay-2 p-0 overflow-hidden">
        <div style="height:180px; background: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&q=80&w=400') center/cover;">
            <div style="padding:10px;"><span class="badge badge-active" style="background:rgba(16,185,129,0.9);">Popular</span></div>
        </div>
        <div style="padding:20px;">
            <h3 style="margin-bottom:5px;">Scape Wembley</h3>
            <p style="font-size:12px; color:var(--text-muted); margin-bottom:15px;"><i class="fa-solid fa-location-dot"></i> London, UK (Near UCL)</p>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:20px; font-weight:800; color:var(--primary);">£215<small style="font-size:12px; font-weight:400; color:var(--text-dim);">/wk</small></span>
                <button class="btn-primary" style="padding:8px 16px; font-size:12px;">Shortlist</button>
            </div>
        </div>
    </div>

    <!-- Property 3 -->
    <div class="glass-card animate-gravity delay-3 p-0 overflow-hidden">
        <div style="height:180px; background: url('https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?auto=format&fit=crop&q=80&w=400') center/cover;">
            <div style="padding:10px;"><span class="badge badge-active" style="background:rgba(245,158,11,0.9);">Limited</span></div>
        </div>
        <div style="padding:20px;">
            <h3 style="margin-bottom:5px;">The Social Hub</h3>
            <p style="font-size:12px; color:var(--text-muted); margin-bottom:15px;"><i class="fa-solid fa-location-dot"></i> Berlin, Germany</p>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:20px; font-weight:800; color:var(--primary);">€750<small style="font-size:12px; font-weight:400; color:var(--text-dim);">/mo</small></span>
                <button class="btn-primary" style="padding:8px 16px; font-size:12px;">Shortlist</button>
            </div>
        </div>
    </div>
</div>

<div class="glass-card mt-4 animate-gravity delay-4">
    <div style="display:flex; align-items:center; gap:20px;">
        <div style="font-size:40px; color:var(--primary);"><i class="fa-solid fa-map-location-dot"></i></div>
        <div>
            <h2>Interactive Map Coming Soon</h2>
            <p style="color:var(--text-muted);">We are integrating Mapbox to show proximity to universities and public transport.</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
