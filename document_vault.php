<?php
// FILE: document_vault.php
require_once 'auth_check.php';
$page_title = "Smart Document Vault";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-file-shield" style="color:var(--primary); margin-right:10px;"></i> Smart Document Vault</h1>
    <p>Track your study abroad application documents securely.</p>
</div>

<div class="grid grid-2 mt-3">
    <div class="glass-card animate-gravity delay-1">
        <h2 style="display:flex; justify-content:space-between; align-items:center;">
            <span><i class="fa-solid fa-list-check" style="margin-right:10px; color:var(--secondary);"></i> Checklist</span>
            <span id="progressText" style="font-size:16px; font-weight:700; color:var(--primary);">0%</span>
        </h2>
        
        <div style="width:100%; height:8px; background:rgba(255,255,255,0.1); border-radius:4px; margin-bottom:20px; overflow:hidden;">
            <div id="progressBar" style="height:100%; width:0%; background:linear-gradient(90deg, var(--primary), var(--secondary)); transition:width 0.4s ease;"></div>
        </div>
        
        <div class="doc-list" id="docList">
            <!-- Rendered by JS -->
        </div>
        
        <button class="btn-primary full-width" style="margin-top:20px;" onclick="resetDocs()">
            <i class="fa-solid fa-rotate-left" style="margin-right:8px;"></i> Reset Progress
        </button>
    </div>
    
    <div class="glass-card animate-gravity delay-2" style="align-self: flex-start;">
        <h2><i class="fa-solid fa-lightbulb" style="margin-right:10px; color:#eab308;"></i> Document Tips</h2>
        <div style="background:rgba(255,255,255,0.02); padding:20px; border-radius:12px; border:1px solid var(--border-glass);">
            <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:15px; color:var(--text-muted); font-size:14px; line-height:1.6;">
                <li><i class="fa-solid fa-passport" style="color:var(--primary); margin-right:10px; width:16px;"></i> <strong style="color:#fff;">Passport:</strong> Ensure it's valid for at least 6 months beyond your intended stay.</li>
                <li><i class="fa-solid fa-file-contract" style="color:var(--primary); margin-right:10px; width:16px;"></i> <strong style="color:#fff;">Transcripts:</strong> Must be officially translated if not originally in English. Keep digital copies handy.</li>
                <li><i class="fa-solid fa-pen-nib" style="color:var(--primary); margin-right:10px; width:16px;"></i> <strong style="color:#fff;">SOP:</strong> Tailor your Statement of Purpose to the specific university and course. Avoid generic templates.</li>
                <li><i class="fa-solid fa-money-check-dollar" style="color:var(--primary); margin-right:10px; width:16px;"></i> <strong style="color:#fff;">Financials:</strong> Bank statements should clearly show the required funds held for at least 28 consecutive days.</li>
                <li><i class="fa-solid fa-user-tie" style="color:var(--primary); margin-right:10px; width:16px;"></i> <strong style="color:#fff;">LORs:</strong> Academic references are usually required for Bachelor's/Master's; professional ones for MBA.</li>
            </ul>
        </div>
    </div>
</div>

<style>
.doc-item {
    display: flex; align-items: center; padding: 15px; border: 1px solid var(--border-glass); 
    border-radius: 12px; margin-bottom: 10px; background: rgba(0,0,0,0.2); transition: 0.3s;
    cursor: pointer;
}
.doc-item:hover { background: rgba(255,255,255,0.05); border-color: var(--primary); }
.doc-item.checked { background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.3); }
.doc-item.checked .doc-title { text-decoration: line-through; color: var(--text-muted); }
.custom-checkbox { 
    width: 24px; height: 24px; border: 2px solid var(--text-muted); border-radius: 6px; 
    margin-right: 15px; display: flex; align-items: center; justify-content: center; transition: 0.2s;
}
.doc-item.checked .custom-checkbox { background: #10b981; border-color: #10b981; }
.doc-item.checked .custom-checkbox::after { content: '\f00c'; font-family: 'Font Awesome 6 Free'; font-weight: 900; color: #fff; font-size: 14px; }
.doc-title { font-weight: 500; font-size: 15px; color: #fff; transition: 0.2s; }
</style>

<script>
const docs = [
    { id: 'doc1', title: 'Valid Passport' },
    { id: 'doc2', title: 'Academic Transcripts' },
    { id: 'doc3', title: 'IELTS / TOEFL Score' },
    { id: 'doc4', title: 'Statement of Purpose (SOP)' },
    { id: 'doc5', title: 'Letters of Recommendation (x2)' },
    { id: 'doc6', title: 'Updated CV / Resume' },
    { id: 'doc7', title: 'Financial Proof (Bank Statement)' },
    { id: 'doc8', title: 'Portfolio (If applicable)' }
];

function loadDocs() {
    const list = document.getElementById('docList');
    list.innerHTML = '';
    
    docs.forEach(doc => {
        const isChecked = localStorage.getItem('ns_doc_' + doc.id) === 'true';
        
        const div = document.createElement('div');
        div.className = `doc-item ${isChecked ? 'checked' : ''}`;
        div.onclick = () => toggleDoc(doc.id, div);
        
        div.innerHTML = `
            <div class="custom-checkbox"></div>
            <div class="doc-title">${doc.title}</div>
        `;
        list.appendChild(div);
    });
    
    updateProgress();
}

function toggleDoc(id, element) {
    const currentState = localStorage.getItem('ns_doc_' + id) === 'true';
    const newState = !currentState;
    localStorage.setItem('ns_doc_' + id, newState);
    
    if(newState) element.classList.add('checked');
    else element.classList.remove('checked');
    
    updateProgress();
}

function updateProgress() {
    let checkedCount = 0;
    docs.forEach(doc => {
        if(localStorage.getItem('ns_doc_' + doc.id) === 'true') checkedCount++;
    });
    
    const pct = Math.round((checkedCount / docs.length) * 100);
    document.getElementById('progressBar').style.width = pct + '%';
    document.getElementById('progressText').innerText = pct + '%';
}

function resetDocs() {
    if(confirm('Are you sure you want to reset your document checklist?')) {
        docs.forEach(doc => localStorage.removeItem('ns_doc_' + doc.id));
        loadDocs();
    }
}

document.addEventListener('DOMContentLoaded', loadDocs);
</script>

<?php include 'footer.php'; ?>
