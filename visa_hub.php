<?php
// FILE: visa_hub.php
require_once 'auth_check.php';

$page_title = "Visa Document Hub";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-passport" style="color:var(--primary); margin-right:15px;"></i> Visa Document Hub</h1>
    <p>Prepare your documents for the target country visa interview.</p>
</div>

<div class="grid grid-3 mb-4">
    <div class="glass-card stat-card animate-gravity delay-1" onclick="loadChecklist('USA')" style="cursor:pointer;">
        <i class="fa-solid fa-flag-usa" style="font-size:30px; color:#fff; margin-bottom:10px;"></i>
        <h3>USA (F1)</h3>
        <p style="font-size:12px; color:var(--text-muted);">I-20, SEVIS, DS-160</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-2" onclick="loadChecklist('UK')" style="cursor:pointer;">
        <i class="fa-solid fa-crown" style="font-size:30px; color:#fff; margin-bottom:10px;"></i>
        <h3>UK (Student)</h3>
        <p style="font-size:12px; color:var(--text-muted);">CAS, TB Test, IHS</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-3" onclick="loadChecklist('Canada')" style="cursor:pointer;">
        <i class="fa-solid fa-leaf" style="font-size:30px; color:#fff; margin-bottom:10px;"></i>
        <h3>Canada (SP)</h3>
        <p style="font-size:12px; color:var(--text-muted);">LOA, GIC, CAQ</p>
    </div>
</div>

<div id="checklist-area" style="display:none;">
    <div class="glass-card animate-gravity">
        <h2 id="country-title">USA Visa Checklist</h2>
        <div id="checklist-items">
            <!-- Items injected by JS -->
        </div>
        <div class="mt-4 p-3" style="background:rgba(16,185,129,0.05); border-radius:15px; border:1px solid var(--border-glass);">
            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span>Preparation Progress</span>
                <span id="progress-text">0%</span>
            </div>
            <div style="height:10px; background:rgba(255,255,255,0.05); border-radius:10px; overflow:hidden;">
                <div id="progress-bar" style="height:100%; width:0%; background:linear-gradient(to right, var(--primary), var(--secondary)); transition: width 0.5s;"></div>
            </div>
        </div>
    </div>
</div>

<style>
.check-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border-bottom: 1px solid var(--border-glass);
    transition: var(--transition);
}
.check-item:hover { background: rgba(255,255,255,0.02); }
.check-item input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: var(--primary);
    cursor: pointer;
}
.check-item label { margin-bottom:0; cursor: pointer; flex:1; }
</style>

<script>
const checklists = {
    USA: [
        "Valid Passport",
        "Form I-20 (Signed)",
        "SEVIS Fee Receipt (I-901)",
        "DS-160 Confirmation Page",
        "Visa Appointment Letter",
        "Bank Statements (Last 6 Months)",
        "SOP for Visa",
        "Academic Transcripts & Certificates"
    ],
    UK: [
        "Valid Passport",
        "CAS Letter",
        "Financial Evidence (Bank Statements)",
        "TB Test Certificate",
        "IHS Payment Confirmation",
        "Academic Transcripts",
        "ATAS Certificate (if required)"
    ],
    Canada: [
        "Valid Passport",
        "Letter of Acceptance (LOA)",
        "GIC Certificate ($20,635+)",
        "Proof of Tuition Payment",
        "Medical Exam Receipt",
        "SOP / Study Plan",
        "Digital Photo (Visa Spec)"
    ]
};

function loadChecklist(country) {
    const area = document.getElementById('checklist-area');
    const title = document.getElementById('country-title');
    const items = document.getElementById('checklist-items');
    
    area.style.display = 'block';
    title.innerText = `${country} Visa Checklist`;
    
    let html = '';
    checklists[country].forEach((item, index) => {
        html += `
            <div class="check-item">
                <input type="checkbox" id="item-${index}" onchange="updateProgress()">
                <label for="item-${index}">${item}</label>
            </div>
        `;
    });
    items.innerHTML = html;
    updateProgress();
    
    area.scrollIntoView({ behavior: 'smooth' });
}

function updateProgress() {
    const checks = document.querySelectorAll('#checklist-items input[type="checkbox"]');
    const total = checks.length;
    const checked = Array.from(checks).filter(c => c.checked).length;
    const percent = total > 0 ? Math.round((checked / total) * 100) : 0;
    
    document.getElementById('progress-bar').style.width = percent + '%';
    document.getElementById('progress-text').innerText = percent + '%';
}
</script>

<?php include 'footer.php'; ?>
