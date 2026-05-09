<?php
// FILE: sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <ul>
        <li><a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'cgpa_tracker.php') ? 'active' : '' ?>" href="cgpa_tracker.php"><i class="fa-solid fa-chart-line"></i> <span>CGPA Tracker</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'countries.php') ? 'active' : '' ?>" href="countries.php"><i class="fa-solid fa-globe"></i> <span>Country Guidelines</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'scholarships.php') ? 'active' : '' ?>" href="scholarships.php"><i class="fa-solid fa-graduation-cap"></i> <span>Scholarship Matcher</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'moi_letter.php') ? 'active' : '' ?>" href="moi_letter.php"><i class="fa-solid fa-file-pen"></i> <span>MOI Letter</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'ielts_practice.php') ? 'active' : '' ?>" href="ielts_practice.php"><i class="fa-solid fa-book-open"></i> <span>IELTS Practice</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'eligibility.php') ? 'active' : '' ?>" href="eligibility.php"><i class="fa-solid fa-star-half-stroke"></i> <span>Eligibility Calc</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'financial_planner.php') ? 'active' : '' ?>" href="financial_planner.php"><i class="fa-solid fa-coins"></i> <span>Financial Gap Analyzer</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'document_vault.php') ? 'active' : '' ?>" href="document_vault.php"><i class="fa-solid fa-file-shield"></i> <span>Document Vault</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'kanban.php') ? 'active' : '' ?>" href="kanban.php"><i class="fa-solid fa-table-columns"></i> <span>Application Tracker</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'visa_simulator.php') ? 'active' : '' ?>" href="visa_simulator.php"><i class="fa-solid fa-passport"></i> <span>Visa Simulator</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'uni_recommender.php') ? 'active' : '' ?>" href="uni_recommender.php"><i class="fa-solid fa-building-columns"></i> <span>University Recommender</span></a></li>
    </ul>
</aside>
<main class="content">
