<?php
// FILE: dashboard.php
require_once 'auth_check.php';

$userId = $_SESSION['user_id'];

// load current CGPA
$stmt = $pdo->prepare("SELECT cgpa_current, ielts_score FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// semesters summary
$stmt = $pdo->prepare("SELECT COUNT(*) as total, AVG(cgpa) as avg_cgpa, MAX(cgpa) as max_cgpa FROM semesters WHERE user_id = ?");
$stmt->execute([$userId]);
$semStats = $stmt->fetch(PDO::FETCH_ASSOC);

// eligibility score
$stmt = $pdo->prepare("SELECT eng101, eng103, eng105 FROM english_scores WHERE user_id = ?");
$stmt->execute([$userId]);
$eng = $stmt->fetch(PDO::FETCH_ASSOC);
$engAvg = $eng ? ($eng['eng101'] + $eng['eng103'] + $eng['eng105']) / 3 : 0;

$cgpa = (float)($user['cgpa_current'] ?? 0);
$eligScore = (int)round(($cgpa / 4.0) * 40 + ($engAvg / 100) * 60);

// scholarship count (simple)
$stmt = $pdo->query("SELECT COUNT(*) as c FROM scholarships");
$totalScholarships = $stmt->fetchColumn();

$page_title = "Dashboard";
include 'header.php';
include 'sidebar.php';
?>
<div class="page-title">
    <h1>Dashboard</h1>
    <p>Overview of your study abroad readiness.</p>
</div>

<div class="grid grid-3">
    <div class="glass-card stat-card animate-gravity delay-1">
        <h3><i class="fa-solid fa-graduation-cap" style="color:var(--primary); margin-right:8px;"></i> Current CGPA</h3>
        <p class="stat-value"><?= number_format($cgpa, 2) ?></p>
        <p style="font-size:13px; color:var(--text-muted); margin-top:10px;">Across <?= (int)($semStats['total'] ?? 0) ?> semesters</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-2">
        <h3><i class="fa-solid fa-star-half-stroke" style="color:var(--warning); margin-right:8px;"></i> Eligibility Score</h3>
        <p class="stat-value"><?= $eligScore ?>/100</p>
        <p style="font-size:13px; color:var(--text-muted); margin-top:10px;">Based on CGPA & English scores</p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-3">
        <h3><i class="fa-solid fa-award" style="color:var(--secondary); margin-right:8px;"></i> Scholarships in DB</h3>
        <p class="stat-value"><?= (int)$totalScholarships ?></p>
        <p style="font-size:13px; color:var(--text-muted); margin-top:10px;">Use Scholarship Matcher to filter</p>
    </div>
</div>

<a id="profile"></a>
<div class="glass-card mt-3 animate-gravity delay-4">
    <h2><i class="fa-solid fa-user-pen" style="color:var(--primary); margin-right:10px;"></i> Edit Profile</h2>
    <?php
    $msg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
        $name = trim($_POST['full_name']);
        $cgpa_input = (float)$_POST['cgpa_current'];
        $ielts_input = (float)$_POST['ielts_score'];
        $stmt = $pdo->prepare("UPDATE users SET full_name=?, cgpa_current=?, ielts_score=? WHERE id=?");
        $stmt->execute([$name, $cgpa_input, $ielts_input, $userId]);
        $_SESSION['user_name'] = $name;
        $msg = 'Profile updated successfully.';
        $user['cgpa_current'] = $cgpa_input;
        $user['ielts_score'] = $ielts_input;
    }
    ?>
    <?php if ($msg): ?><div class="alert success"><i class="fa-solid fa-circle-check" style="margin-right:10px;"></i> <?= htmlspecialchars($msg) ?></div><?php endif; ?>
    <form method="post" class="grid grid-3">
        <div>
            <label><i class="fa-solid fa-id-card" style="margin-right:5px; color:var(--text-muted);"></i> Full Name</label>
            <input type="text" name="full_name" value="<?= htmlspecialchars($_SESSION['user_name']) ?>" required>
        </div>
        <div>
            <label><i class="fa-solid fa-chart-line" style="margin-right:5px; color:var(--text-muted);"></i> Current CGPA (0-4)</label>
            <input type="number" name="cgpa_current" step="0.01" min="0" max="4" value="<?= htmlspecialchars($user['cgpa_current']) ?>">
        </div>
        <div>
            <label><i class="fa-solid fa-language" style="margin-right:5px; color:var(--text-muted);"></i> IELTS Score</label>
            <input type="number" name="ielts_score" step="0.5" min="0" max="9" value="<?= htmlspecialchars($user['ielts_score']) ?>">
        </div>
        <div class="full-width" style="text-align:right;">
            <button type="submit" name="update_profile" class="btn-primary"><i class="fa-solid fa-floppy-disk" style="margin-right:8px;"></i> Save Profile</button>
        </div>
    </form>
</div>
<?php include 'footer.php'; ?>
