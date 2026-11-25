<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'portfolio_database');

// Site Configuration
define('SITE_URL', 'http://localhost/portfolio/');
define('ADMIN_URL', 'http://localhost/portfolio/admin/');

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

// Session Configuration
session_start();

// Error Handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Helper function to sanitize input
function sanitize($data) {
    global $conn;
    return $conn->real_escape_string(trim($data));
}

// Helper function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

// Helper function to redirect
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Helper function to get user data
function getUserData() {
    global $conn;
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = $user_id";
        $result = $conn->query($query);
        return $result->fetch_assoc();
    }
    return null;
}

// Helper function to get all services
function getAllServices() {
    global $conn;
    $query = "SELECT * FROM services ORDER BY id ASC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Helper function to get all skills
function getAllSkills() {
    global $conn;
    $query = "SELECT * FROM skills ORDER BY id ASC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Helper function to get all projects
function getAllProjects() {
    global $conn;
    $query = "SELECT p.*, pc.name as category_name FROM projects p 
              LEFT JOIN project_categories pc ON p.category_id = pc.id 
              ORDER BY p.created_at DESC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Helper function to get projects by category
function getProjectsByCategory($category_slug) {
    global $conn;
    $query = "SELECT p.*, pc.name as category_name FROM projects p 
              LEFT JOIN project_categories pc ON p.category_id = pc.id 
              WHERE pc.slug = '$category_slug' OR pc.id = 0
              ORDER BY p.created_at DESC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Helper function to get all testimonials
function getAllTestimonials() {
    global $conn;
    $query = "SELECT * FROM testimonials ORDER BY created_at DESC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Helper function to get all project categories
function getAllCategories() {
    global $conn;
    $query = "SELECT * FROM project_categories ORDER BY name ASC";
    $result = $conn->query($query);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
