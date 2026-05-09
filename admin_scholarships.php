<?php
// FILE: admin_scholarships.php
require_once 'admin_auth.php';

$page_title = "Manage Scholarships";

$message = "";
$error   = "";

/*
Your scholarships table (from screenshot) looks like:

id  | name | country | country_id | min_cgpa | min_ielts | stipend_per_month
    | description | requires_research_proposal | requires_financial_proof

We will ONLY use:
name, country, min_cgpa, min_ielts, stipend_per_month,
description, requires_research_proposal, requires_financial_proof
*/

// Handle Add Scholarship
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name        = trim($_POST['name'] ?? '');
    $country     = trim($_POST['country'] ?? '');
    $min_cgpa    = (float)($_POST['min_cgpa'] ?? 0);
    $min_ielts   = (float)($_POST['min_ielts'] ?? 0);
    $stipend     = (int)($_POST['stipend'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $requires_research  = isset($_POST['requires_research']) ? 1 : 0;
    $requires_financial = isset($_POST['requires_financial']) ? 1 : 0;

    if ($name === '' || $country === '') {
        $error = "Scholarship name and country are required.";
    } else {
        // Insert matching your actual table structure
        $stmt = $pdo->prepare("
            INSERT INTO scholarships
                (name, country, min_cgpa, min_ielts, stipend_per_month,
                 description, requires_research_proposal, requires_financial_proof)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $name,
            $country,
            $min_cgpa,
            $min_ielts,
            $stipend,
            $description,
            $requires_research,
            $requires_financial
        ]);

        $message = "Scholarship added successfully!";
    }
}

// Fetch Existing Scholarships
$schStmt = $pdo->query("SELECT * FROM scholarships ORDER BY id DESC");
$scholarships = $schStmt->fetchAll(PDO::FETCH_ASSOC);

include 'admin_header.php';
?>

<div class="page-title">
    <h1>Manage Scholarships</h1>
    <p>Add, edit, and manage scholarship opportunities.</p>
</div>

<div class="glass-card animate-gravity delay-1">

    <?php if ($message): ?>
        <div class="alert success"><i class="fa-solid fa-circle-check" style="margin-right:10px; font-size:18px;"></i> <?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert error"><i class="fa-solid fa-circle-exclamation" style="margin-right:10px; font-size:18px;"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <h2><i class="fa-solid fa-graduation-cap" style="color:var(--primary); margin-right:10px;"></i> Add New Scholarship</h2>

    <form method="POST" class="grid grid-2">

        <div>
            <label><i class="fa-solid fa-award" style="margin-right:5px; color:var(--text-muted);"></i> Scholarship Name *</label>
            <input type="text" name="name" placeholder="e.g., Chevening Scholarship" required>
        </div>

        <div>
            <label><i class="fa-solid fa-earth-americas" style="margin-right:5px; color:var(--text-muted);"></i> Country *</label>
            <input type="text" name="country" placeholder="e.g., UK, Germany, Australia" required>
        </div>

        <div>
            <label><i class="fa-solid fa-chart-line" style="margin-right:5px; color:var(--text-muted);"></i> Minimum CGPA</label>
            <input type="number" step="0.01" name="min_cgpa" value="3.0">
        </div>

        <div>
            <label><i class="fa-solid fa-language" style="margin-right:5px; color:var(--text-muted);"></i> Minimum IELTS Score</label>
            <input type="number" step="0.5" name="min_ielts" value="6.5">
        </div>

        <div>
            <label><i class="fa-solid fa-hand-holding-dollar" style="margin-right:5px; color:var(--text-muted);"></i> Stipend Per Month</label>
            <input type="number" name="stipend" placeholder="e.g., 850">
        </div>

        <div class="full-width">
            <label><i class="fa-solid fa-align-left" style="margin-right:5px; color:var(--text-muted);"></i> Description</label>
            <textarea name="description" rows="3"
                      placeholder="Short description of this scholarship..."></textarea>
        </div>

        <div style="background:rgba(255,255,255,0.02); padding:15px; border-radius:12px; border:1px solid var(--border-glass); display:flex; align-items:center;">
            <label style="margin-bottom:0; cursor:pointer; display:flex; align-items:center; gap:10px;">
                <input type="checkbox" name="requires_research" style="width:20px; height:20px; margin:0;">
                <span style="color:#fff;"><i class="fa-solid fa-flask" style="color:var(--secondary); margin-right:5px;"></i> Requires Research Proposal</span>
            </label>
        </div>

        <div style="background:rgba(255,255,255,0.02); padding:15px; border-radius:12px; border:1px solid var(--border-glass); display:flex; align-items:center;">
            <label style="margin-bottom:0; cursor:pointer; display:flex; align-items:center; gap:10px;">
                <input type="checkbox" name="requires_financial" style="width:20px; height:20px; margin:0;">
                <span style="color:#fff;"><i class="fa-solid fa-file-invoice-dollar" style="color:var(--warning); margin-right:5px;"></i> Requires Financial Proof</span>
            </label>
        </div>

        <div class="full-width" style="text-align:right;">
            <button class="btn-primary" type="submit"><i class="fa-solid fa-plus" style="margin-right:8px;"></i> Add Scholarship</button>
        </div>

    </form>
</div>

<div class="glass-card mt-3 animate-gravity delay-2">
    <h2><i class="fa-solid fa-list" style="color:var(--secondary); margin-right:10px;"></i> Existing Scholarships</h2>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Min CGPA</th>
                    <th>Min IELTS</th>
                    <th>Stipend</th>
                    <th>Research?</th>
                    <th>Financial?</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($scholarships): ?>
                <?php foreach ($scholarships as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['name']) ?></td>
                        <td><?= htmlspecialchars($s['country']) ?></td>
                        <td><?= htmlspecialchars($s['min_cgpa']) ?></td>
                        <td><?= htmlspecialchars($s['min_ielts']) ?></td>
                        <td><?= htmlspecialchars($s['stipend_per_month']) ?></td>

                        <td>
                            <span class="<?= $s['requires_research_proposal'] ? 'badge-yes' : 'badge-no' ?>">
                                <?= $s['requires_research_proposal'] ? 'Yes' : 'No' ?>
                            </span>
                        </td>

                        <td>
                            <span class="<?= $s['requires_financial_proof'] ? 'badge-yes' : 'badge-no' ?>">
                                <?= $s['requires_financial_proof'] ? 'Yes' : 'No' ?>
                            </span>
                        </td>

                        <td class="description-cell">
                            <?= htmlspecialchars($s['description']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8">No scholarships added yet.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'admin_footer.php'; ?>
