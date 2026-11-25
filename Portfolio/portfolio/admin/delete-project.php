<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Optional: Delete the image file from server
    $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    if ($project && file_exists("../uploads/projects/" . $project['image'])) {
        unlink("../uploads/projects/" . $project['image']);
    }

    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: dashboard.php');
exit;
?>
