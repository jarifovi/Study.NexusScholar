<?php
// FILE: odds_predictor.php
require_once 'auth_check.php';

$page_title = "Scholarship Odds Predictor";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-bullseye" style="color:var(--primary); margin-right:15px;"></i> Scholarship Odds Predictor</h1>
    <p>Predict your chances of securing a scholarship based on your profile.</p>
</div>

<div class="grid grid-2">
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-user-check"></i> Profile Audit</h2>
        <div class="form-group">
            <label>Current CGPA</label>
            <input type="number" id="odds-cgpa" step="0.1" value="3.5" oninput="predictOdds()">
        </div>
        <div class="form-group">
            <label>IELTS Score</label>
            <input type="number" id="odds-ielts" step="0.5" value="7.0" oninput="predictOdds()">
        </div>
        <div class="form-group">
            <label>Research Papers / Publications</label>
            <select id="odds-pubs" onchange="predictOdds()">
                <option value="0">None</option>
                <option value="1">1 Paper</option>
                <option value="2">2+ Papers</option>
            </select>
        </div>
        <div class="form-group">
            <label>Target Scholarship Tier</label>
            <select id="odds-tier" onchange="predictOdds()">
                <option value="1">Full Funding (Tier 1)</option>
                <option value="2">Partial Funding (Tier 2)</option>
                <option value="3">University Merit (Tier 3)</option>
            </select>
        </div>
    </div>

    <div class="glass-card animate-gravity delay-2 text-center" style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <div style="position:relative; width:200px; height:200px; margin-bottom:30px;">
            <svg viewBox="0 0 36 36" style="transform: rotate(-90deg); width:100%; height:100%;">
                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="3" />
                <path id="odds-circle" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="var(--primary)" stroke-width="3" stroke-dasharray="0, 100" style="transition: stroke-dasharray 1s ease;" />
            </svg>
            <div style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); font-size:42px; font-weight:800; color:var(--primary);">
                <span id="odds-percent">0</span>%
            </div>
        </div>
        <h3 id="odds-status">Evaluating Profile...</h3>
        <p id="odds-advice" style="color:var(--text-muted); margin-top:10px;">Your CGPA is competitive for Tier 2 funding.</p>
    </div>
</div>

<script>
function predictOdds() {
    const cgpa = parseFloat(document.getElementById('odds-cgpa').value) || 0;
    const ielts = parseFloat(document.getElementById('odds-ielts').value) || 0;
    const pubs = parseInt(document.getElementById('odds-pubs').value);
    const tier = parseInt(document.getElementById('odds-tier').value);

    let base = (cgpa / 4.0) * 60 + (ielts / 9.0) * 30 + (pubs * 5);
    
    // Penalize higher tiers
    if (tier === 1) base *= 0.7;
    else if (tier === 2) base *= 0.9;
    
    const final = Math.min(98, Math.max(5, Math.round(base)));
    
    document.getElementById('odds-percent').innerText = final;
    document.getElementById('odds-circle').setAttribute('stroke-dasharray', `${final}, 100`);
    
    let status = "Moderate Chance";
    let advice = "Strengthen your SOP to stand out.";
    if (final > 80) { status = "High Chance"; advice = "Excellent profile! Focus on your interview prep."; }
    else if (final < 40) { status = "Challenging"; advice = "Consider Tier 3 or retaking IELTS to boost score."; }
    
    document.getElementById('odds-status').innerText = status;
    document.getElementById('odds-advice').innerText = advice;
}

document.addEventListener('DOMContentLoaded', predictOdds);
</script>

<?php include 'footer.php'; ?>
