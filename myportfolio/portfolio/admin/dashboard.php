<?php
require_once('../config/auth.php');
require_once('../config/db.php');

// Database queries (Kept exact same as yours)
$totalProjects = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM projects"));
$totalBlogs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM blogs"));
$totalMessages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM contact_messages"));
$totalVisitors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM visitors"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    /* Sidebar Layout Updates */
    .sidebar-wrapper {
        min-height: 100vh;
        width: 280px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
    }

    /* Main Content Wrapper to offset fixed sidebar */
    .main-content {
        margin-left: 280px;
        width: calc(100% - 280px);
        min-height: 100vh;
    }

    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .quick-btn {
        border-radius: 8px;
        padding: 12px 20px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .quick-btn:hover {
        filter: brightness(0.9);
    }

    .sidebar-link {
        transition: all 0.2s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff !important;
    }

    .sidebar-link:hover i {
        color: #0d6efd !important;
    }

    .logout-link {
        transition: all 0.2s ease-in-out;
    }

    .logout-link:hover {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545 !important;
    }

    .sidebar-link.active {
        background-color: #0d6efd !important;
        color: white !important;
    }

    .sidebar-link.active i {
        color: white !important;
    }

    /* Responsive Media Queries */
    @media (max-width: 991.98px) {
        .sidebar-wrapper {
            display: none;
            /* Desktop sidebar hide on mobile */
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark d-lg-none px-3 sticky-top shadow-sm">
        <div class="container-fluid px-0">
            <a href="../admin/dashboard.php" class="navbar-brand d-flex align-items-center gap-2 m-0">
                <i class="bi bi-shield-lock-fill text-primary"></i>
                <span class="fw-bold fs-5">Nitish Admin</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="d-flex">

        <div class="sidebar-wrapper bg-dark text-white p-3 d-none d-lg-flex flex-column justify-content-between">
            <div>
                <a href="../admin/dashboard.php"
                    class="d-flex align-items-center mb-3 text-white text-decoration-none gap-2 px-2 mt-2">
                    <i class="bi bi-shield-lock-fill fs-4 text-primary"></i>
                    <span class="fs-4 fw-bold">Nitish Admin</span>
                </a>
                <hr class="border-secondary my-3">

                <ul class="nav nav-pills flex-column mb-auto gap-1">
                    <li class="nav-item">
                        <a href="../admin/dashboard.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link active">
                            <i class="bi bi-speedometer2 fs-5 text-secondary"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../projects/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-folder-fill fs-5 text-secondary"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="../admin/skills/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-code-slash fs-5 text-secondary"></i>
                            <span>Skills</span>
                        </a>
                    </li>
                    <li>
                        <a href="../education/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-mortarboard-fill fs-5 text-secondary"></i>
                            <span>Education</span>
                        </a>
                    </li>
                    <li>
                        <a href="../experience/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-briefcase-fill fs-5 text-secondary"></i>
                            <span>Experience</span>
                        </a>
                    </li>
                    <li>
                        <a href="../resume/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-file-earmark-person-fill fs-5 text-secondary"></i>
                            <span>Resume</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <hr class="border-secondary my-3">
                <a href="../logout.php"
                    class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
                    <i class="bi bi-box-arrow-left fs-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>


        <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar"
            aria-labelledby="mobileSidebarLabel" style="width: 280px;">
            <div class="offcanvas-header border-bottom border-secondary">
                <h5 class="offcanvas-title d-flex align-items-center gap-2 text-white" id="mobileSidebarLabel">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Nitish Admin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-close="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="nav nav-pills flex-column mb-auto gap-1">
                    <li class="nav-item">
                        <a href="../admin/dashboard.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link active">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../projects/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-folder-fill fs-5"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="../skills/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-code-slash fs-5"></i>
                            <span>Skills</span>
                        </a>
                    </li>
                    <li>
                        <a href="../education/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-mortarboard-fill fs-5"></i>
                            <span>Education</span>
                        </a>
                    </li>
                    <li>
                        <a href="../experience/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-briefcase-fill fs-5"></i>
                            <span>Experience</span>
                        </a>
                    </li>
                    <li>
                        <a href="../resume/index.php"
                            class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-file-earmark-person-fill fs-5"></i>
                            <span>Resume</span>
                        </a>
                    </li>
                </ul>

                <div>
                    <hr class="border-secondary my-3">
                    <a href="../logout.php"
                        class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
                        <i class="bi bi-box-arrow-left fs-5"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>


        <div class="main-content p-3 p-md-5">

            <div
                class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 pb-3 border-bottom gap-3">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Welcome,
                        <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin'); ?>!</h2>
                    <p class="text-muted small mb-0">Here's what's happening with your portfolio today.</p>
                </div>
                <div class="d-none d-sm-block">
                    <a href="logout.php" class="btn btn-outline-danger d-flex align-items-center gap-2 quick-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </div>
            </div>

            <div class="row g-3 g-md-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm h-100 border-start border-primary border-4">
                        <div class="card-body">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-folder2-open"></i>
                            </div>
                            <h6 class="text-muted text-uppercase fs-7 fw-semibold">Projects</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalProjects['total'] ?? 0 ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm h-100 border-start border-success border-4">
                        <div class="card-body">
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <h6 class="text-muted text-uppercase fs-7 fw-semibold">Blogs</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalBlogs['total'] ?? 0 ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm h-100 border-start border-warning border-4">
                        <div class="card-body">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-envelope-open"></i>
                            </div>
                            <h6 class="text-muted text-uppercase fs-7 fw-semibold">Messages</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalMessages['total'] ?? 0 ?></h3>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card shadow-sm h-100 border-start border-info border-4">
                        <div class="card-body">
                            <div class="icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-people"></i>
                            </div>
                            <h6 class="text-muted text-uppercase fs-7 fw-semibold">Visitors</h6>
                            <h3 class="fw-bold mb-0 text-dark"><?= $totalVisitors['total'] ?? 0 ?></h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-sliders text-primary"></i> Quick Actions & Management
                </h5>

                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="../admin/projects/add-project.php"
                            class="btn btn-success w-100 quick-btn d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-plus-circle"></i> Add Project
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="../admin/projects/manage-projects.php"
                            class="btn btn-primary w-100 quick-btn d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-kanban"></i> Manage Projects
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="manage-education.php"
                            class="btn btn-info text-white w-100 quick-btn d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-mortarboard"></i> Education
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <a href="manage-experience.php"
                            class="btn btn-warning text-white w-100 quick-btn d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-briefcase"></i> Experience
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>