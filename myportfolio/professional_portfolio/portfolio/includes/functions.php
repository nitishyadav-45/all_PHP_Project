<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function getProfile($pdo) {
    $stmt = $pdo->query("SELECT * FROM profile LIMIT 1");
    return $stmt->fetch();
}

function getServices($pdo) {
    $stmt = $pdo->query("SELECT * FROM services");
    return $stmt->fetchAll();
}

function getSkills($pdo) {
    $stmt = $pdo->query("SELECT * FROM skills");
    return $stmt->fetchAll();
}

function getProjects($pdo) {
    $stmt = $pdo->query("SELECT * FROM projects");
    return $stmt->fetchAll();
}

function getExperience($pdo) {
    $stmt = $pdo->query("SELECT * FROM experience");
    return $stmt->fetchAll();
}

function getEducation($pdo) {
    $stmt = $pdo->query("SELECT * FROM education");
    return $stmt->fetchAll();
}

function getCertificates($pdo) {
    $stmt = $pdo->query("SELECT * FROM certificates");
    return $stmt->fetchAll();
}

function getSettings($pdo) {
    $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
    return $stmt->fetch();
}
?>
