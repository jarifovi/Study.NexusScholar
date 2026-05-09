<?php
// FILE: doc_scanner.php
require_once 'auth_check.php';

$page_title = "Smart Document Scanner";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-expand" style="color:var(--primary); margin-right:15px;"></i> Smart Document Scanner</h1>
    <p>Simulate document parsing to extract your profile data.</p>
</div>

<div class="grid grid-2">
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-file-arrow-up"></i> Upload Transcript</h2>
        <div class="scanner-upload-box" id="upload-box">
            <input type="file" id="file-input" style="display:none;" onchange="startScan()">
            <div class="upload-inner" onclick="document.getElementById('file-input').click()">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <p>Click to Upload or Drag & Drop</p>
                <span>Supports PDF, JPG, PNG (Simulated)</span>
            </div>
        </div>

        <div id="scanner-animation" style="display:none; position:relative; margin-top:30px;">
            <div class="scanner-laser"></div>
            <div class="doc-mockup">
                <i class="fa-regular fa-file-lines"></i>
                <p>Analyzing University Transcript...</p>
            </div>
        </div>
    </div>

    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-microchip"></i> Extracted Insights</h2>
        <div id="extraction-result">
            <div class="empty-state">
                <p>Results will appear here after scanning.</p>
            </div>
        </div>
    </div>
</div>

<style>
.scanner-upload-box {
    border: 2px dashed var(--border-glass-bright);
    border-radius: 20px;
    padding: 60px 30px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
}

.scanner-upload-box:hover {
    background: rgba(16, 185, 129, 0.05);
    border-color: var(--primary);
}

.upload-inner i {
    font-size: 50px;
    color: var(--primary);
    margin-bottom: 15px;
}

.upload-inner span {
    font-size: 12px;
    color: var(--text-dim);
}

.scanner-laser {
    position: absolute;
    width: 100%;
    height: 4px;
    background: var(--primary);
    box-shadow: 0 0 15px var(--primary-glow);
    z-index: 5;
    animation: laserScan 2.5s infinite linear;
}

.doc-mockup {
    background: rgba(255,255,255,0.05);
    padding: 50px;
    border-radius: 10px;
    text-align: center;
    color: var(--text-muted);
}

.doc-mockup i { font-size: 80px; margin-bottom: 20px; }

@keyframes laserScan {
    0% { top: 0; }
    50% { top: 100%; }
    100% { top: 0; }
}

.insight-row {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
    border-bottom: 1px solid var(--border-glass);
}
</style>

<script>
function startScan() {
    const file = document.getElementById('file-input').files[0];
    if (!file) return;

    document.getElementById('upload-box').style.display = 'none';
    document.getElementById('scanner-animation').style.display = 'block';

    setTimeout(() => {
        finishScan();
    }, 4000);
}

function finishScan() {
    document.getElementById('scanner-animation').style.display = 'none';
    const result = document.getElementById('extraction-result');
    
    result.innerHTML = `
        <div class="alert success mb-3"><i class="fa-solid fa-check-circle"></i> Scan Complete!</div>
        <div class="insight-row"><span>Student Name:</span> <strong>Jarif Ovi</strong></div>
        <div class="insight-row"><span>Detected CGPA:</span> <strong>2.90</strong></div>
        <div class="insight-row"><span>Total Credits:</span> <strong>124</strong></div>
        <div class="insight-row"><span>University:</span> <strong>North South University</strong></div>
        <div class="insight-row"><span>Suggested Tier:</span> <span class="badge badge-active">Target</span></div>
        <button class="btn-primary full-width mt-3" onclick="location.reload()">Scan Another Document</button>
    `;
}
</script>

<?php include 'footer.php'; ?>
