<?php
// FILE: sop_architect.php
require_once 'auth_check.php';

$page_title = "SOP Architect";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-pen-nib" style="color:var(--primary); margin-right:15px;"></i> SOP Architect</h1>
    <p>Craft a compelling Statement of Purpose with our guided builder.</p>
</div>

<div class="grid grid-2 mt-3">
    <!-- LEFT: BUILDER -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-wand-magic-sparkles"></i> Draft Your SOP</h2>
        
        <div class="sop-steps">
            <div class="form-group">
                <label><i class="fa-solid fa-user-graduate"></i> Academic Background</label>
                <textarea id="sop-academic" placeholder="Describe your previous studies, key projects, and academic achievements..." rows="4"></textarea>
                <p class="help-text">Focus on how your past education prepared you for this new degree.</p>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-building-columns"></i> Why This University?</label>
                <textarea id="sop-why-uni" placeholder="Explain why you chose this specific institution over others..." rows="4"></textarea>
                <p class="help-text">Mention specific professors, research labs, or unique curriculum modules.</p>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-briefcase"></i> Future Career Goals</label>
                <textarea id="sop-goals" placeholder="Where do you see yourself 5-10 years after graduation?" rows="4"></textarea>
                <p class="help-text">Connect the degree to your long-term professional aspirations.</p>
            </div>

            <button class="btn-primary full-width" onclick="generatePreview()">
                <i class="fa-solid fa-file-export"></i> Generate SOP Preview
            </button>
        </div>
    </div>

    <!-- RIGHT: PREVIEW -->
    <div class="glass-card animate-gravity delay-2" id="sop-preview-card">
        <h2><i class="fa-solid fa-eye"></i> Live Preview</h2>
        <div class="sop-preview-area" id="sop-output">
            <div class="empty-state">
                <i class="fa-solid fa-i-cursor"></i>
                <p>Start typing on the left to see your professional SOP take shape here.</p>
            </div>
        </div>
        <div class="mt-3" id="preview-actions" style="display:none;">
            <button class="btn-primary" onclick="copySOP()">
                <i class="fa-solid fa-copy"></i> Copy to Clipboard
            </button>
        </div>
    </div>
</div>

<style>
.help-text {
    font-size: 12px;
    color: var(--text-dim);
    margin-top: -15px;
    margin-bottom: 20px;
    font-style: italic;
}

.sop-preview-area {
    background: rgba(0,0,0,0.4);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
    padding: 30px;
    min-height: 400px;
    color: #e2e8f0;
    line-height: 1.8;
    white-space: pre-wrap;
    font-family: 'Times New Roman', serif; /* Classic academic look */
    font-size: 16px;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 300px;
    color: var(--text-dim);
    text-align: center;
}

.empty-state i {
    font-size: 40px;
    margin-bottom: 15px;
    opacity: 0.3;
}
</style>

<script>
function generatePreview() {
    const academic = document.getElementById('sop-academic').value;
    const whyUni = document.getElementById('sop-why-uni').value;
    const goals = document.getElementById('sop-goals').value;
    const output = document.getElementById('sop-output');
    const actions = document.getElementById('preview-actions');

    if (!academic && !whyUni && !goals) {
        alert("Please fill in at least one section!");
        return;
    }

    let sop = `STATEMENT OF PURPOSE\n\n`;
    
    if (academic) {
        sop += `Academic Foundation:\n${academic}\n\n`;
    }
    
    if (whyUni) {
        sop += `Institutional Motivation:\n${whyUni}\n\n`;
    }
    
    if (goals) {
        sop += `Long-term Aspirations:\n${goals}\n\n`;
    }

    output.innerHTML = sop;
    actions.style.display = 'block';
    
    // Smooth scroll to preview on mobile
    if (window.innerWidth < 768) {
        output.scrollIntoView({ behavior: 'smooth' });
    }
}

function copySOP() {
    const text = document.getElementById('sop-output').innerText;
    navigator.clipboard.writeText(text).then(() => {
        alert("SOP copied to clipboard!");
    });
}
</script>

<?php include 'footer.php'; ?>
