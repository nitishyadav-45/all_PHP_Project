<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Fetch all data
$profile = getProfile($pdo);
$services = getServices($pdo);
$skills = getSkills($pdo);
$projects = getProjects($pdo);
$experience = getExperience($pdo);
$education = getEducation($pdo);
$certificates = getCertificates($pdo);
$settings = getSettings($pdo);

// Include Header
include 'includes/header.php';
// Include Navbar
include 'includes/navbar.php';

// Main Sections
include 'includes/hero.php';
include 'includes/about.php';
include 'includes/services.php';
include 'includes/skills.php';
include 'includes/projects.php';
include 'includes/experience.php';
include 'includes/certificates.php';
include 'includes/contact.php';

// Include Footer
include 'includes/footer.php';
include 'includes/scripts.php';
?>
