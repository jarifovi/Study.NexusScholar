<?php
// FILE: admin_countries.php
require_once 'admin_auth.php';

$page_title = "Manage Countries";

$message = "";
$error   = "";

// Handle country submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $min_cgpa = (float)($_POST['min_cgpa'] ?? 0);
    $min_ielts = (float)($_POST['min_ielts'] ?? 0);
    $cost_min = (int)($_POST['estimated_cost_min'] ?? 0);
    $cost_max = (int)($_POST['estimated_cost_max'] ?? 0);
    $deadline = trim($_POST['application_deadline'] ?? '');
    $requirements = trim($_POST['requirements_text'] ?? '');

    if ($name === '') {
        $error = "Country name is required.";
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO countries 
            (name, min_cgpa, min_ielts, estimated_cost_min, estimated_cost_max, application_deadline, requirements_text)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $name,
            $min_cgpa,
            $min_ielts,
            $cost_min,
            $cost_max,
            $deadline,
            $requirements
        ]);

        $message = "Country added successfully!";
    }
}

// Load all countries
$countries = $pdo->query("SELECT * FROM countries ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

include 'admin_header.php';
?>

<div class="page-title">
    <h1>Manage Countries</h1>
    <p>Add, edit, and manage country requirements.</p>
</div>

<div class="glass-card animate-gravity delay-1">
    <h2><i class="fa-solid fa-earth-americas" style="color:var(--primary); margin-right:10px;"></i> Add New Country</h2>

    <?php if ($message): ?>
        <div class="alert success"><i class="fa-solid fa-circle-check" style="margin-right:10px; font-size:18px;"></i> <?= $message ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert error"><i class="fa-solid fa-circle-exclamation" style="margin-right:10px; font-size:18px;"></i> <?= $error ?></div>
    <?php endif; ?>

    <form method="post" class="grid grid-2">

        <div>
            <label><i class="fa-solid fa-flag" style="margin-right:5px; color:var(--text-muted);"></i> Country Name *</label>
            <input type="text" name="name" required placeholder="e.g., Australia, Germany">
        </div>

        <div>
            <label><i class="fa-solid fa-graduation-cap" style="margin-right:5px; color:var(--text-muted);"></i> Minimum CGPA</label>
            <input type="number" step="0.01" name="min_cgpa" value="3.0">
        </div>

        <div>
            <label><i class="fa-solid fa-language" style="margin-right:5px; color:var(--text-muted);"></i> Minimum IELTS</label>
            <input type="number" step="0.1" name="min_ielts" value="6.5">
        </div>

        <div>
            <label><i class="fa-solid fa-money-bill-wave" style="margin-right:5px; color:var(--text-muted);"></i> Estimated Cost (Min)</label>
            <input type="number" name="estimated_cost_min" placeholder="e.g., 25000">
        </div>

        <div>
            <label><i class="fa-solid fa-money-bill-wave" style="margin-right:5px; color:var(--text-muted);"></i> Estimated Cost (Max)</label>
            <input type="number" name="estimated_cost_max" placeholder="e.g., 35000">
        </div>

        <div class="full-width">
            <label><i class="fa-regular fa-calendar-xmark" style="margin-right:5px; color:var(--text-muted);"></i> Application Deadline</label>
            <input type="text" name="application_deadline" placeholder="e.g., November 30 for February intake">
        </div>

        <div class="full-width">
            <label><i class="fa-solid fa-list-check" style="margin-right:5px; color:var(--text-muted);"></i> Requirements</label>
            <textarea name="requirements_text" rows="3" placeholder="List requirements..."></textarea>
        </div>

        <div class="full-width" style="text-align:right;">
            <button type="submit" class="btn-primary"><i class="fa-solid fa-plus" style="margin-right:8px;"></i> Add Country</button>
        </div>

    </form>
</div>

<!-- Existing Countries -->
<div class="glass-card mt-3 animate-gravity delay-2">
    <h2><i class="fa-solid fa-list" style="color:var(--secondary); margin-right:10px;"></i> Existing Countries</h2>

    <?php if ($countries): ?>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:20px; margin-top:20px;">
            <?php foreach ($countries as $c): ?>
                <div style="background:rgba(255,255,255,0.02); border:1px solid var(--border-glass); border-radius:16px; padding:20px; transition:all 0.3s ease; box-shadow:0 4px 15px rgba(0,0,0,0.1);" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='var(--primary)'; this.style.background='rgba(255,255,255,0.05)';" onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--border-glass)'; this.style.background='rgba(255,255,255,0.02)';">
                    <h3 style="color:#fff; font-size:20px; margin-bottom:12px; display:flex; align-items:center; gap:8px;"><i class="fa-solid fa-flag" style="color:var(--primary);"></i><?= htmlspecialchars($c['name']) ?></h3>
                    <div style="background:rgba(0,0,0,0.2); padding:10px; border-radius:10px; margin-bottom:10px;">
                        <p style="font-size:13px; color:var(--text-muted); margin-bottom:5px; display:flex; justify-content:space-between;"><span><i class="fa-solid fa-graduation-cap" style="width:20px;"></i> Min CGPA:</span> <strong style="color:#fff; font-size:14px;"><?= number_format($c['min_cgpa'], 2) ?></strong></p>
                        <p style="font-size:13px; color:var(--text-muted); margin-bottom:0; display:flex; justify-content:space-between;"><span><i class="fa-solid fa-language" style="width:20px;"></i> Min IELTS:</span> <strong style="color:#fff; font-size:14px;"><?= number_format($c['min_ielts'], 1) ?></strong></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align:center; padding:30px; color:var(--text-muted);">No countries found.</p>
    <?php endif; ?>

</div>

<?php include 'admin_footer.php'; ?>
