<?php
// FILE: vibe_matcher.php
require_once 'auth_check.php';

$page_title = "University Vibe Matcher";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-masks-theater" style="color:var(--primary); margin-right:15px;"></i> University Vibe Matcher</h1>
    <p>Find the university that matches your lifestyle and personality.</p>
</div>

<div class="glass-card animate-gravity" id="quiz-container">
    <div id="vibe-intro" style="text-align:center; padding:50px;">
        <i class="fa-solid fa-wand-magic-sparkles" style="font-size:60px; color:var(--primary); margin-bottom:20px;"></i>
        <h2>What's your Academic Personality?</h2>
        <p style="color:var(--text-muted); margin-bottom:30px;">Discover the campus culture where you'll truly belong.</p>
        <button class="btn-primary" onclick="startVibeQuiz()">Start Vibe Check</button>
    </div>

    <div id="vibe-quiz" style="display:none;">
        <div style="margin-bottom:30px; text-align:center;">
            <h3 id="vibe-question">How do you prefer to spend your weekends?</h3>
        </div>
        <div id="vibe-options" class="grid grid-2">
            <!-- Options injected by JS -->
        </div>
    </div>

    <div id="vibe-result" style="display:none; text-align:center; padding:50px;">
        <h2 style="margin-bottom:10px;">Your Perfect Match:</h2>
        <div id="match-name" style="font-size:48px; font-weight:800; color:var(--primary); margin:20px 0;">The Urban Explorer</div>
        <p id="match-desc" style="color:var(--text-muted); font-size:18px; margin-bottom:30px;">You thrive in fast-paced cities with a vibrant social scene.</p>
        <div class="alert success" style="display:inline-block;">Recommended: <strong>King's College London</strong> or <strong>NYU</strong></div>
        <br><br>
        <button class="btn-primary" onclick="location.reload()">Retake Vibe Check</button>
    </div>
</div>

<style>
.vibe-opt {
    padding: 30px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    cursor: pointer;
    transition: var(--transition);
    text-align: center;
}
.vibe-opt:hover {
    background: rgba(16,185,129,0.1);
    border-color: var(--primary);
    transform: translateY(-5px);
}
.vibe-opt i { font-size: 32px; color: var(--primary); margin-bottom: 15px; display: block; }
</style>

<script>
const questions = [
    {
        q: "What's your ideal study environment?",
        o: [
            { t: "Grand, Quiet Library", i: "fa-book-open", v: "academic" },
            { t: "Lively City Cafe", i: "fa-coffee", v: "urban" },
            { t: "Modern High-Tech Lab", i: "fa-microchip", v: "research" },
            { t: "Campus Green Spaces", i: "fa-tree", v: "social" }
        ]
    },
    {
        q: "How do you handle social life?",
        o: [
            { t: "Close-knit study groups", i: "fa-users-rectangle", v: "academic" },
            { t: "Exploring city nightlife", i: "fa-city", v: "urban" },
            { t: "Joining innovation clubs", i: "fa-lightbulb", v: "research" },
            { t: "Large campus parties", i: "fa-glass-cheers", v: "social" }
        ]
    }
];

let currentQ = 0;
let scores = { academic: 0, urban: 0, research: 0, social: 0 };

function startVibeQuiz() {
    document.getElementById('vibe-intro').style.display = 'none';
    document.getElementById('vibe-quiz').style.display = 'block';
    loadVibeQuestion();
}

function loadVibeQuestion() {
    const q = questions[currentQ];
    document.getElementById('vibe-question').innerText = q.q;
    let html = '';
    q.o.forEach(opt => {
        html += `<div class="vibe-opt" onclick="recordVibe('${opt.v}')">
            <i class="fa-solid ${opt.i}"></i>
            <span>${opt.t}</span>
        </div>`;
    });
    document.getElementById('vibe-options').innerHTML = html;
}

function recordVibe(val) {
    scores[val]++;
    currentQ++;
    if (currentQ < questions.length) {
        loadVibeQuestion();
    } else {
        showVibeResult();
    }
}

function showVibeResult() {
    document.getElementById('vibe-quiz').style.display = 'none';
    const result = document.getElementById('vibe-result');
    result.style.display = 'block';
    
    // Simple logic to find highest score
    const top = Object.keys(scores).reduce((a, b) => scores[a] > scores[b] ? a : b);
    
    const results = {
        urban: { name: "The Urban Explorer", desc: "You thrive in fast-paced cities with a vibrant social scene.", rec: "KCL or NYU" },
        academic: { name: "The Classic Scholar", desc: "You prefer historic institutions with deep academic traditions.", rec: "Oxford or Cambridge" },
        research: { name: "The Innovator", desc: "You are driven by cutting-edge technology and future solutions.", rec: "MIT or ETH Zurich" },
        social: { name: "The Community Leader", desc: "You value campus spirit, sports, and a strong sense of belonging.", rec: "Stanford or Ohio State" }
    };
    
    document.getElementById('match-name').innerText = results[top].name;
    document.getElementById('match-desc').innerText = results[top].desc;
    result.querySelector('.alert strong').innerText = results[top].rec;
}
</script>

<?php include 'footer.php'; ?>
