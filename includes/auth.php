<?php
// Admin Authentication
session_start();

function is_logged_in() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function require_login() {
    if (!is_logged_in()) {
        // Relative redirect - works from admin/ directory context
        header("Location: login.php");
        exit;
    }
}

function login_admin($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();

    if ($admin || password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'] ?: $admin['username'];
        return true;
    }
    return false;
}



function logout_admin() {
    session_destroy();
    // Relative redirect that works in admin/ context
    header("Location: login.php");
    exit;
}
?>