<?php
// FILE: audio_sandbox.php
require_once 'auth_check.php';

$page_title = "Visa Interview Sandbox";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-microphone-lines" style="color:var(--primary); margin-right:15px;"></i> Visa Interview Sandbox</h1>
    <p>Practice your interview answers, record your voice, and analyze your performance.</p>
</div>

<div class="grid grid-2">
    <!-- RECORDING INTERFACE -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-circle-play"></i> Recording Studio</h2>
        <div class="interview-question-box mb-4" style="background:rgba(255,255,255,0.03); padding:25px; border-radius:20px; border:1px solid var(--border-glass);">
            <p style="color:var(--primary); font-weight:700; font-size:12px; text-transform:uppercase; letter-spacing:1px; margin-bottom:10px;">Question for You:</p>
            <h3 id="question-display" style="color:#fff;">"Why did you choose this specific university for your Master's degree?"</h3>
        </div>

        <div style="text-align:center; padding:30px;">
            <div id="mic-animation" style="width:100px; height:100px; background:rgba(239,68,68,0.1); border-radius:50%; display:inline-flex; align-items:center; justify-content:center; margin-bottom:30px; border:2px solid transparent; transition:var(--transition);">
                <i class="fa-solid fa-microphone" id="mic-icon" style="font-size:40px; color:var(--danger);"></i>
            </div>
            
            <div id="timer-display" style="font-size:32px; font-weight:800; color:#fff; margin-bottom:30px; display:none;">00:00</div>

            <div style="display:flex; justify-content:center; gap:20px;">
                <button id="start-rec" class="btn-primary" style="background:var(--danger); border-color:var(--danger);" onclick="toggleRecording()">
                    <i class="fa-solid fa-circle"></i> Start Recording
                </button>
                <button id="next-q" class="btn-primary" onclick="nextQuestion()">
                    <i class="fa-solid fa-forward-step"></i> Next Question
                </button>
            </div>
        </div>
    </div>

    <!-- PREVIOUS RECORDINGS -->
    <div class="glass-card animate-gravity delay-2">
        <h2><i class="fa-solid fa-list-ul"></i> Review Session</h2>
        <div id="recording-list">
            <div class="recording-item">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <div>
                        <h4 style="margin:0;">Practice Session #1</h4>
                        <span style="font-size:11px; color:var(--text-muted);">May 09, 2026 • 0:45s</span>
                    </div>
                    <span class="badge" style="background:var(--primary);">Clear Audio</span>
                </div>
                <div class="audio-player-mock">
                    <div style="width:40px; height:40px; background:var(--primary); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer;"><i class="fa-solid fa-play"></i></div>
                    <div style="flex:1; height:4px; background:rgba(255,255,255,0.1); border-radius:10px; position:relative;">
                        <div style="width:30%; height:100%; background:var(--primary); border-radius:10px;"></div>
                    </div>
                </div>
            </div>
            
            <div class="alert warning mt-4" style="font-size:13px;">
                <i class="fa-solid fa-lightbulb"></i> <strong>Tip:</strong> Listen for filler words like "um" or "uh". Try to maintain eye contact even when practicing solo!
            </div>
        </div>
    </div>
</div>

<style>
.recording-item {
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--border-glass);
    border-radius: 20px;
    margin-bottom: 15px;
}
.audio-player-mock {
    display: flex;
    align-items: center;
    gap: 15px;
}
.recording-active #mic-animation {
    background: rgba(239,68,68,0.2);
    border-color: var(--danger);
    box-shadow: 0 0 30px rgba(239,68,68,0.4);
    animation: pulse-red 1.5s infinite;
}
@keyframes pulse-red {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>

<script>
const questions = [
    "Why did you choose this specific university for your Master's degree?",
    "How will you fund your studies in the UK?",
    "What are your plans after you complete your graduation?",
    "Have you ever traveled outside your home country before?",
    "Why don't you want to study this course in your home country?"
];
let currentQ = 0;
let isRecording = false;

function nextQuestion() {
    currentQ = (currentQ + 1) % questions.length;
    document.getElementById('question-display').innerText = `"${questions[currentQ]}"`;
}

function toggleRecording() {
    const btn = document.getElementById('start-rec');
    const container = document.querySelector('.glass-card');
    const timer = document.getElementById('timer-display');
    
    isRecording = !isRecording;
    
    if (isRecording) {
        btn.innerHTML = '<i class="fa-solid fa-stop"></i> Stop Recording';
        document.body.classList.add('recording-active');
        timer.style.display = 'block';
    } else {
        btn.innerHTML = '<i class="fa-solid fa-circle"></i> Start Recording';
        document.body.classList.remove('recording-active');
        timer.style.display = 'none';
        alert("Practice recording saved to review session!");
    }
}
</script>

<?php include 'footer.php'; ?>
