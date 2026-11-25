<?php
require_once '../config.php';
if (!isLoggedIn()) redirect('../admin_login.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM skills WHERE id = $id");
}
redirect('dashboard.php');
?>