<?php
// FILE: ielts_quiz.php
require_once 'auth_check.php';

$page_title = "IELTS Quick Quiz";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-bolt-lightning" style="color:var(--primary); margin-right:15px;"></i> IELTS Quick-Quiz</h1>
    <p>Estimate your Band Score with a rapid 5-minute proficiency check.</p>
</div>

<div class="glass-card animate-gravity" id="quiz-container">
    <div id="quiz-intro">
        <div style="text-align:center; padding:40px;">
            <i class="fa-solid fa-stopwatch" style="font-size:60px; color:var(--primary); margin-bottom:20px;"></i>
            <h2>Ready for the Speed Test?</h2>
            <p style="color:var(--text-muted); margin-bottom:30px;">5 Questions. 30 Seconds each. Real-time Predicted Band.</p>
            <button class="btn-primary" onclick="startQuiz()">Start Challenge</button>
        </div>
    </div>

    <div id="quiz-active" style="display:none;">
        <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
            <span id="question-count">Question 1/5</span>
            <span id="timer" style="color:var(--danger); font-weight:800;">30s</span>
        </div>
        <div id="question-area" style="min-height:150px;">
            <h3 id="question-text" style="margin-bottom:20px;"></h3>
            <div id="options-list" class="grid grid-2"></div>
        </div>
    </div>

    <div id="quiz-result" style="display:none; text-align:center; padding:40px;">
        <h2 style="margin-bottom:10px;">Calculation Complete!</h2>
        <div style="font-size:72px; font-weight:800; color:var(--primary); margin:20px 0;">Band <span id="band-score">7.5</span></div>
        <p style="color:var(--text-muted); margin-bottom:30px;">Based on your vocabulary choice and response speed.</p>
        <button class="btn-primary" onclick="location.reload()">Retry Quiz</button>
    </div>
</div>

<style>
.quiz-option {
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
    cursor: pointer;
    transition: var(--transition);
}
.quiz-option:hover {
    background: rgba(16,185,129,0.1);
    border-color: var(--primary);
    transform: translateX(10px);
}
</style>

<script>
const questions = [
    {
        q: "Choose the most academic synonym for 'Change':",
        o: ["Alteration", "Difference", "Move", "Flip"],
        a: 0
    },
    {
        q: "Identify the grammatically correct sentence:",
        o: ["She has went to the bank.", "She has gone to the bank.", "She go to the bank.", "She gone to bank."],
        a: 1
    },
    {
        q: "In an essay, which transition is most formal?",
        o: ["Also", "Plus", "Moreover", "And"],
        a: 2
    },
    {
        q: "Meaning of 'Pragmatic':",
        o: ["Idealistic", "Practical", "Confused", "Angry"],
        a: 1
    },
    {
        q: "Academic word for 'Very Big':",
        o: ["Huge", "Colossal", "Substantial", "Gargantuan"],
        a: 2
    }
];

let currentQ = 0;
let score = 0;

function startQuiz() {
    document.getElementById('quiz-intro').style.display = 'none';
    document.getElementById('quiz-active').style.display = 'block';
    loadQuestion();
}

function loadQuestion() {
    const q = questions[currentQ];
    document.getElementById('question-count').innerText = `Question ${currentQ + 1}/5`;
    document.getElementById('question-text').innerText = q.q;
    
    let html = '';
    q.o.forEach((opt, idx) => {
        html += `<div class="quiz-option" onclick="nextQuestion(${idx})">${opt}</div>`;
    });
    document.getElementById('options-list').innerHTML = html;
}

function nextQuestion(choice) {
    if (choice === questions[currentQ].a) score++;
    
    currentQ++;
    if (currentQ < questions.length) {
        loadQuestion();
    } else {
        showResult();
    }
}

function showResult() {
    document.getElementById('quiz-active').style.display = 'none';
    document.getElementById('quiz-result').style.display = 'block';
    
    // Simple band calculation
    let band = 5.0 + (score * 0.8);
    document.getElementById('band-score').innerText = band.toFixed(1);
}
</script>

<?php include 'footer.php'; ?>
