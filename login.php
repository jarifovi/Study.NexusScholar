<?php
// FILE: login.php
require_once 'config.php';

session_start();

/**
 * Flexible password check:
 * supports MD5, password_hash() (bcrypt) and plain text (legacy).
 */
function check_password_match(string $plain, ?string $stored): bool
{
    if ($stored === null || $stored === '') {
        return false;
    }

    // legacy plain text
    if ($stored === $plain) {
        return true;
    }

    // MD5
    if ($stored === md5($plain)) {
        return true;
    }

    // password_hash() (bcrypt / argon2)
    if (password_verify($plain, $stored)) {
        return true;
    }

    return false;
}

/* -------------------------------------------------
   Auto-redirect ONLY if we have a valid session
------------------------------------------------- */
if (isset($_SESSION['is_admin'])) {
    if ($_SESSION['is_admin'] && isset($_SESSION['admin_id'])) {
        header("Location: admin_dashboard.php");
        exit;
    }
    if (!$_SESSION['is_admin'] && isset($_SESSION['user_id'])) {
        header("Location: dashboard.php");
        exit;
    }
    // If is_admin is set but IDs are missing, treat as not logged in
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = "Please enter both email and password.";
    } else {

        /* --------------------
           1) Try ADMIN login
        -------------------- */
        $stmtAdmin = $pdo->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
        $stmtAdmin->execute([$email]);
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $storedAdminPass = $admin['password_hash'] ?? ($admin['password'] ?? null);

            if (check_password_match($password, $storedAdminPass)) {
                // reset and set admin session
                $_SESSION = [];
                $_SESSION['is_admin']    = true;
                $_SESSION['admin_id']    = $admin['id'];
                $_SESSION['admin_name']  = $admin['full_name'] ?? 'Admin';
                $_SESSION['admin_email'] = $admin['username'];

                header("Location: admin_dashboard.php");
                exit;
            }
        }

        /* --------------------
           2) Try STUDENT login
        -------------------- */
        $stmtUser = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmtUser->execute([$email]);
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // students use password_hash() in password_hash column
            $storedUserPass = $user['password_hash'] ?? ($user['password'] ?? null);

            if (check_password_match($password, $storedUserPass)) {
                // reset and set user session
                $_SESSION = [];
                $_SESSION['is_admin']   = false;
                $_SESSION['user_id']    = $user['id'];
                $_SESSION['user_name']  = $user['full_name'] ?? ($user['name'] ?? 'Student');
                $_SESSION['user_email'] = $user['email'];

                header("Location: dashboard.php");
                exit;
            }
        }

        // If we reach here, login failed
        $error = "Invalid email or password.";
    }
}

$page_title = "Login";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title) ?> - NexusScholar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="auth-body">
<div class="ambient-glow glow-1"></div>
<div class="ambient-glow glow-2"></div>
<div class="auth-card glass-card">
    <h2 style="margin-bottom: 10px;"><i class="fa-solid fa-graduation-cap" style="color:var(--primary); margin-right:10px;"></i> Welcome Back</h2>
    <p style="margin-bottom: 30px; opacity: 0.8; text-align:center;">Use your email and password to continue.</p>

    <?php if (isset($_GET['registered'])): ?>
        <div class="alert success"><i class="fa-solid fa-circle-check" style="margin-right:10px; font-size:18px;"></i> Registration successful. Please log in.</div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert error"><i class="fa-solid fa-circle-exclamation" style="margin-right:10px; font-size:18px;"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label><i class="fa-solid fa-envelope" style="color:var(--text-muted); margin-right:5px;"></i> Email or Username</label>
        <input type="text" name="email" required placeholder="you@example.com">

        <label><i class="fa-solid fa-key" style="color:var(--text-muted); margin-right:5px;"></i> Password</label>
        <input type="password" name="password" required placeholder="Enter your password">

        <button type="submit" class="btn-primary full-width" style="margin-top: 15px;"><i class="fa-solid fa-right-to-bracket" style="margin-right:8px;"></i> Secure Login</button>
    </form>

    <p class="auth-switch" style="text-align:center; margin-top:25px;">
        Don’t have an account? <a href="register.php" style="color:var(--primary); text-decoration:none;"><i class="fa-solid fa-user-plus" style="margin-right:5px;"></i> Create one</a>
    </p>
    
    <p class="auth-switch" style="text-align:center; margin-top:15px;">
        Are you an Admin? <a href="admin_login.php" style="color:var(--secondary); text-decoration:none;"><i class="fa-solid fa-shield-halved" style="margin-right:5px;"></i> Admin Login</a>
    </p>
</div>
</body>
</html>
