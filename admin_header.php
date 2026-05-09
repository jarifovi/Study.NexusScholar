<?php
// FILE: admin_header.php
if (!isset($page_title)) { $page_title = "Admin"; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?> - NexusScholar Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header class="navbar">
    <div class="navbar-left">
        <div class="logo">👤 NexusScholar Admin</div>
    </div>
    <div class="navbar-right">
        <!-- <nav class="admin-nav-links" style="display:flex; gap:16px; align-items:center;">
            <a href="admin_dashboard.php" class="nav-link">Dashboard</a>
            <a href="admin_students.php" class="nav-link">Students</a>
            <a href="admin_countries.php" class="nav-link">Countries</a>
            <a href="admin_scholarships.php" class="nav-link">Scholarships</a>
            <a href="admin_reports.php" class="nav-link">Reports</a>
        </nav> -->
        <span style="margin-left:20px; font-size:14px; color:#e5e7eb;">
            Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'admin') ?>
        </span>
        <span style="margin-left:12px; padding:4px 10px; border-radius:999px;
                     background:rgba(255,255,255,0.22); font-size:12px;">
             Admin
        </span>
        <div class="nav-icon" style="margin-left:18px;">
            <a href="admin_logout.php" class="logout-link">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </div>
</header>

<div class="ambient-glow glow-1"></div>
<div class="ambient-glow glow-2"></div>

<div class="page-wrapper">
    <!-- Reuse same layout classes: sidebar + content -->
    <aside class="sidebar">
        <ul>
            <li><a href="admin_dashboard.php" class="nav-link"><i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span></a></li>
            <li><a href="admin_heatmap.php" class="nav-link"><i class="fa-solid fa-earth-africa"></i> <span>Insight Heatmap</span></a></li>
            <li><a href="admin_verification.php" class="nav-link"><i class="fa-solid fa-file-shield"></i> <span>Verification Terminal</span></a></li>
            <li><a href="admin_broadcast.php" class="nav-link"><i class="fa-solid fa-tower-broadcast"></i> <span>Broadcast Center</span></a></li>
            <li><a href="admin_tickets.php" class="nav-link"><i class="fa-solid fa-ticket"></i> <span>Support Tickets</span></a></li>
            <li><a href="admin_news.php" class="nav-link"><i class="fa-solid fa-newspaper"></i> <span>News Manager</span></a></li>
            <li><a href="admin_students.php" class="nav-link"><i class="fa-solid fa-users"></i> <span>Manage Students</span></a></li>
            <li><a href="admin_countries.php" class="nav-link"><i class="fa-solid fa-earth-americas"></i> <span>Manage Countries</span></a></li>
            <li><a href="admin_scholarships.php" class="nav-link"><i class="fa-solid fa-graduation-cap"></i> <span>Manage Scholarships</span></a></li>
            <li><a href="admin_reports.php" class="nav-link"><i class="fa-solid fa-chart-line"></i> <span>Reports & Analytics</span></a></li>
        </ul>
    </aside>

    <main class="content">
