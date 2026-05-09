<?php
// FILE: visa_simulator.php
require_once 'auth_check.php';
$page_title = "Visa Interview Simulator";

$questions = $pdo->query("SELECT * FROM visa_questions ORDER BY RAND()")->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-passport" style="color:var(--primary); margin-right:10px;"></i> Visa Interview Simulator</h1>
    <p>Practice your answers to common visa officer questions. 30 seconds per question!</p>
</div>

<div class="grid grid-2 mt-3" style="align-items:flex-start;">
    <!-- Simulator Card -->
    <div class="glass-card animate-gravity delay-1" style="text-align:center;">
        <div id="categoryBadge" style="display:inline-block; padding:6px 18px; border-radius:20px; background:rgba(56,189,248,0.1); color:var(--primary); font-size:13px; font-weight:600; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;"></div>
        
        <!-- Timer Ring -->
        <div style="position:relative; width:130px; height:130px; margin: 0 auto 25px;">
            <svg width="130" height="130" style="transform:rotate(-90deg)">
                <circle cx="65" cy="65" r="58" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="8"/>
                <circle id="timerRing" cx="65" cy="65" r="58" fill="none" stroke="url(#grad)" stroke-width="8"
                        stroke-dasharray="364" stroke-dashoffset="0" stroke-linecap="round" style="transition:stroke-dashoffset 1s linear;"/>
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#38bdf8"/>
                        <stop offset="100%" style="stop-color:#818cf8"/>
                    </linearGradient>
                </defs>
            </svg>
            <div id="timerText" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); font-size:36px; font-weight:800; color:#fff;">30</div>
        </div>
        
        <h2 id="questionText" style="font-size:20px; line-height:1.6; font-weight:600; color:#fff; min-height:80px; margin-bottom:25px;">
            Press "Start Practice" to begin.
        </h2>
        
        <!-- Tip area -->
        <div id="tipBox" style="display:none; background:rgba(16,185,129,0.1); border:1px solid rgba(16,185,129,0.3); border-radius:12px; padding:18px; margin-bottom:20px; text-align:left;">
            <p style="font-size:13px; font-weight:700; color:#10b981; margin-bottom:8px; text-transform:uppercase; letter-spacing:1px;"><i class="fa-solid fa-lightbulb" style="margin-right:6px;"></i> Expert Tip</p>
            <p id="tipText" style="font-size:14px; color:var(--text-muted); line-height:1.6;"></p>
        </div>
        
        <div style="display:flex; gap:12px; justify-content:center; flex-wrap:wrap;">
            <button class="btn-primary" onclick="startPractice()" id="startBtn">
                <i class="fa-solid fa-play" style="margin-right:8px;"></i> Start Practice
            </button>
            <button class="btn-primary" onclick="nextQuestion()" id="nextBtn" style="display:none; background:linear-gradient(135deg, #10b981, #059669);">
                <i class="fa-solid fa-forward-step" style="margin-right:8px;"></i> Next Question
            </button>
            <button class="btn-primary" onclick="showTip()" id="tipBtn" style="display:none; background:linear-gradient(135deg, #eab308, #ca8a04);">
                <i class="fa-solid fa-lightbulb" style="margin-right:8px;"></i> Show Tip
            </button>
        </div>
    </div>
    
    <!-- Progress & Stats -->
    <div style="display:flex; flex-direction:column; gap:20px;">
        <div class="glass-card animate-gravity delay-2">
            <h2><i class="fa-solid fa-chart-bar" style="color:var(--primary); margin-right:10px;"></i> Session Progress</h2>
            <div style="display:flex; justify-content:space-between; margin-top:15px; text-align:center;">
                <div>
                    <p class="stat-value" id="answeredCount" style="font-size:36px;">0</p>
                    <p style="color:var(--text-muted); font-size:13px; margin-top:5px;">Answered</p>
                </div>
                <div>
                    <p class="stat-value" id="totalCount" style="font-size:36px;"><?= count($questions) ?></p>
                    <p style="color:var(--text-muted); font-size:13px; margin-top:5px;">Total</p>
                </div>
                <div>
                    <p class="stat-value" id="skippedCount" style="font-size:36px;">0</p>
                    <p style="color:var(--text-muted); font-size:13px; margin-top:5px;">Skipped</p>
                </div>
            </div>
        </div>
        
        <div class="glass-card animate-gravity delay-3">
            <h2><i class="fa-solid fa-star" style="color:#eab308; margin-right:10px;"></i> Interview Tips</h2>
            <ul style="list-style:none; padding:0; margin-top:15px; display:flex; flex-direction:column; gap:12px; color:var(--text-muted); font-size:14px; line-height:1.5;">
                <li><i class="fa-solid fa-check" style="color:#10b981; margin-right:8px;"></i> Speak clearly, confidently, and concisely — avoid long pauses.</li>
                <li><i class="fa-solid fa-check" style="color:#10b981; margin-right:8px;"></i> Always state your intention to return to your home country after studies.</li>
                <li><i class="fa-solid fa-check" style="color:#10b981; margin-right:8px;"></i> Do not lie or exaggerate — consular officers are highly trained.</li>
                <li><i class="fa-solid fa-check" style="color:#10b981; margin-right:8px;"></i> Dress professionally, even for an online appointment.</li>
                <li><i class="fa-solid fa-check" style="color:#10b981; margin-right:8px;"></i> Carry all original documents, even if digital copies were submitted.</li>
            </ul>
        </div>
    </div>
</div>

<script>
const questions = <?= json_encode($questions) ?>;
let current = -1;
let timer = null;
let answeredCount = 0;
let skippedCount = 0;
const TOTAL_TIME = 30;
const CIRCUMFERENCE = 364;

function startPractice() {
    document.getElementById('startBtn').style.display = 'none';
    answeredCount = 0; skippedCount = 0;
    updateStats();
    nextQuestion();
}

function nextQuestion() {
    clearInterval(timer);
    document.getElementById('tipBox').style.display = 'none';
    document.getElementById('nextBtn').style.display = 'inline-flex';
    document.getElementById('tipBtn').style.display = 'inline-flex';
    
    if (current >= 0) {
        answeredCount++;
        updateStats();
    }
    
    current++;
    if (current >= questions.length) {
        endSession();
        return;
    }
    
    const q = questions[current];
    document.getElementById('questionText').innerText = q.question;
    document.getElementById('categoryBadge').innerText = q.category;
    document.getElementById('tipText').innerText = q.tip;
    document.getElementById('tipBox').style.display = 'none';
    startTimer();
}

function showTip() {
    document.getElementById('tipBox').style.display = 'block';
    document.getElementById('tipBtn').style.display = 'none';
}

function startTimer() {
    let timeLeft = TOTAL_TIME;
    updateTimerUI(timeLeft);
    
    timer = setInterval(() => {
        timeLeft--;
        updateTimerUI(timeLeft);
        if (timeLeft <= 0) {
            clearInterval(timer);
            showTip();
        }
    }, 1000);
}

function updateTimerUI(t) {
    const ring = document.getElementById('timerRing');
    const text = document.getElementById('timerText');
    const offset = CIRCUMFERENCE - (t / TOTAL_TIME) * CIRCUMFERENCE;
    ring.style.strokeDashoffset = offset;
    text.innerText = t;
    
    if (t <= 10) {
        ring.style.stroke = '#ef4444';
        text.style.color = '#ef4444';
    } else if (t <= 20) {
        ring.style.stroke = '#eab308';
        text.style.color = '#eab308';
    } else {
        ring.style.stroke = 'url(#grad)';
        text.style.color = '#fff';
    }
}

function updateStats() {
    document.getElementById('answeredCount').innerText = answeredCount;
    document.getElementById('skippedCount').innerText = skippedCount;
}

function endSession() {
    clearInterval(timer);
    document.getElementById('questionText').innerHTML = `<i class="fa-solid fa-party-horn" style="color:#eab308; margin-right:10px;"></i> Session Complete! You practiced ${answeredCount} questions.`;
    document.getElementById('categoryBadge').innerText = '✓ Done';
    document.getElementById('nextBtn').style.display = 'none';
    document.getElementById('tipBtn').style.display = 'none';
    document.getElementById('timerText').innerText = '✓';
    document.getElementById('timerRing').style.strokeDashoffset = 0;
    document.getElementById('startBtn').innerText = 'Restart Session';
    document.getElementById('startBtn').innerHTML = '<i class="fa-solid fa-rotate-left" style="margin-right:8px;"></i> Restart Session';
    document.getElementById('startBtn').style.display = 'inline-flex';
    current = -1;
}
</script>

<?php include 'footer.php'; ?>
