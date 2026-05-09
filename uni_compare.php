<?php
// FILE: uni_compare.php
require_once 'auth_check.php';

// Fetch all universities
$stmt = $pdo->query("SELECT * FROM universities ORDER BY name ASC");
$unis = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "University Comparison";
include 'header.php';
include 'sidebar.php';
?>

<div class="page-title animate-gravity">
    <h1><i class="fa-solid fa-scale-balanced" style="color:var(--primary); margin-right:15px;"></i> University Comparison</h1>
    <p>Compare requirements, rankings, and programs side-by-side.</p>
</div>

<div class="glass-card animate-gravity delay-1 mb-4">
    <div class="grid grid-2">
        <div class="form-group">
            <label>Select First University</label>
            <select id="uni1" onchange="updateComparison()">
                <option value="">-- Choose University --</option>
                <?php foreach ($unis as $u): ?>
                    <option value="<?= $u['id'] ?>" data-country="<?= $u['country'] ?>" data-cgpa="<?= $u['min_cgpa'] ?>" data-ielts="<?= $u['min_ielts'] ?>" data-type="<?= $u['type'] ?>" data-programs="<?= $u['program_areas'] ?>">
                        <?= htmlspecialchars($u['name']) ?> (<?= $u['country'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Select Second University</label>
            <select id="uni2" onchange="updateComparison()">
                <option value="">-- Choose University --</option>
                <?php foreach ($unis as $u): ?>
                    <option value="<?= $u['id'] ?>" data-country="<?= $u['country'] ?>" data-cgpa="<?= $u['min_cgpa'] ?>" data-ielts="<?= $u['min_ielts'] ?>" data-type="<?= $u['type'] ?>" data-programs="<?= $u['program_areas'] ?>">
                        <?= htmlspecialchars($u['name']) ?> (<?= $u['country'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div id="comparison-result" style="display:none;">
    <div class="glass-card animate-gravity delay-2">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Feature</th>
                    <th id="name1" style="color:var(--primary);">Uni 1</th>
                    <th id="name2" style="color:var(--secondary);">Uni 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Country</strong></td>
                    <td id="country1"></td>
                    <td id="country2"></td>
                </tr>
                <tr>
                    <td><strong>Min CGPA</strong></td>
                    <td id="cgpa1"></td>
                    <td id="cgpa2"></td>
                </tr>
                <tr>
                    <td><strong>Min IELTS</strong></td>
                    <td id="ielts1"></td>
                    <td id="ielts2"></td>
                </tr>
                <tr>
                    <td><strong>Tier</strong></td>
                    <td id="type1"></td>
                    <td id="type2"></td>
                </tr>
                <tr>
                    <td><strong>Top Programs</strong></td>
                    <td id="programs1"></td>
                    <td id="programs2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
function updateComparison() {
    const s1 = document.getElementById('uni1');
    const s2 = document.getElementById('uni2');
    
    const v1 = s1.options[s1.selectedIndex];
    const v2 = s2.options[s2.selectedIndex];

    if (s1.value && s2.value) {
        document.getElementById('comparison-result').style.display = 'block';

        // Update Name
        document.getElementById('name1').innerText = v1.text.split('(')[0];
        document.getElementById('name2').innerText = v2.text.split('(')[0];

        // Update Details
        document.getElementById('country1').innerText = v1.dataset.country;
        document.getElementById('country2').innerText = v2.dataset.country;

        document.getElementById('cgpa1').innerText = v1.dataset.cgpa;
        document.getElementById('cgpa2').innerText = v2.dataset.cgpa;

        document.getElementById('ielts1').innerText = v1.dataset.ielts;
        document.getElementById('ielts2').innerText = v2.dataset.ielts;

        document.getElementById('type1').innerHTML = `<span class="badge badge-active">${v1.dataset.type}</span>`;
        document.getElementById('type2').innerHTML = `<span class="badge badge-active" style="background:rgba(129,140,248,0.1); color:var(--secondary); border-color:rgba(129,140,248,0.2);">${v2.dataset.type}</span>`;

        document.getElementById('programs1').innerText = v1.dataset.programs;
        document.getElementById('programs2').innerText = v2.dataset.programs;
    } else {
        document.getElementById('comparison-result').style.display = 'none';
    }
}
</script>

<?php include 'footer.php'; ?>
