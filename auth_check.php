<?php
// FILE: auth_check.php
require_once 'config.php';
session_start();

if (
    !isset($_SESSION['user_id']) ||       // no user id
    !isset($_SESSION['is_admin']) ||      // no role flag
    $_SESSION['is_admin']                 // but role is admin
) {
    header("Location: login.php");
    exit;
}
