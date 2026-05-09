<?php
// FILE: sidebar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="sidebar">
    <!-- OVERVIEW -->
    <div class="sidebar-category">Overview</div>
    <ul>
        <li><a class="nav-link <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>" href="dashboard.php"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'journey_map.php') ? 'active' : '' ?>" href="journey_map.php"><i class="fa-solid fa-map-location-dot"></i> <span>Journey Map</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'vibe_matcher.php') ? 'active' : '' ?>" href="vibe_matcher.php"><i class="fa-solid fa-masks-theater"></i> <span>Uni Vibe Matcher</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'motivation_vault.php') ? 'active' : '' ?>" href="motivation_vault.php"><i class="fa-solid fa-fire"></i> <span>Motivation Vault</span></a></li>
    </ul>

    <!-- ACADEMIC & PROFILE -->
    <div class="sidebar-category">Academic & Profile</div>
    <ul>
        <li><a class="nav-link <?= ($current_page == 'cgpa_tracker.php') ? 'active' : '' ?>" href="cgpa_tracker.php"><i class="fa-solid fa-chart-line"></i> <span>CGPA Tracker</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'standardized_tests.php') ? 'active' : '' ?>" href="standardized_tests.php"><i class="fa-solid fa-pen-to-square"></i> <span>Test Tracker</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'doc_scanner.php') ? 'active' : '' ?>" href="doc_scanner.php"><i class="fa-solid fa-expand"></i> <span>Doc Scanner (AI)</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'roi_analytics.php') ? 'active' : '' ?>" href="roi_analytics.php"><i class="fa-solid fa-hand-holding-dollar"></i> <span>ROI Analytics</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'lor_generator.php') ? 'active' : '' ?>" href="lor_generator.php"><i class="fa-solid fa-file-signature"></i> <span>LOR Generator</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'tone_analyzer.php') ? 'active' : '' ?>" href="tone_analyzer.php"><i class="fa-solid fa-masks-theater"></i> <span>Tone Analyzer</span></a></li>
    </ul>

    <!-- DISCOVERY & PREP -->
    <div class="sidebar-category">Discovery & Prep</div>
    <ul>
        <li><a class="nav-link <?= ($current_page == 'countries.php') ? 'active' : '' ?>" href="countries.php"><i class="fa-solid fa-globe"></i> <span>Country Guides</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'scholarships.php') ? 'active' : '' ?>" href="scholarships.php"><i class="fa-solid fa-graduation-cap"></i> <span>Scholarship Match</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'odds_predictor.php') ? 'active' : '' ?>" href="odds_predictor.php"><i class="fa-solid fa-bullseye"></i> <span>Scholarship Odds</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'uni_compare.php') ? 'active' : '' ?>" href="uni_compare.php"><i class="fa-solid fa-scale-balanced"></i> <span>Uni Comparison</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'city_battle.php') ? 'active' : '' ?>" href="city_battle.php"><i class="fa-solid fa-city"></i> <span>City Battle (COL)</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'uni_recommender.php') ? 'active' : '' ?>" href="uni_recommender.php"><i class="fa-solid fa-building-columns"></i> <span>Uni Recommender</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'ielts_practice.php') ? 'active' : '' ?>" href="ielts_practice.php"><i class="fa-solid fa-book-open"></i> <span>IELTS Practice</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'ielts_quiz.php') ? 'active' : '' ?>" href="ielts_quiz.php"><i class="fa-solid fa-bolt-lightning"></i> <span>IELTS Quick-Quiz</span></a></li>
    </ul>

    <!-- LIFESTYLE & FINANCE -->
    <div class="sidebar-category">Lifestyle & Finance</div>
    <ul>
        <li><a class="nav-link <?= ($current_page == 'expense_calc.php') ? 'active' : '' ?>" href="expense_calc.php"><i class="fa-solid fa-calculator"></i> <span>Expense Calc</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'financial_planner.php') ? 'active' : '' ?>" href="financial_planner.php"><i class="fa-solid fa-coins"></i> <span>Financial Gap</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'housing_scout.php') ? 'active' : '' ?>" href="housing_scout.php"><i class="fa-solid fa-hotel"></i> <span>Housing Scout</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'packing_list.php') ? 'active' : '' ?>" href="packing_list.php"><i class="fa-solid fa-suitcase-rolling"></i> <span>Packing List</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'flight_scout.php') ? 'active' : '' ?>" href="flight_scout.php"><i class="fa-solid fa-plane-departure"></i> <span>Flight Scout</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'health_hub.php') ? 'active' : '' ?>" href="health_hub.php"><i class="fa-solid fa-heart-pulse"></i> <span>Health Hub</span></a></li>
    </ul>

    <!-- APPLICATION CENTER -->
    <div class="sidebar-category">Application Center</div>
    <ul>
        <li><a class="nav-link <?= ($current_page == 'sop_architect.php') ? 'active' : '' ?>" href="sop_architect.php"><i class="fa-solid fa-pen-nib"></i> <span>SOP Architect</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'alumni_connect.php') ? 'active' : '' ?>" href="alumni_connect.php"><i class="fa-solid fa-graduation-cap"></i> <span>Alumni Connect</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'buddy_matcher.php') ? 'active' : '' ?>" href="buddy_matcher.php"><i class="fa-solid fa-users-viewfinder"></i> <span>Buddy Matcher</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'document_vault.php') ? 'active' : '' ?>" href="document_vault.php"><i class="fa-solid fa-file-shield"></i> <span>Document Vault</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'kanban.php') ? 'active' : '' ?>" href="kanban.php"><i class="fa-solid fa-table-columns"></i> <span>App Tracker</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'deadlines.php') ? 'active' : '' ?>" href="deadlines.php"><i class="fa-solid fa-hourglass-half"></i> <span>Deadlines</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'visa_hub.php') ? 'active' : '' ?>" href="visa_hub.php"><i class="fa-solid fa-passport"></i> <span>Visa Hub</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'visa_simulator.php') ? 'active' : '' ?>" href="visa_simulator.php"><i class="fa-solid fa-comments"></i> <span>Visa Simulator</span></a></li>
        <li><a class="nav-link <?= ($current_page == 'moi_letter.php') ? 'active' : '' ?>" href="moi_letter.php"><i class="fa-solid fa-file-pen"></i> <span>MOI Letter</span></a></li>
    </ul>
</aside>
<main class="content">
