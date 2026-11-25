<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));

// Total Students
$student_count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM students");
$student_count = mysqli_fetch_assoc($student_count_q)['total'];

// Total Teachers
$teacher_count_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM teachers");
$teacher_count = mysqli_fetch_assoc($teacher_count_q)['total'];

// Total enquiries count
$enq_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM enquiries");
$enq_data  = mysqli_fetch_assoc($enq_query);
$total_enquiries = $enq_data['total'];

// 1. Student ID Card Requests (Sirf wo jo abhi Approved NAI hui hain)
$id_request_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM id_card_requests WHERE status != 'Approved' OR status IS NULL");
$total_id_requests = mysqli_fetch_assoc($id_request_q)['total'];

// 2. Manage Student ID Cards (Jo 'Approved' ho chuke hain)
$managed_id_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM id_card_requests WHERE status='Approved'");
$total_managed_id = mysqli_fetch_assoc($managed_id_q)['total'];

// 3. Pending Student ID Cards (Total minus Approved)
$total_pending_id = $student_count - $total_managed_id;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    :root {
        --bg-dark: #0f172a;
        --sidebar-bg: #1e293b;
        --card-bg: #1e293b;
        --text-main: #f8fafc;
        --text-muted: #94a3b8;
    }

    body {
        background-color: var(--bg-dark);
        background-image: radial-gradient(circle at top right, rgba(37, 99, 235, 0.1), transparent 40%),
            radial-gradient(circle at bottom left, rgba(217, 70, 239, 0.1), transparent 40%);
        min-height: 100vh;
        overflow-x: hidden;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-main);
    }

    /* Navbar Styling */
    .navbar {
        background: rgba(15, 23, 42, 0.85) !important;
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        z-index: 1050;
    }

    .welcome-text {
        font-weight: 600;
        background: linear-gradient(to right, #38bdf8, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 0.5px;
    }

    /* Profile Dropdown Customization */
    .profile-img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #38bdf8;
        cursor: pointer;
        transition: 0.3s;
    }

    .profile-img:hover {
        box-shadow: 0 0 12px rgba(56, 189, 248, 0.6);
    }

    .dropdown-menu-dark {
        background-color: var(--sidebar-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Sidebar Styling */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        background: var(--sidebar-bg);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
        padding-top: 80px;
        transition: all 0.3s ease;
        z-index: 1000;
        overflow-y: auto;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        color: var(--text-muted);
        padding: 14px 24px;
        text-decoration: none;
        font-weight: 500;
        transition: 0.3s;
        border-left: 4px solid transparent;
    }

    .sidebar a i {
        width: 28px;
        font-size: 1.1rem;
    }

    .sidebar a:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.05);
        border-left: 4px solid #38bdf8;
        padding-left: 30px;
    }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        padding: 30px;
        margin-top: 70px;
        transition: all 0.3s ease;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #e2e8f0;
        margin-bottom: 20px;
        margin-top: 10px;
        border-bottom: 2px solid rgba(255, 255, 255, 0.05);
        padding-bottom: 10px;
    }

    /* Master Card Styling */
    .card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        height: 100%;
        background: var(--card-bg);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.15);
    }

    /* Top High-Impact Cards */
    .stat-card {
        color: white;
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0) 100%);
        pointer-events: none;
    }

    .stat-card .icon-box {
        background: rgba(255, 255, 255, 0.2);
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }

    .grad-blue {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
    }

    .grad-purple {
        background: linear-gradient(135deg, #7c3aed, #8b5cf6);
    }

    .grad-orange {
        background: linear-gradient(135deg, #ea580c, #f97316);
    }

    .grad-red {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }

    .grad-green {
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .grad-yellow {
        background: linear-gradient(135deg, #d97706, #f59e0b);
    }

    /* Sleek Management Cards */
    .tool-card {
        border: 1px solid rgba(255, 255, 255, 0.05);
        color: var(--text-main);
    }

    .tool-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
    }

    .tool-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .icon-teal {
        background: rgba(20, 184, 166, 0.1);
        color: #14b8a6;
    }

    .icon-rose {
        background: rgba(244, 63, 94, 0.1);
        color: #f43f5e;
    }

    .icon-blue {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }

    .icon-amber {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .icon-indigo {
        background: rgba(99, 102, 241, 0.1);
        color: #6366f1;
    }

    .icon-pink {
        background: rgba(236, 72, 153, 0.1);
        color: #ec4899;
    }

    .btn-custom {
        border-radius: 8px;
        font-weight: 500;
        padding: 6px 20px;
        text-decoration: none;
        transition: 0.3s;
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .btn-custom:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .tool-card .btn-custom {
        background: rgba(56, 189, 248, 0.1);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.2);
    }

    .tool-card .btn-custom:hover {
        background: #38bdf8;
        color: #0f172a;
    }

    h3 {
        font-weight: 700;
        font-size: 2.2rem;
        margin-bottom: 5px;
    }

    h5 {
        font-weight: 500;
        font-size: 1rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }

    /* Chart Container Styling */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Mobile Responsive */
    @media(max-width: 992px) {
        .sidebar {
            left: -250px;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            margin-left: 0;
            padding: 15px;
        }
    }

    @media(max-width: 576px) {
        .welcome-text {
            display: none !important;
        }

    }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark fixed-top px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-light me-3 d-lg-none border-0" id="menu-toggle"><i
                    class="fas fa-bars"></i></button>
            <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
        </div>

        <span class="welcome-text d-none d-lg-block position-absolute start-50 translate-middle-x fs-5">
            Welcome, <?php echo htmlspecialchars($admin['full_name']); ?>
        </span>

        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block" style="font-size: 0.9rem; opacity: 0.8;">
                <?php echo htmlspecialchars($admin['email']); ?>
            </span>

            <div class="dropdown">
                <a href="#" class="d-block text-decoration-none dropdown-toggle-no-caret" id="dropdownUser"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="uploads/admin/<?php echo $admin['profile_image'] ?? 'default.png'; ?>" class="profile-img"
                        alt="Profile">
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow mt-2"
                    aria-labelledby="dropdownUser">
                    <li>
                        <span class="dropdown-header text-info d-md-none">
                            <?php echo htmlspecialchars($admin['full_name']); ?></span>
                    </li>

                    <li><a class="dropdown-item text-light" href="profile.php"><i class="fas fa-user-circle me-2"></i>
                            My Profile</a></li>
                    <li><a class="dropdown-item text-light" href="change_password.php"><i class="fas fa-key me-2"></i>
                            Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider border-secondary">
                    </li>
                    <li><a class="dropdown-item text-danger" href="../auth/logout.php"><i
                                class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="manage_students.php"><i class="fa fa-users"></i> Students</a>
        <a href="manage_teachers.php"><i class="fa fa-chalkboard-teacher"></i> Teachers</a>
        <a href="attendance_reports.php"><i class="fa fa-calendar-check"></i> Attendance</a>
        <a href="attendance_reports.php"><i class="fa fa-file-pdf"></i> Reports</a>
        <a href="profile.php"><i class="fa fa-id-badge"></i> Profile</a>
        <a href="change_password.php"><i class="fa-solid fa-unlock"></i> Password</a>
        <hr>
        <a class="dropdown-item text-danger" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>
            Logout</a>

    </div>

    <div class="main-content">

        <h4 class="section-title">Main Overview</h4>
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 text-center grad-blue">
                    <div class="icon-box"><i class="fa fa-users fa-2x"></i></div>
                    <h3><?php echo $student_count; ?></h3>
                    <h5>Total Students</h5>
                    <a href="manage_students.php" class="btn-custom d-inline-block">Manage</a>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 text-center grad-purple">
                    <div class="icon-box"><i class="fa fa-chalkboard-teacher fa-2x"></i></div>
                    <h3><?php echo $teacher_count; ?></h3>
                    <h5>Total Teachers</h5>
                    <a href="manage_teachers.php" class="btn-custom d-inline-block">Manage</a>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 text-center grad-orange">
                    <div class="icon-box"><i class="fa-solid fa-envelope fa-2x"></i></div>
                    <h3><?php echo $total_enquiries; ?></h3>
                    <h5>Total Enquiries</h5>
                    <a href="View_enquiries.php" class="btn-custom d-inline-block">View All</a>
                </div>
            </div>
        </div>

        <h4 class="section-title">Analytics & Statistics</h4>
        <div class="row g-4 mb-5">
            <div class="col-12 col-lg-7">
                <div class="card p-4">
                    <h5 class="text-center text-light mb-4">System Users Overview</h5>
                    <div class="chart-container">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-5">
                <div class="card p-4">
                    <h5 class="text-center text-light mb-4">ID Card Generation Status</h5>
                    <div class="chart-container">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="section-title">ID Card Status</h4>
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 text-center grad-red">
                    <div class="icon-box"><i class="fas fa-id-card-alt fa-2x"></i></div>
                    <h3><?php echo $total_id_requests; ?></h3>
                    <h5>ID Card Requests</h5>
                    <a href="id_card_requests.php" class="btn-custom d-inline-block">View</a>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 text-center grad-green">
                    <div class="icon-box"><i class="fas fa-address-card fa-2x"></i></div>
                    <h3><?php echo $total_managed_id; ?></h3>
                    <h5>Approved Cards</h5>
                    <a href="manage_id_cards.php" class="btn-custom d-inline-block">Manage</a>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card stat-card p-4 text-center grad-yellow">
                    <div class="icon-box"><i class="fas fa-exclamation-circle fa-2x"></i></div>
                    <h3><?php echo $total_pending_id; ?></h3>
                    <h5>Pending Cards</h5>
                    <a href="id_card_not_generated.php" class="btn-custom d-inline-block">View</a>
                </div>
            </div>
        </div>

        <h4 class="section-title">Academic & Management Tools</h4>
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-teal"><i class="fas fa-chart-line"></i></div>
                    <h5>Teacher Perf.</h5>
                    <a href="teacher_performance_report.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-rose"><i class="fas fa-clipboard-list"></i></div>
                    <h5>Attendance</h5>
                    <a href="attendance_reports.php" class="btn-custom d-inline-block">View</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-amber"><i class="fas fa-calendar-plus"></i></div>
                    <h5>Add Holiday</h5>
                    <a href="add_holiday.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-amber"><i class="fas fa-calendar-check"></i></div>
                    <h5>Manage Holidays</h5>
                    <a href="manage_holidays.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>



            <h4 class="section-title mt-5">Website Content</h4>
            
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card tool-card p-4 text-center">
                        <div class="tool-icon icon-indigo"><i class="fa fa-bullhorn"></i></div>
                        <h5>Add Notice</h5>
                        <a href="add_notice.php" class="btn-custom d-inline-block">Open</a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card tool-card p-4 text-center">
                        <div class="tool-icon icon-indigo"><i class="fa fa-bell"></i></div>
                        <h5>Manage Notice</h5>
                        <a href="manage_notices.php" class="btn-custom d-inline-block">Open</a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card tool-card p-4 text-center">
                        <div class="tool-icon icon-blue"><i class="fa fa-clock"></i></div>
                        <h5>Exam Schedule</h5>
                        <a href="exam_schedule.php" class="btn-custom d-inline-block">Open</a>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card tool-card p-4 text-center">
                        <div class="tool-icon icon-blue"><i class="fa fa-tasks"></i></div>
                        <h5>Manage Exams</h5>
                        <a href="manage_exam_schedule.php" class="btn-custom d-inline-block">Open</a>
                    </div>
                </div>
            
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-pink"><i class="fa fa-images"></i></div>
                    <h5>Add Gallery</h5>
                    <a href="add_gallery.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-pink"><i class="fa fa-photo-video"></i></div>
                    <h5>Manage Gallery</h5>
                    <a href="manage_gallery.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-teal"><i class="fa fa-user-tie"></i></div>
                    <h5>Principal Desk</h5>
                    <a href="principal_message.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-teal"><i class="fa fa-user-edit"></i></div>
                    <h5>Manage Desk</h5>
                    <a href="manage_principal_message.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-teal"><i class="fa fa-user-edit"></i></div>
                    <h5>Manage syllabus</h5>
                    <a href="manage_syllabus.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-teal"><i class="fa fa-user-edit"></i></div>
                    <h5>Manage Application</h5>
                    <a href="admin_leave_panel.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card tool-card p-4 text-center">
                    <div class="tool-icon icon-teal"><i class="fa fa-user-edit"></i></div>
                    <h5>Manage Grievance</h5>
                    <a href="manage_grievance.php" class="btn-custom d-inline-block">Open</a>
                </div>
            </div>

        </div>

    </div>

    <footer class="text-center mt-5 pb-4" style="color: var(--text-muted); font-size: 0.9rem;">
        © <?php echo date("Y"); ?> Online Attendance System | Admin Panel
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Sidebar Toggle
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("sidebar").classList.toggle("active");
    });

    document.addEventListener("click", function(event) {
        var sidebar = document.getElementById("sidebar");
        var menuToggle = document.getElementById("menu-toggle");

        if (window.innerWidth <= 992 && sidebar.classList.contains("active")) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove("active");
            }
        }
    });

    // ----------------------------------------------------
    // Chart.js Configuration
    // ----------------------------------------------------

    // Global defaults for dark theme
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";

    // 1. Bar Chart (System Users)
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Students', 'Teachers', 'Enquiries'],
            datasets: [{
                label: 'Total Count',
                data: [
                    <?php echo $student_count; ?>,
                    <?php echo $teacher_count; ?>,
                    <?php echo $total_enquiries; ?>
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)', // Blue
                    'rgba(139, 92, 246, 0.8)', // Purple
                    'rgba(249, 115, 22, 0.8)' // Orange
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(139, 92, 246, 1)',
                    'rgba(249, 115, 22, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // 2. Doughnut Chart (ID Card Status)
    const ctxPie = document.getElementById('pieChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: ['Approved Cards', 'Pending/Not Generated'],
            datasets: [{
                data: [
                    <?php echo $total_managed_id; ?>,
                    <?php echo $total_pending_id; ?>
                ],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)', // Green
                    'rgba(245, 158, 11, 0.8)' // Yellow/Orange
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)'
                ],
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20
                    }
                }
            }
        }
    });
    </script>

</body>

</html>