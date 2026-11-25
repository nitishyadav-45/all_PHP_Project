<?php
require_once '../includes/auth.php';
require_once '../includes/config.php';
require_once '../includes/functions.php';
checkAuth();

// Simple stats
$msgCount = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
$projCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$skillCount = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f7f6; }
        .sidebar { height: 100vh; background: #2c3e50; color: white; padding-top: 20px; position: fixed; width: 250px; }
        .sidebar a { color: #bdc3c7; text-decoration: none; padding: 10px 20px; display: block; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #34495e; color: white; }
        .main-content { margin-left: 250px; padding: 30px; }
        .card-stat { border-radius: 10px; border: none; transition: 0.3s; }
        .card-stat:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center mb-4">Admin Panel</h4>
        <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a href="profile/index.php"><i class="fas fa-user me-2"></i> Profile</a>
        <a href="services/index.php"><i class="fas fa-concierge-bell me-2"></i> Services</a>
        <a href="skills/index.php"><i class="fas fa-tools me-2"></i> Skills</a>
        <a href="projects/index.php"><i class="fas fa-project-diagram me-2"></i> Projects</a>
        <a href="experience/index.php"><i class="fas fa-briefcase me-2"></i> Experience</a>
        <a href="education/index.php"><i class="fas fa-graduation-cap me-2"></i> Education</a>
        <a href="certificates/index.php"><i class="fas fa-certificate me-2"></i> Certificates</a>
        <a href="messages/index.php"><i class="fas fa-envelope me-2"></i> Messages</a>
        <a href="settings/index.php"><i class="fas fa-cog me-2"></i> Settings</a>
        <hr>
        <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </div>

    <div class="main-content">
        <h2 class="mb-4">Dashboard Overview</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-stat bg-primary text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3><?php echo $msgCount; ?></h3>
                            <p class="mb-0">Total Messages</p>
                        </div>
                        <i class="fas fa-envelope fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat bg-success text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3><?php echo $projCount; ?></h3>
                            <p class="mb-0">Total Projects</p>
                        </div>
                        <i class="fas fa-project-diagram fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stat bg-warning text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3><?php echo $skillCount; ?></h3>
                            <p class="mb-0">Total Skills</p>
                        </div>
                        <i class="fas fa-tools fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-5">
            <h4>Quick Actions</h4>
            <div class="list-group">
                <a href="profile/index.php" class="list-group-item list-group-item-action">Update Profile Information</a>
                <a href="projects/index.php" class="list-group-item list-group-item-action">Add New Project</a>
                <a href="messages/index.php" class="list-group-item list-group-item-action">View Latest Messages</a>
            </div>
        </div>
    </div>
</body>
</html>
