<?php
// FILE: register.php
require_once 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $error = 'All fields are required.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - NexusScholar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth-body">
<div class="ambient-glow glow-1"></div>
<div class="ambient-glow glow-2"></div>
<div class="auth-card glass-card">
    <h2><i class="fa-solid fa-user-plus" style="color:var(--primary); margin-right:10px;"></i> Create Account</h2>
    <?php if ($error): ?>
        <div class="alert error"><i class="fa-solid fa-circle-exclamation" style="margin-right:10px; font-size:18px;"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
        <label><i class="fa-solid fa-id-card" style="color:var(--text-muted); margin-right:5px;"></i> Full Name</label>
        <input type="text" name="full_name" required placeholder="Enter your full name">

        <label><i class="fa-solid fa-envelope" style="color:var(--text-muted); margin-right:5px;"></i> Email</label>
        <input type="email" name="email" required placeholder="Enter your email address">

        <label><i class="fa-solid fa-key" style="color:var(--text-muted); margin-right:5px;"></i> Password</label>
        <input type="password" name="password" required placeholder="Create a password">

        <button type="submit" class="btn-primary full-width" style="margin-top:10px;"><i class="fa-solid fa-user-check" style="margin-right:8px;"></i> Register</button>
    </form>
    <p class="auth-switch" style="text-align:center; margin-top:20px;">Already have an account? <a href="login.php" style="color:var(--primary); text-decoration:none;"><i class="fa-solid fa-right-to-bracket" style="margin-right:5px;"></i> Login</a></p>
</div>
</body>
</html>
