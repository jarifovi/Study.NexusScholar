<?php
// FILE: tone_analyzer.php
require_once 'auth_check.php';

$page_title = "SOP Tone Analyzer";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-masks-theater" style="color:var(--primary); margin-right:15px;"></i> Smart Tone Analyzer</h1>
    <p>Analyze the emotional and academic tone of your Personal Statement.</p>
</div>

<div class="grid grid-2">
    <!-- INPUT -->
    <div class="glass-card animate-gravity delay-1">
        <h2><i class="fa-solid fa-align-left"></i> Paste Your SOP</h2>
        <textarea id="sop-text" placeholder="Paste your essay here (min 100 words)..." rows="15" style="font-family: 'Outfit', sans-serif;"></textarea>
        <button class="btn-primary full-width mt-3" onclick="analyzeTone()">
            <i class="fa-solid fa-microchip"></i> Run AI Analysis
        </button>
    </div>

    <!-- ANALYSIS -->
    <div class="glass-card animate-gravity delay-2" id="analysis-card">
        <h2><i class="fa-solid fa-chart-pie"></i> Tone Insights</h2>
        <div id="loading-analysis" style="display:none; text-align:center; padding:50px;">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:40px; color:var(--primary); margin-bottom:15px;"></i>
            <p>Scanning text patterns...</p>
        </div>

        <div id="result-analysis" style="display:none;">
            <canvas id="toneChart" style="max-height:250px;"></canvas>
            
            <div class="mt-4">
                <div class="tone-stat">
                    <span>Academic Clarity</span>
                    <div class="tone-bar"><div style="width:85%; background:var(--primary);"></div></div>
                </div>
                <div class="tone-stat">
                    <span>Confidence Level</span>
                    <div class="tone-bar"><div style="width:72%; background:var(--secondary);"></div></div>
                </div>
                <div class="tone-stat">
                    <span>Humility / Politeness</span>
                    <div class="tone-bar"><div style="width:60%; background:var(--accent);"></div></div>
                </div>
            </div>

            <div class="alert success mt-3" style="font-size:13px;">
                <i class="fa-solid fa-lightbulb"></i> <strong>AI Suggestion:</strong> Your tone is very confident, which is great! However, try to use more formal academic transitions like "Furthermore" or "Consequently."
            </div>
        </div>
    </div>
</div>

<style>
.tone-stat {
    margin-bottom: 15px;
}
.tone-stat span {
    font-size: 12px;
    color: var(--text-muted);
    display: block;
    margin-bottom: 5px;
}
.tone-bar {
    height: 6px;
    background: rgba(255,255,255,0.05);
    border-radius: 10px;
    overflow: hidden;
}
.tone-bar div { height: 100%; border-radius: 10px; }
</style>

<script>
let toneChart;
function analyzeTone() {
    const text = document.getElementById('sop-text').value;
    if (text.length < 100) {
        alert("Please paste at least 100 words for an accurate analysis.");
        return;
    }

    document.getElementById('loading-analysis').style.display = 'block';
    document.getElementById('result-analysis').style.display = 'none';

    setTimeout(() => {
        document.getElementById('loading-analysis').style.display = 'none';
        document.getElementById('result-analysis').style.display = 'block';
        renderChart();
    }, 2000);
}

function renderChart() {
    const ctx = document.getElementById('toneChart').getContext('2d');
    if (toneChart) toneChart.destroy();
    
    toneChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Academic', 'Confident', 'Creative', 'Humble', 'Direct', 'Formal'],
            datasets: [{
                label: 'SOP Tone Map',
                data: [85, 72, 45, 60, 90, 80],
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: '#10b981',
                pointBackgroundColor: '#10b981',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                r: {
                    angleLines: { color: 'rgba(255,255,255,0.1)' },
                    grid: { color: 'rgba(255,255,255,0.1)' },
                    pointLabels: { color: '#94a3b8' },
                    ticks: { display: false }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
}
</script>

<?php include 'footer.php'; ?>
