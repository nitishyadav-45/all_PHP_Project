<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getProfile($pdo) {
    $stmt = $pdo->query("SELECT * FROM profile LIMIT 1");
    return $stmt->fetch();
}

function getSettings($pdo) {
    $stmt = $pdo->query("SELECT * FROM settings LIMIT 1");
    return $stmt->fetch();
}

function getSkills($pdo) {
    $stmt = $pdo->query("SELECT * FROM skills ORDER BY percentage DESC");
    return $stmt->fetchAll();
}

function getServices($pdo) {
    $stmt = $pdo->query("SELECT * FROM services");
    return $stmt->fetchAll();
}

function getProjects($pdo) {
    $stmt = $pdo->query("SELECT * FROM projects");
    return $stmt->fetchAll();
}

function getExperiences($pdo) {
    $stmt = $pdo->query("SELECT * FROM experiences ORDER BY start_date DESC");
    return $stmt->fetchAll();
}

function getEducation($pdo) {
    $stmt = $pdo->query("SELECT * FROM education ORDER BY start_date DESC");
    return $stmt->fetchAll();
}

function getCertificates($pdo) {
    $stmt = $pdo->query("SELECT * FROM certificates ORDER BY date_issued DESC");
    return $stmt->fetchAll();
}

function getTestimonials($pdo) {
    $stmt = $pdo->query("SELECT * FROM testimonials");
    return $stmt->fetchAll();
}

function format_date($date) {
    return date('M Y', strtotime($date));
}
?>
