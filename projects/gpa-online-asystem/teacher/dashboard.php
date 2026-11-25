<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

//new code add emai show karane KE liye  start

$teacher_id = $_SESSION['teacher_id'];

// Fetch teacher data
$query = mysqli_query($conn, "SELECT * FROM teachers WHERE id='$teacher_id'");
$teacher = mysqli_fetch_assoc($query);

// New code end



$teacher_name = $_SESSION['teacher_name'];
// $teacher_email = $_SESSION['email'];
$branch = $_SESSION['branch'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];
$teacher_image = $_SESSION['teacher_image'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Smart Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --bg-light: #f8f9fd;
        --sidebar-dark: #1e1e2d;
        --text-muted: #6c757d;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--bg-light);
        overflow-x: hidden;
    }

    /* --- Sidebar Style --- */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 260px;
        background: var(--sidebar-dark);
        padding-top: 80px;
        z-index: 1000;
        transition: all 0.3s ease;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar a {
        color: #a2a3b7;
        display: flex;
        align-items: center;
        padding: 12px 25px;
        text-decoration: none;
        font-size: 0.95rem;
        transition: 0.3s;
        margin: 4px 15px;
        border-radius: 8px;
    }

    .sidebar a i {
        width: 25px;
        font-size: 1.1rem;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: rgba(67, 97, 238, 0.15);
        color: #fff;
    }

    .sidebar a:hover i {
        color: var(--primary-color);
    }

    /* --- Main Content --- */
    .main-content {
        margin-left: 260px;
        padding: 100px 30px 30px 30px;
        transition: all 0.3s ease;
    }

    /* --- Navbar --- */
    .navbar {
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #eee;
        padding: 15px 30px;
        margin-left: 260px;
        width: calc(100% - 260px);
    }

    .navbar-brand {
        /* color: var(--sidebar-dark) !important; */
        font-weight: 400;
        letter-spacing: -0.5px;


    }

    .welcome-text {
        color: var(--sidebar-dark) !important;
        font-weight: 600;
    }

    /* --- Cards Style --- */
    .info-card {
        background: #fff;
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
    }

    .stat-card {
        padding: 30px;
        border-radius: 20px;
        border: none;
        color: white;
        position: relative;
        z-index: 1;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        right: -20px;
        bottom: -20px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: -1;
    }

    .btn-action {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: white;
        backdrop-filter: blur(5px);
        border-radius: 10px;
        padding: 8px 20px;
        transition: 0.3s;
    }

    .btn-action:hover {
        background: white;
        color: var(--primary-color);
    }

    /* Profile Dropdown */
    .profile-img {
        border: 2px solid var(--primary-color);
        padding: 2px;
    }

    /* Responsive */
    @media(max-width:992px) {
        .sidebar {
            left: -260px;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content,
        .navbar {
            margin-left: 0;
            width: 100%;
        }

        .welcome-text {
            display: none !important;
        }
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-fluid">
            <button class="btn d-lg-none" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand ms-2">GPA Azamgarh</span>

            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <a class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" href="#"
                        role="button" data-bs-toggle="dropdown">
                        <div class="text-end me-3 d-none d-sm-block">
                            <small class="text-muted d-block" style="font-size: 10px;">
                                
                                <!-- <?php echo htmlspecialchars($teacher_email); ?> -->
                                 <?php echo $teacher['email']; ?>
                                
                            </small>
                           
                            <span class="fw-bold"><?php echo $teacher_name; ?></span>
                        </div>
                        <img src="uploads/teachers/<?php echo $teacher_image; ?>" class="rounded-circle profile-img"
                            width="40" height="40" style="object-fit:cover;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-3">
                        
                        <li><a class="dropdown-item p-3" href="profile.php"><i class="fas fa-user-circle me-2"></i> My
                                Profile</a></li>
                        <li><a class="dropdown-item p-3" href="change_password.php"><i
                                    class="fas fa-shield-alt me-2"></i> Security</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item p-3 text-danger" href="../auth/logout.php"><i
                                    class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        Azamgarh</span>
        <a href="dashboard.php" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
        <a href="take_attendance.php"><i class="fas fa-user-check"></i> Take Attendance</a>
        <a href="view_attendance.php"><i class="fas fa-clipboard-list"></i> View Attendance</a>
        <a href="monthly_report.php"><i class="fas fa-chart-bar"></i> Monthly Report</a>
        <a href="view_holidays.php"><i class="fas fa-calendar-alt"></i> View Holidays</a>
        <a href="upload_syllabus.php"><i class="fas fa-book"></i> Add Syllabus</a>
        <a href="teacher_leave_panel.php"><i class="fas fa-envelope-open-text"></i> Leave Requests</a>
        <a href="teacher_grievance.php"><i class="fas fa-envelope-open-text"></i> Grievance</a>
        <a href="view_enquiries.php"><i class="fas fa-comment-dots"></i> Enquiries</a>
        <hr class="mx-3" style="color: #444;">
        <a href="change_password.php"><i class="fas fa-cog"></i> Settings</a>
    </div>

    <div class="main-content">
        <div class="container-fluid">

            <div class="row mb-4 animate__animated animate__fadeIn">
                <div class="col-12">
                    <h3 class="fw-bold">Welcome Back, <?php echo $teacher_name; ?>! 👋</h3>
                    <p class="text-muted">Here is what's happening with your classes today.</p>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-12">
                    <div class="info-card shadow-sm p-4 border-start border-primary border-5 ">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="text-primary fw-bold mb-3">Currently Assigned Class</h5>
                                <div class="d-flex flex-wrap gap-4">
                                    <span><i class="fas fa-university me-2 text-muted"></i><strong>Branch:</strong>
                                        <?php echo $branch; ?></span>
                                    <span><i class="fas fa-layer-group me-2 text-muted"></i><strong>Semester:</strong>
                                        <?php echo $semester; ?></span>
                                    <span><i class="fas fa-calendar me-2 text-muted"></i><strong>Academic Year:</strong>
                                        <?php echo $year; ?></span>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">Update Schedule</button>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 animate__animated animate__fadeInUp">
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card" style="background: linear-gradient(45deg, #4e73df, #224abe);">
                        <i class="fas fa-user-check mb-3 fa-2x"></i>
                        <h5>Attendance</h5>
                        <!-- <p class="small opacity-75">Mark today's student presence</p> -->
                        <a href="take_attendance.php" class="btn btn-action w-100 mt-2">Open Panel</a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="stat-card" style="background: linear-gradient(45deg, #1cc88a, #13855c);">
                        <i class="fas fa-file-invoice mb-3 fa-2x"></i>
                        <h5>Reports</h5>
                        <!-- <p class="small opacity-75">Generate monthly insights</p> -->
                        <a href="monthly_report.php" class="btn btn-action w-100 mt-2">View Report</a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="stat-card" style="background: linear-gradient(45deg, #f6c23e, #dda20a);">
                        <i class="fas fa-id-card mb-3 fa-2x"></i>
                        <h5>ID Requests</h5>
                        <!-- <p class="small opacity-75">Pending student ID cards</p> -->
                        <a href="id_card_requests.php" class="btn btn-action w-100 mt-2">Manage</a>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="stat-card" style="background: linear-gradient(45deg, #e74a3b, #be2617);">
                        <i class="fas fa-id-badge mb-3 fa-2x"></i>
                        <h5>Card Database</h5>
                        <!-- <p class="small opacity-75">View all generated cards</p> -->
                        <a href="all_id_cards.php" class="btn btn-action w-100 mt-2">Database</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Mobile Toggle Script
    const menuBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');

    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    }
    </script>
</body>

</html>