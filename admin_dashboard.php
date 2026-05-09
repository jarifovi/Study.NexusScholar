<?php
// FILE: admin_dashboard.php
require_once 'admin_auth.php';

$page_title = "Admin Dashboard";
$adminId = $_SESSION['admin_id'];

// Stats
$totalStudents = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$activeProfiles = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE status = 'active'")->fetchColumn();
$cgpaRecords = (int)$pdo->query("SELECT COUNT(*) FROM semesters")->fetchColumn();
$newThisWeek = (int)$pdo->query("
    SELECT COUNT(*) FROM users
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
")->fetchColumn();

// Recent student
$recentStmt = $pdo->query("
    SELECT full_name, email, country, created_at
    FROM users
    ORDER BY created_at DESC
    LIMIT 1
");
$recentStudent = $recentStmt->fetch(PDO::FETCH_ASSOC);

// Registration trend: last 6 months
$trendStmt = $pdo->query("
    SELECT DATE_FORMAT(created_at, '%b') AS month_label,
           COUNT(*) AS total_reg
    FROM users
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY YEAR(created_at), MONTH(created_at)
");
$trendData = $trendStmt->fetchAll(PDO::FETCH_ASSOC);
$trendLabels = array_column($trendData, 'month_label');
$trendValues = array_map('intval', array_column($trendData, 'total_reg'));

include 'admin_header.php';
?>

<div class="page-title">
    <h1>Admin Dashboard</h1>
    <p>Manage NexusScholar system and monitor student activities.</p>
</div>

<div class="grid grid-4">
    <div class="glass-card stat-card animate-gravity delay-1">
        <h3><i class="fa-solid fa-user-graduate" style="color:var(--primary); margin-right:8px;"></i> Total Students</h3>
        <p class="stat-value"><?= $totalStudents ?></p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-2">
        <h3><i class="fa-solid fa-user-check" style="color:var(--secondary); margin-right:8px;"></i> Active Profiles</h3>
        <p class="stat-value"><?= $activeProfiles ?></p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-3">
        <h3><i class="fa-solid fa-user-plus" style="color:var(--primary); margin-right:8px;"></i> New This Week</h3>
        <p class="stat-value"><?= $newThisWeek ?></p>
    </div>
</div>

<!-- <div class="grid grid-2 mt-3">
    <div class="glass-card">
        <h2>Student Registration Trend</h2>
        <div style="height:220px;">
            <canvas id="regTrendChart"></canvas>
        </div>
    </div> -->

<div class="grid mt-3">
    <div class="glass-card animate-gravity delay-4">
        <h2><i class="fa-solid fa-clock-rotate-left" style="color:var(--primary); margin-right:10px;"></i> Recent Registration</h2>
        <?php if ($recentStudent): ?>
            <div style="display:flex; align-items:center; gap:20px; margin-top:15px; padding:15px; background:rgba(255,255,255,0.03); border-radius:15px; border:1px solid var(--border-glass);">
                <div style="width:60px; height:60px; border-radius:50%; background:linear-gradient(135deg, var(--primary), var(--secondary)); display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:bold; color:#fff; box-shadow:0 5px 15px rgba(56,189,248,0.3);">
                    <?= strtoupper(substr($recentStudent['full_name'], 0, 1)) ?>
                </div>
                <div>
                    <h3 style="font-size:20px; font-weight:600; color:#fff; margin-bottom:5px;"><?= htmlspecialchars($recentStudent['full_name']) ?></h3>
                    <p style="color:var(--text-muted); font-size:14px; margin-bottom:3px;"><i class="fa-solid fa-envelope" style="width:16px;"></i> <?= htmlspecialchars($recentStudent['email']) ?></p>
                    <p style="color:var(--text-muted); font-size:14px;"><i class="fa-solid fa-location-dot" style="width:16px;"></i> <?= htmlspecialchars($recentStudent['country'] ?? 'Unknown') ?> &nbsp;|&nbsp; <i class="fa-solid fa-calendar-day" style="width:16px;"></i> <?= htmlspecialchars(date('M d, Y', strtotime($recentStudent['created_at']))) ?></p>
                </div>
            </div>
        <?php else: ?>
            <p>No students yet.</p>
        <?php endif; ?>
    </div>
</div>

<script>
const regLabels = <?= json_encode($trendLabels) ?>;
const regValues = <?= json_encode($trendValues) ?>;

const ctxReg = document.getElementById('regTrendChart');
if (ctxReg) {
    new Chart(ctxReg, {
        type: 'line',
        data: {
            labels: regLabels,
            datasets: [{
                data: regValues,
                borderColor: '#60a5fa',
                backgroundColor: 'rgba(96,165,250,0.25)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointRadius: 3,
                pointBackgroundColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.08)' } },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.08)' }
                }
            }
        }
    });
}
</script>

<?php include 'admin_footer.php'; ?>
