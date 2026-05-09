<?php
// FILE: lor_generator.php
require_once 'auth_check.php';

$page_title = "LOR Generator";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-file-signature" style="color:var(--primary); margin-right:15px;"></i> Smart LOR Generator</h1>
    <p>Draft professional Letters of Recommendation for your professors or employers.</p>
</div>

<div class="grid grid-2">
    <!-- INPUT FORM -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-pen-clip"></i> Letter Details</h2>
        <div class="form-group">
            <label>Referee Name (e.g., Prof. Dr. Smith)</label>
            <input type="text" id="referee-name" placeholder="Name of person recommending you">
        </div>
        <div class="form-group">
            <label>Relationship</label>
            <select id="relationship">
                <option value="Academic Professor">Academic Professor</option>
                <option value="Research Supervisor">Research Supervisor</option>
                <option value="Project Manager">Project Manager</option>
                <option value="Internship Supervisor">Internship Supervisor</option>
            </select>
        </div>
        <div class="form-group">
            <label>Key Achievements (Comma separated)</label>
            <textarea id="achievements" rows="3" placeholder="A+ in Calculus, Led the Robotics Club, Published Paper on AI..."></textarea>
        </div>
        <button class="btn-primary full-width mt-3" onclick="generateLOR()">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Draft LOR
        </button>
    </div>

    <!-- PREVIEW -->
    <div class="glass-card animate-gravity delay-2">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2><i class="fa-solid fa-eye"></i> Live Draft</h2>
            <button class="btn-primary" style="padding:8px 15px; font-size:12px;" onclick="copyToClipboard('lor-content')">
                <i class="fa-solid fa-copy"></i> Copy
            </button>
        </div>
        <div id="lor-content" class="academic-preview" style="min-height:300px; padding:30px; line-height:1.6;">
            <p style="color:var(--text-dim);">Your draft will appear here after clicking "Draft LOR".</p>
        </div>
    </div>
</div>

<script>
function generateLOR() {
    const referee = document.getElementById('referee-name').value || "[Referee Name]";
    const rel = document.getElementById('relationship').value;
    const ach = document.getElementById('achievements').value || "[Achievements]";
    const name = "<?= htmlspecialchars($_SESSION['user_name']) ?>";

    const draft = `
        <div style="font-family: serif; color: #334155;">
            <p style="margin-bottom:20px;">To Whom It May Concern,</p>
            <p>I am writing this letter to highly recommend <strong>${name}</strong> for admission to your esteemed university. As ${name}'s <strong>${rel}</strong>, I have had the pleasure of observing their academic and professional growth first-hand.</p>
            <p>During our time together, ${name} demonstrated exceptional dedication and talent. Specifically, they were recognized for <strong>${ach}</strong>. Their ability to handle complex challenges and collaborate with peers is truly commendable.</p>
            <p>In addition to their technical skills, ${name} possesses a curious mind and a professional attitude that will undoubtedly make them an asset to your academic community.</p>
            <p>Please feel free to contact me if you require further information.</p>
            <p style="margin-top:40px;">Sincerely,<br><br><strong>${referee}</strong></p>
        </div>
    `;

    document.getElementById('lor-content').innerHTML = draft;
}

function copyToClipboard(id) {
    const el = document.getElementById(id);
    const range = document.createRange();
    range.selectNode(el);
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
    alert("LOR copied to clipboard!");
}
</script>

<?php include 'footer.php'; ?>
