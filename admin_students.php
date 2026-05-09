<?php
// FILE: admin_students.php
require_once 'admin_auth.php';
$page_title = "Manage Students";

// Activate / deactivate / delete
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($_GET['action'] === 'activate') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'active' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] === 'deactivate') {
        $stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
    header('Location: admin_students.php');
    exit;
}

$totalStudents = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$activeProfiles = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE status = 'active'")->fetchColumn();
$withCgpa = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE cgpa_current > 0")->fetchColumn();
$targetSet = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE target_country IS NOT NULL AND target_country <> ''")->fetchColumn();

$studentsStmt = $pdo->query("
    SELECT id, full_name, email, country, cgpa_current, ielts_score, status, created_at
    FROM users
    ORDER BY created_at DESC
");
$students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

include 'admin_header.php';
?>

<div class="page-title">
    <h1>Manage Students</h1>
    <p>View and manage student accounts and profiles.</p>
</div>

<div class="grid grid-2">
    <div class="glass-card stat-card animate-gravity delay-1">
        <h3><i class="fa-solid fa-users" style="color:var(--primary); margin-right:8px;"></i> Total Students</h3>
        <p class="stat-value"><?= $totalStudents ?></p>
    </div>
    <div class="glass-card stat-card animate-gravity delay-2">
        <h3><i class="fa-solid fa-user-check" style="color:#10b981; margin-right:8px;"></i> Active Profiles</h3>
        <p class="stat-value"><?= $activeProfiles ?></p>
    </div>
</div>

<div class="glass-card mt-3 animate-gravity delay-3">
    <h2><i class="fa-solid fa-list" style="color:var(--secondary); margin-right:10px;"></i> Student List</h2>
    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
            <tr>
                <th>Student</th>
                <th>Profile</th>
                <th>Academic</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($students): ?>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td>
                            <strong style="color:#fff; font-size:16px;"><?= htmlspecialchars($s['full_name']) ?></strong><br>
                            <span style="color:var(--text-muted);"><i class="fa-solid fa-envelope" style="font-size:12px; margin-right:4px;"></i><?= htmlspecialchars($s['email']) ?></span>
                        </td>
                        <td><i class="fa-solid fa-location-dot" style="color:var(--primary); margin-right:6px;"></i><?= htmlspecialchars($s['country'] ?? 'N/A') ?></td>
                        <td>
                            <span style="display:inline-block; margin-bottom:4px; padding:2px 8px; background:rgba(56,189,248,0.1); border-radius:4px; font-size:13px;"><strong style="color:var(--primary);">CGPA:</strong> <?= number_format($s['cgpa_current'], 2) ?></span><br>
                            <span style="display:inline-block; padding:2px 8px; background:rgba(129,140,248,0.1); border-radius:4px; font-size:13px;"><strong style="color:var(--secondary);">IELTS:</strong> <?= $s['ielts_score'] > 0 ? $s['ielts_score'] : 'N/A' ?></span>
                        </td>
                        <td>
                            <?php if ($s['status'] === 'active'): ?>
                                <span class="badge badge-active"><i class="fa-solid fa-check-circle"></i> Active</span>
                            <?php else: ?>
                                <span class="badge badge-inactive"><i class="fa-solid fa-times-circle"></i> Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><i class="fa-regular fa-calendar" style="color:var(--text-muted); margin-right:6px;"></i><?= htmlspecialchars(date('M d, Y', strtotime($s['created_at']))) ?></td>
                        <td>
                            <?php if ($s['status'] === 'active'): ?>
                                <a href="admin_students.php?action=deactivate&id=<?= $s['id'] ?>" style="color:#f87171; background:rgba(248,113,113,0.1); padding:6px 10px; border-radius:8px; display:inline-block; margin-bottom:4px; width:100%; text-align:center;"><i class="fa-solid fa-ban"></i> Deactivate</a>
                            <?php else: ?>
                                <a href="admin_students.php?action=activate&id=<?= $s['id'] ?>" style="color:#34d399; background:rgba(52,211,153,0.1); padding:6px 10px; border-radius:8px; display:inline-block; margin-bottom:4px; width:100%; text-align:center;"><i class="fa-solid fa-check"></i> Activate</a>
                            <?php endif; ?>
                            
                            <a href="admin_students.php?action=delete&id=<?= $s['id'] ?>" style="color:#ef4444; background:rgba(239,68,68,0.1); padding:6px 10px; border-radius:8px; display:inline-block; width:100%; text-align:center;"
                               onclick="return confirm('Delete this student?');"><i class="fa-solid fa-trash-can"></i> Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center; padding:30px; color:var(--text-muted);">No students yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
