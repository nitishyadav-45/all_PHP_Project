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

// 1. Total Student ID Card Requests (Saari requests count karega)
// $id_request_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM id_card_requests");
// $total_id_requests = mysqli_fetch_assoc($id_request_q)['total'];

// 1. Student ID Card Requests (Sirf wo jo abhi Approved NAI hui hain)
$id_request_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM id_card_requests WHERE status != 'Approved' OR status IS NULL");
$total_id_requests = mysqli_fetch_assoc($id_request_q)['total'];

// 2. Manage Student ID Cards (Jo 'Approved' ho chuke hain)
$managed_id_q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM id_card_requests WHERE status='Approved'");
$total_managed_id = mysqli_fetch_assoc($managed_id_q)['total'];

// 3. Pending Student ID Cards (Jo abhi 'Pending' hain)
// 3. Pending Student ID Cards (Total minus Approved)
$total_pending_id = $student_count - $total_managed_id;

?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    body {
        background: linear-gradient(135deg, #1d2671, #c33764);
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 240px;
        background: #111;
        padding-top: 70px;
        transition: 0.3s;
    }

    .sidebar a {
        display: block;
        color: #fff;
        padding: 15px 20px;
        text-decoration: none;
        transition: 0.3s;
    }

    .sidebar a:hover {
        background: #c33764;
        padding-left: 30px;
    }

    /* Main Content */
    .main-content {
        margin-left: 240px;
        padding: 20px;
        margin-top: 80px;
    }

    /* Navbar */
    .navbar {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }

    /* Cards */
    .card {
        border-radius: 20px;
        transition: 0.4s;
        color: white;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }

    .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }

    .welcome-text {
        font-weight: 600;
        color: white;
        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
    }

    /* Mobile Responsive */
    @media(max-width:768px) {
        .sidebar {
            left: -240px;
        }

        .sidebar.active {
            left: 0;
        }

        .main-content {
            margin-left: 0;
        }

        .welcome-text {
            display: none !important;
        }
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top px-3">
        <button class="btn btn-outline-light me-3" id="menu-toggle"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>


        <span class="text-white welcome-text d-none d-lg-block"
            style="font-weight:bold; position: absolute; left: 50%; transform: translateX(-50%); font-size:20px;">
            Welcome, <?php echo $admin['full_name']; ?>

        </span>

        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block"><?php echo $admin['email']; ?></span>
            <a href="profile.php">
                <img src="uploads/admin/<?php echo $admin['profile_image'] ?? 'default.png'; ?>" class="profile-img">
            </a>
            <a href="../auth/logout.php" class="btn btn-danger btn-sm ms-3">Logout</a>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a href="dashboard.php"><i class="fa fa-home me-2"></i> Dashboard</a>
        <a href="manage_students.php"><i class="fa fa-users me-2"></i> Students</a>
        <a href="manage_teachers.php"><i class="fa fa-chalkboard-teacher me-2"></i> Teachers</a>
        <a href="attendance_reports.php"><i class="fa fa-calendar-check me-2"></i> Attendance</a>
        <a href="attendance_reports.php"><i class="fa fa-file-pdf me-2"></i> Reports</a>
        <a href="profile.php"><i class="fa fa-file-image me-2"></i> Profile</a>
        <a href="change_password.php"><i class="fa-solid fa-unlock"></i> Change Password</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">

        <!-- <h2 class="text-center mb-5 welcome-text">
          Welcome, <?php echo $admin['full_name']; ?>
        </h2> -->

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6a00;">
                    <i class="fa fa-users fa-2x mb-3"></i>
                    <h3><?php echo $student_count; ?></h3>
                    <h5>Manage Students</h5>
                    <a href="manage_students.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card p-4 text-center" style="background:#00c9ff;">
                    <i class="fa fa-chalkboard-teacher fa-2x mb-3"></i>
                    <h3><?php echo $teacher_count; ?></h3>
                    <h5>Manage Teachers</h5>
                    <a href="manage_teachers.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card p-4 text-center" style="background:#F1C40F;">
                    <i class="fa-solid fa-envelope fa-2x mb-3"></i>
                    <h2><?php echo $total_enquiries; ?></h2>
                    <h5>Enquiries</h5>
                    <a href="View_enquiries.php" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b;">
                    <i class="fas fa-id-card fa-2x mb-3"></i>
                    <h3><?php echo $total_id_requests; ?></h3>
                    <h5>Student Id card</h5>
                    <a href="id_card_requests.php" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b8e;">
                    <i class="fas fa-id-card fa-2x mb-3"></i>
                    <h3><?php echo $total_managed_id; ?></h3>
                    <h5>Manage Student Id card</h5>
                    <a href="manage_id_cards.php" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card p-4 text-center" style="background:#ff9b6b;">
                    <i class="fas fa-id-card fa-2x mb-3"></i>
                    <h3><?php echo $total_pending_id; ?></h3>
                    <h5>pending Student Id card</h5>
                    <a href="id_card_not_generated.php" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>

        </div>
        <div class="row g-4 mt-5">

            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#1abc9c;">
                    <i class="fas fa-chart-line fa-2x mb-3"></i>
                    <h5>Teacher Performance</h5>
                    <a href="teacher_performance_report.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>

            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#28a745;">
                    <i class="fas fa-clipboard-list fa-2x mb-3"></i>
                    <h5>Attendance Report</h5>
                    <a href="attendance_reports.php" class="btn btn-light btn-sm mt-2">View</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#6f42c1;">
                    <i class="fas fa-calendar-plus fa-2x mb-3"></i>
                    <h5>Add Holiday</h5>
                    <a href="add_holiday.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">
                    <i class="fas fa-calendar-check fa-2x mb-3"></i>
                    <h5>Manage Holiday</h5>
                    <a href="manage_holidays.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Add Notice</h5>
                    <a href="add_notice.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>manage Notice</h5>
                    <a href="manage_notices.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Exam Schedule</h5>
                    <a href="exam_schedule.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Manage Exam Schedule</h5>
                    <a href="manage_exam_schedule.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Gallery</h5>
                    <a href="add_gallery.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Manage Gallery</h5>
                    <a href="manage_gallery.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Principal desk</h5>
                    <a href="principal_message.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card p-4 text-center" style="background:#ff6b6b;">

                    <i class="fa fa-bullhorn fa-2x mb-3"></i>
                    <h5>Manage Pricipal Desk</h5>
                    <a href="manage_principal_message.php" class="btn btn-light btn-sm mt-2">Open</a>
                </div>
            </div>


        </div>
    </div>

    <footer class="text-center  text-white mt-5 pb-3">
        © <?php echo date("Y"); ?> Online Attendance System | Admin Panel
    </footer>

    <script>
    document.getElementById("menu-toggle").addEventListener("click", function() {
        document.getElementById("sidebar").classList.toggle("active");
    });
    </script>

</body>

</html>