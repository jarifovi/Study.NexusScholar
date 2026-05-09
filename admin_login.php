<?php
// FILE: admin_login.php
require_once 'config.php';
session_start();

$login_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $login_error = "Please enter username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && md5($password) === $admin['password_hash']) {
            $_SESSION['is_admin'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_email'] = $admin['username'];
            header('Location: admin_dashboard.php');
            exit;
        } else {
            $login_error = "Invalid username or password.";
        }
    }
}

$page_title = "Admin Login";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?> - NexusScholar Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth-body">
<div class="ambient-glow glow-1"></div>
<div class="ambient-glow glow-2"></div>
<div class="auth-card glass-card">
    <h2><i class="fa-solid fa-lock" style="color:var(--primary); margin-right:10px;"></i> Admin Login</h2>

    <?php if ($login_error): ?>
        <div class="alert error"><i class="fa-solid fa-circle-exclamation" style="margin-right:10px; font-size:18px;"></i> <?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label><i class="fa-solid fa-user" style="color:var(--text-muted); margin-right:5px;"></i> Username</label>
        <input type="text" name="username" required placeholder="Enter admin username">

        <label><i class="fa-solid fa-key" style="color:var(--text-muted); margin-right:5px;"></i> Password</label>
        <input type="password" name="password" required placeholder="Enter password">

        <button type="submit" class="btn-primary full-width" style="margin-top:10px;"><i class="fa-solid fa-right-to-bracket" style="margin-right:8px;"></i> Secure Login</button>
    </form>

    <p class="auth-switch" style="text-align:center; margin-top:25px;">
        <i class="fa-solid fa-arrow-left" style="margin-right:5px;"></i> Back to <a href="login.php">Student Login</a>
    </p>
</div>
</body>
</html>
