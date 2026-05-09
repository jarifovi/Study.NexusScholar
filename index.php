<?php
// FILE: index.php
require_once 'config.php';
session_start();
if (isLoggedIn()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
