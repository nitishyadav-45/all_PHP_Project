<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function checkLogin() {
    if (!isLoggedIn()) {
        header("Location: " . SITE_URL . "admin/index.php");
        exit();
    }
}
?>
