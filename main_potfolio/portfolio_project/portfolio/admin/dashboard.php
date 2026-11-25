<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
checkLogin();

// Get counts for dashboard
$skills_count = $pdo->query("SELECT COUNT(*) FROM skills")->fetchColumn();
$projects_count = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$messages_count = $pdo->query("SELECT COUNT(*) FROM contacts WHERE is_read = 0")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { height: 100vh; background: #212529; color: #fff; position: fixed; width: 250px; }
        .sidebar a { color: rgba(255,255,255,0.8); text-decoration: none; padding: 15px 20px; display: block; }
        .sidebar a:hover, .sidebar a.active { background: #343a40; color: #fff; }
        .main-content { margin-left: 250px; padding: 30px; }
        .stat-card { border-radius: 10px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="p-4 text-center">
            <h4 class="fw-bold">Admin Panel</h4>
        </div>
        <nav>
            <a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="profile/index.php"><i class="fas fa-user me-2"></i> Profile</a>
            <a href="skills/index.php"><i class="fas fa-code me-2"></i> Skills</a>
            <a href="projects/index.php"><i class="fas fa-project-diagram me-2"></i> Projects</a>
            <a href="services/index.php"><i class="fas fa-project-diagram me-2"></i> Services</a>
            <a href="experiences/index.php"><i class="fas fa-project-diagram me-2"></i> Experiences</a>
            <a href="education/index.php"><i class="fas fa-project-diagram me-2"></i> Education</a>
            <a href="certificates/index.php"><i class="fas fa-project-diagram me-2"></i> Certificate</a>
            <a href="contacts/index.php"><i class="fas fa-envelope me-2"></i> Messages</a>
            <a href="logout.php" class="text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="d-flex justify-content-between align-items-center mb-5">
            <h2>Welcome, <?php echo $_SESSION['admin_name']; ?></h2>
            <a href="../index.php" target="_blank" class="btn btn-outline-primary">View Site</a>
        </header>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card stat-card bg-primary text-white p-4">
                    <h5>Total Skills</h5>
                    <h3><?php echo $skills_count; ?></h3>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card bg-success text-white p-4">
                    <h5>Total Projects</h5>
                    <h3><?php echo $projects_count; ?></h3>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card bg-warning text-dark p-4">
                    <h5>New Messages</h5>
                    <h3><?php echo $messages_count; ?></h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
