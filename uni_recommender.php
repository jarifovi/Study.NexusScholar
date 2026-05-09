<?php
// FILE: uni_recommender.php
require_once 'auth_check.php';
$page_title = "University Recommender";
$userId = $_SESSION['user_id'];

// Get student profile
$stmt = $pdo->prepare("SELECT full_name, cgpa_current, ielts_score FROM users WHERE id = ?");
$stmt->execute([$userId]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

$cgpa  = (float)($profile['cgpa_current'] ?? 0);
$ielts = (float)($profile['ielts_score'] ?? 0);

// Get all universities
$unis = $pdo->query("SELECT * FROM universities ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Classify by tier based on student's profile
$results = ['Reach' => [], 'Target' => [], 'Safe' => [], 'Ineligible' => []];
foreach ($unis as $u) {
    $meetsMin = ($cgpa >= $u['min_cgpa']) && ($ielts >= $u['min_ielts']);
    if (!$meetsMin) {
        $results['Ineligible'][] = $u;
        continue;
    }
    // further tier based on gap
    $cgpaGap  = $cgpa  - $u['min_cgpa'];
    $ieltsGap = $ielts - $u['min_ielts'];
    if ($cgpaGap >= 0.4 && $ieltsGap >= 0.5) {
        $tier = 'Safe';
    } elseif ($cgpaGap >= 0.1 && $ieltsGap >= 0.0) {
        $tier = 'Target';
    } else {
        $tier = 'Reach';
    }
    $results[$tier][] = $u;
}

include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-building-columns" style="color:var(--primary); margin-right:10px;"></i> University Recommender</h1>
    <p>Based on your academic profile — personalized Safe, Target & Reach picks.</p>
</div>

<!-- Profile Summary -->
<div class="glass-card animate-gravity delay-1" style="margin-bottom:25px;">
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:20px;">
        <div>
            <h2 style="font-size:20px; margin-bottom:5px;">
                <i class="fa-solid fa-user-graduate" style="color:var(--primary); margin-right:10px;"></i>
                Your Profile: <?= htmlspecialchars($profile['full_name']) ?>
            </h2>
            <p style="color:var(--text-muted); font-size:14px;">Recommendations are personalized based on your current CGPA and IELTS score.</p>
        </div>
        <div style="display:flex; gap:25px;">
            <div style="text-align:center;">
                <p style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">CGPA</p>
                <p style="font-size:32px; font-weight:800; background:linear-gradient(135deg,#38bdf8,#818cf8); -webkit-background-clip:text; -webkit-text-fill-color:transparent;"><?= number_format($cgpa, 2) ?></p>
            </div>
            <div style="text-align:center;">
                <p style="font-size:11px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; margin-bottom:5px;">IELTS</p>
                <p style="font-size:32px; font-weight:800; background:linear-gradient(135deg,#38bdf8,#818cf8); -webkit-background-clip:text; -webkit-text-fill-color:transparent;"><?= $ielts > 0 ? number_format($ielts, 1) : 'N/A' ?></p>
            </div>
        </div>
    </div>
    <?php if ($cgpa == 0 && $ielts == 0): ?>
    <div class="alert error" style="margin-top:15px; margin-bottom:0;">
        <i class="fa-solid fa-circle-exclamation" style="margin-right:10px;"></i>
        Your CGPA and IELTS are both 0. Please update your profile on the <a href="dashboard.php" style="color:var(--primary);">Dashboard</a> to get accurate recommendations.
    </div>
    <?php endif; ?>
</div>

<?php
$tierConfig = [
    'Safe'       => ['icon' => 'fa-shield-check',   'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.08)',  'border' => 'rgba(16,185,129,0.3)',  'label' => 'Safe Picks',   'desc' => 'Very likely to get admitted based on your profile.'],
    'Target'     => ['icon' => 'fa-bullseye',        'color' => '#818cf8', 'bg' => 'rgba(129,140,248,0.08)', 'border' => 'rgba(129,140,248,0.3)', 'label' => 'Target Picks', 'desc' => 'Good chances — meet minimum requirements comfortably.'],
    'Reach'      => ['icon' => 'fa-rocket',          'color' => '#f97316', 'bg' => 'rgba(249,115,22,0.08)',  'border' => 'rgba(249,115,22,0.3)',  'label' => 'Reach Picks',  'desc' => 'Competitive — you qualify, but acceptance is selective.'],
    'Ineligible' => ['icon' => 'fa-circle-xmark',    'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.08)', 'border' => 'rgba(107,114,128,0.2)', 'label' => 'Currently Out of Range', 'desc' => 'Does not meet minimum requirements yet. Improve your scores!'],
];

foreach ($tierConfig as $tier => $cfg):
    if (empty($results[$tier])) continue;
?>
<div style="margin-bottom:30px;" class="animate-gravity">
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:15px;">
        <div style="width:40px; height:40px; border-radius:50%; background:<?= $cfg['bg'] ?>; border:1px solid <?= $cfg['border'] ?>; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid <?= $cfg['icon'] ?>" style="color:<?= $cfg['color'] ?>;"></i>
        </div>
        <div>
            <h2 style="font-size:20px; font-weight:700; color:#fff; margin:0;"><?= $cfg['label'] ?> (<?= count($results[$tier]) ?>)</h2>
            <p style="font-size:13px; color:var(--text-muted); margin:0;"><?= $cfg['desc'] ?></p>
        </div>
    </div>
    
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap:16px;">
        <?php foreach ($results[$tier] as $u): ?>
        <div style="background:<?= $cfg['bg'] ?>; border:1px solid <?= $cfg['border'] ?>; border-radius:16px; padding:20px; transition:0.3s;"
             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.3)';"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px;">
                <h3 style="font-size:16px; font-weight:700; color:#fff; line-height:1.3;"><?= htmlspecialchars($u['name']) ?></h3>
                <span style="font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; background:<?= $cfg['bg'] ?>; color:<?= $cfg['color'] ?>; border:1px solid <?= $cfg['border'] ?>; white-space:nowrap; margin-left:8px;"><?= $tier ?></span>
            </div>
            
            <p style="font-size:13px; color:var(--text-muted); margin-bottom:10px;">
                <i class="fa-solid fa-globe" style="margin-right:6px; color:<?= $cfg['color'] ?>;"></i> <?= htmlspecialchars($u['country']) ?>
            </p>
            
            <?php if ($u['program_areas']): ?>
            <p style="font-size:12px; color:var(--text-muted); margin-bottom:12px; line-height:1.5;">
                <i class="fa-solid fa-book" style="margin-right:6px;"></i> <?= htmlspecialchars($u['program_areas']) ?>
            </p>
            <?php endif; ?>
            
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:15px;">
                <span style="font-size:12px; padding:4px 10px; border-radius:8px; background:rgba(56,189,248,0.1); color:var(--primary); font-weight:600;">Min CGPA: <?= number_format($u['min_cgpa'], 2) ?></span>
                <span style="font-size:12px; padding:4px 10px; border-radius:8px; background:rgba(129,140,248,0.1); color:var(--secondary); font-weight:600;">Min IELTS: <?= number_format($u['min_ielts'], 1) ?></span>
            </div>
            
            <?php if ($tier !== 'Ineligible'): ?>
            <a href="kanban.php" style="display:block; text-align:center; padding:10px; border-radius:10px; background:<?= $cfg['bg'] ?>; color:<?= $cfg['color'] ?>; font-size:13px; font-weight:600; text-decoration:none; border:1px solid <?= $cfg['border'] ?>; transition:0.2s;"
               onclick="sessionStorage.setItem('presetUni', '<?= addslashes($u['name']) ?>'); sessionStorage.setItem('presetCountry', '<?= addslashes($u['country']) ?>');">
                <i class="fa-solid fa-plus" style="margin-right:6px;"></i> Track This Application
            </a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<script>
// Pre-fill kanban form if coming from recommender
window.addEventListener('DOMContentLoaded', () => {
    const uni     = sessionStorage.getItem('presetUni');
    const country = sessionStorage.getItem('presetCountry');
    if (uni && document.getElementById('uniName')) {
        document.getElementById('uniName').value    = uni;
        document.getElementById('uniCountry').value = country;
        sessionStorage.removeItem('presetUni');
        sessionStorage.removeItem('presetCountry');
    }
});
</script>

<?php include 'footer.php'; ?>
