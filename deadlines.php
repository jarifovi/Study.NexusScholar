<?php
// FILE: deadlines.php
require_once 'auth_check.php';

$userId = $_SESSION['user_id'];

// Fetch applications with deadlines
$stmt = $pdo->prepare("SELECT university_name, stage, deadline FROM university_applications WHERE user_id = ? AND deadline IS NOT NULL ORDER BY deadline ASC");
$stmt->execute([$userId]);
$deadlines = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Deadline Command Center";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-hourglass-half" style="color:var(--primary); margin-right:15px;"></i> Deadlines Command Center</h1>
    <p>Track your application submission windows.</p>
</div>

<?php if (empty($deadlines)): ?>
    <div class="glass-card animate-gravity delay-1 text-center" style="padding: 60px;">
        <i class="fa-solid fa-calendar-xmark" style="font-size: 50px; color: var(--text-dim); margin-bottom: 20px;"></i>
        <h2>No Deadlines Set</h2>
        <p>Go to the <a href="kanban.php" style="color:var(--primary);">Application Tracker</a> to add deadlines to your shortlisted universities.</p>
    </div>
<?php else: ?>
    <div class="grid grid-2">
        <?php 
        $delay = 1;
        foreach ($deadlines as $d): 
            $deadlineDate = new DateTime($d['deadline']);
            $now = new DateTime();
            $diff = $now->diff($deadlineDate);
            $daysLeft = (int)$diff->format("%r%a");
            
            $statusClass = 'success';
            if ($daysLeft < 7) $statusClass = 'danger';
            else if ($daysLeft < 30) $statusClass = 'warning';
        ?>
            <div class="glass-card animate-gravity delay-<?= $delay++ ?>">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px;">
                    <div>
                        <h3 style="margin-bottom:5px; font-size:20px; color:#fff;"><?= htmlspecialchars($d['university_name']) ?></h3>
                        <span class="badge badge-active"><?= ucfirst($d['stage']) ?></span>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-size:12px; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px;">Days Left</span>
                        <div style="font-size:36px; font-weight:800; color:<?= ($statusClass == 'danger') ? 'var(--danger)' : (($statusClass == 'warning') ? 'var(--warning)' : 'var(--primary)') ?>;">
                            <?= $daysLeft ?>
                        </div>
                    </div>
                </div>
                
                <div style="background:rgba(255,255,255,0.05); height:8px; border-radius:10px; overflow:hidden;">
                    <div style="width:<?= max(0, min(100, 100 - ($daysLeft/1.2))) ?>%; background:linear-gradient(to right, var(--primary), var(--secondary)); height:100%;"></div>
                </div>
                
                <p style="margin-top:15px; font-size:14px; color:var(--text-muted);">
                    <i class="fa-regular fa-calendar-days" style="margin-right:8px;"></i>
                    Deadline: <strong><?= $deadlineDate->format('M d, Y') ?></strong>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>
