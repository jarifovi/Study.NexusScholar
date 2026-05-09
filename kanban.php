<?php
// FILE: kanban.php
require_once 'auth_check.php';
$page_title = "Application Tracker";
$userId = $_SESSION['user_id'];

// Handle AJAX/POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    if ($_POST['action'] === 'add') {
        $uni  = trim($_POST['university_name'] ?? '');
        $country = trim($_POST['country'] ?? '');
        $prog = trim($_POST['program'] ?? '');
        $dl   = $_POST['deadline'] ?? null;
        $notes= trim($_POST['notes'] ?? '');
        if ($uni !== '') {
            $s = $pdo->prepare("INSERT INTO university_applications (user_id, university_name, country, program, deadline, notes) VALUES (?,?,?,?,?,?)");
            $s->execute([$userId, $uni, $country, $prog, $dl ?: null, $notes]);
            $id = $pdo->lastInsertId();
            echo json_encode(['success' => true, 'id' => $id]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

    elseif ($_POST['action'] === 'move') {
        $id    = (int)$_POST['id'];
        $stage = $_POST['stage'];
        $allowed = ['shortlisted','in_progress','submitted','accepted','rejected'];
        if (in_array($stage, $allowed)) {
            $s = $pdo->prepare("UPDATE university_applications SET stage=? WHERE id=? AND user_id=?");
            $s->execute([$stage, $id, $userId]);
            echo json_encode(['success' => true]);
        }
    }

    elseif ($_POST['action'] === 'delete') {
        $id = (int)$_POST['id'];
        $s = $pdo->prepare("DELETE FROM university_applications WHERE id=? AND user_id=?");
        $s->execute([$id, $userId]);
        echo json_encode(['success' => true]);
    }
    exit;
}

// Load all applications
$apps = $pdo->prepare("SELECT * FROM university_applications WHERE user_id = ? ORDER BY created_at DESC");
$apps->execute([$userId]);
$allApps = $apps->fetchAll(PDO::FETCH_ASSOC);

$stages = [
    'shortlisted' => ['label' => 'Shortlisted',  'icon' => 'fa-bookmark',       'color' => '#38bdf8'],
    'in_progress' => ['label' => 'In Progress',   'icon' => 'fa-pen-to-square',  'color' => '#eab308'],
    'submitted'   => ['label' => 'Submitted',     'icon' => 'fa-paper-plane',    'color' => '#818cf8'],
    'accepted'    => ['label' => 'Accepted',      'icon' => 'fa-circle-check',   'color' => '#10b981'],
    'rejected'    => ['label' => 'Rejected',      'icon' => 'fa-circle-xmark',   'color' => '#ef4444'],
];

include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-table-columns" style="color:var(--primary); margin-right:10px;"></i> Application Tracker</h1>
    <p>Track every university application across all stages — drag & drop to update.</p>
</div>

<!-- Add New Application -->
<div class="glass-card animate-gravity delay-1" style="margin-bottom:30px;">
    <h2 style="margin-bottom:15px;"><i class="fa-solid fa-plus-circle" style="color:var(--secondary); margin-right:10px;"></i> Add New Application</h2>
    <form id="addForm" class="grid grid-3" style="align-items:flex-end;">
        <div>
            <label><i class="fa-solid fa-university" style="margin-right:5px; color:var(--text-muted);"></i> University Name *</label>
            <input type="text" id="uniName" placeholder="e.g. University of Melbourne" style="margin-bottom:0;">
        </div>
        <div>
            <label><i class="fa-solid fa-globe" style="margin-right:5px; color:var(--text-muted);"></i> Country</label>
            <input type="text" id="uniCountry" placeholder="e.g. Australia" style="margin-bottom:0;">
        </div>
        <div>
            <label><i class="fa-solid fa-book" style="margin-right:5px; color:var(--text-muted);"></i> Program</label>
            <input type="text" id="uniProgram" placeholder="e.g. BSc Computer Science" style="margin-bottom:0;">
        </div>
        <div>
            <label><i class="fa-regular fa-calendar" style="margin-right:5px; color:var(--text-muted);"></i> Deadline</label>
            <input type="date" id="uniDeadline" style="margin-bottom:0;">
        </div>
        <div>
            <label><i class="fa-solid fa-note-sticky" style="margin-right:5px; color:var(--text-muted);"></i> Notes</label>
            <input type="text" id="uniNotes" placeholder="Optional notes..." style="margin-bottom:0;">
        </div>
        <div style="display:flex; align-items:flex-end;">
            <button type="submit" class="btn-primary" style="width:100%;">
                <i class="fa-solid fa-plus" style="margin-right:8px;"></i> Add to Board
            </button>
        </div>
    </form>
</div>

<!-- Kanban Board -->
<div class="kanban-board" id="kanbanBoard">
    <?php foreach ($stages as $stageKey => $stageData): ?>
    <div class="kanban-col" id="col-<?= $stageKey ?>" data-stage="<?= $stageKey ?>"
         ondragover="event.preventDefault();" ondrop="dropCard(event, '<?= $stageKey ?>')">
        <div class="kanban-col-header" style="border-top-color: <?= $stageData['color'] ?>;">
            <span class="kanban-col-title">
                <i class="fa-solid <?= $stageData['icon'] ?>" style="color:<?= $stageData['color'] ?>; margin-right:8px;"></i>
                <?= $stageData['label'] ?>
            </span>
            <span class="kanban-count" id="count-<?= $stageKey ?>" style="background: <?= $stageData['color'] ?>22; color:<?= $stageData['color'] ?>;">
                <?= count(array_filter($allApps, fn($a) => $a['stage'] === $stageKey)) ?>
            </span>
        </div>
        <div class="kanban-cards" id="cards-<?= $stageKey ?>">
            <?php foreach ($allApps as $app): ?>
                <?php if ($app['stage'] === $stageKey): ?>
                <div class="kanban-card" id="card-<?= $app['id'] ?>" draggable="true"
                     ondragstart="dragCard(event, <?= $app['id'] ?>)">
                    <div class="kanban-card-title"><?= htmlspecialchars($app['university_name']) ?></div>
                    <?php if ($app['country']): ?>
                    <div class="kanban-card-meta"><i class="fa-solid fa-globe"></i> <?= htmlspecialchars($app['country']) ?></div>
                    <?php endif; ?>
                    <?php if ($app['program']): ?>
                    <div class="kanban-card-meta"><i class="fa-solid fa-book"></i> <?= htmlspecialchars($app['program']) ?></div>
                    <?php endif; ?>
                    <?php if ($app['deadline']): ?>
                    <div class="kanban-card-meta" style="color:#eab308;"><i class="fa-regular fa-calendar"></i> Deadline: <?= date('M d, Y', strtotime($app['deadline'])) ?></div>
                    <?php endif; ?>
                    <?php if ($app['notes']): ?>
                    <div class="kanban-card-notes"><?= htmlspecialchars($app['notes']) ?></div>
                    <?php endif; ?>
                    <div class="kanban-card-actions">
                        <?php foreach ($stages as $sk => $sd): ?>
                            <?php if ($sk !== $stageKey): ?>
                            <button onclick="moveCard(<?= $app['id'] ?>, '<?= $sk ?>')" style="color:<?= $sd['color'] ?>;" title="Move to <?= $sd['label'] ?>">
                                <i class="fa-solid <?= $sd['icon'] ?>"></i>
                            </button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <button onclick="deleteCard(<?= $app['id'] ?>)" style="color:#ef4444;" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
.kanban-board {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    align-items: flex-start;
    margin-top: 10px;
    overflow-x: auto;
    padding-bottom: 20px;
}
.kanban-col {
    background: rgba(15, 23, 42, 0.5);
    border: 1px solid var(--border-glass);
    border-radius: 16px;
    padding: 0 0 15px;
    min-height: 300px;
    transition: 0.3s;
    backdrop-filter: blur(12px);
}
.kanban-col.drag-over { background: rgba(56,189,248,0.05); border-color: var(--primary); }
.kanban-col-header {
    border-top: 3px solid transparent;
    border-radius: 14px 14px 0 0;
    padding: 16px 16px 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.kanban-col-title { font-weight: 700; font-size: 15px; color: #fff; }
.kanban-count { font-size: 13px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.kanban-cards { padding: 0 12px; display: flex; flex-direction: column; gap: 10px; }
.kanban-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid var(--border-glass);
    border-radius: 12px;
    padding: 15px;
    cursor: grab;
    transition: all 0.2s;
    position: relative;
}
.kanban-card:active { cursor: grabbing; }
.kanban-card:hover { background: rgba(255,255,255,0.08); border-color: var(--primary); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
.kanban-card.dragging { opacity: 0.4; transform: scale(0.98); }
.kanban-card-title { font-weight: 700; font-size: 15px; color: #fff; margin-bottom: 8px; }
.kanban-card-meta { font-size: 13px; color: var(--text-muted); margin-bottom: 4px; display: flex; align-items: center; gap: 6px; }
.kanban-card-notes { font-size: 12px; color: var(--text-muted); margin-top: 8px; padding: 8px; background: rgba(0,0,0,0.2); border-radius: 8px; font-style: italic; }
.kanban-card-actions { display: flex; gap: 8px; margin-top: 12px; padding-top: 10px; border-top: 1px solid var(--border-glass); flex-wrap: wrap; }
.kanban-card-actions button { background: none; border: none; cursor: pointer; font-size: 16px; padding: 4px; transition: 0.2s; opacity: 0.7; }
.kanban-card-actions button:hover { opacity: 1; transform: scale(1.2); }
@media (max-width: 1400px) { .kanban-board { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 900px)  { .kanban-board { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .kanban-board { grid-template-columns: 1fr; } }
</style>

<script>
let draggedId = null;

function dragCard(e, id) {
    draggedId = id;
    document.getElementById('card-' + id)?.classList.add('dragging');
}

document.addEventListener('dragend', () => {
    document.querySelectorAll('.kanban-card').forEach(c => c.classList.remove('dragging'));
    document.querySelectorAll('.kanban-col').forEach(c => c.classList.remove('drag-over'));
});

document.querySelectorAll('.kanban-col').forEach(col => {
    col.addEventListener('dragover', () => col.classList.add('drag-over'));
    col.addEventListener('dragleave', () => col.classList.remove('drag-over'));
});

function dropCard(e, stage) {
    if (draggedId) moveCard(draggedId, stage);
}

function moveCard(id, stage) {
    fetch('kanban.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `action=move&id=${id}&stage=${stage}`
    })
    .then(r => r.json())
    .then(data => { if (data.success) location.reload(); });
}

function deleteCard(id) {
    if (!confirm('Remove this application from the board?')) return;
    fetch('kanban.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `action=delete&id=${id}`
    })
    .then(r => r.json())
    .then(data => { if (data.success) { document.getElementById('card-' + id)?.remove(); }});
}

document.getElementById('addForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const uni     = document.getElementById('uniName').value.trim();
    const country = document.getElementById('uniCountry').value.trim();
    const prog    = document.getElementById('uniProgram').value.trim();
    const dl      = document.getElementById('uniDeadline').value;
    const notes   = document.getElementById('uniNotes').value.trim();
    if (!uni) { alert('Please enter a university name.'); return; }

    fetch('kanban.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: `action=add&university_name=${encodeURIComponent(uni)}&country=${encodeURIComponent(country)}&program=${encodeURIComponent(prog)}&deadline=${dl}&notes=${encodeURIComponent(notes)}`
    })
    .then(r => r.json())
    .then(data => { if (data.success) location.reload(); });
});
</script>

<?php include 'footer.php'; ?>
