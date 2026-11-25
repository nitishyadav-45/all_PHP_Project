<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


$teachers = mysqli_query($conn,"SELECT * FROM teachers");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Performance Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    body {
        background-color: var(--bg-dark);

        font-family: 'Poppins', sans-serif;
        min-height: 100vh;

    }

    .main-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        background: #fff;
    }

    .card-header-custom {
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        background: #1e293b;
        color: white;
        padding: 20px;
        text-align: center;
    }

    .table thead {
        background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f4ff;
        transition: 0.3s;
    }

    .badge-count {
        background-color: #e0e7ff;
        color: #4338ca;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
    }

    .btn-back {
        border-radius: 10px;
        padding: 8px 20px;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-back:hover {
        transform: translateX(-5px);
    }

    /* Responsive Table for Mobile */
    /* @media (max-width: 768px) {
            .table-responsive-custom {
                border: 0;
            }
            .table-responsive-custom thead {
                display: none;
            }
            .table-responsive-custom tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background: #fff;
                padding: 10px;
            }
            .table-responsive-custom td {
                display: block;
                text-align: right;
                font-size: 14px;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }
            .table-responsive-custom td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                width: 45%;
                font-weight: bold;
                text-align: left;
            }
        } */
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
        <hr class="border-info border-2">
        <a class="dropdown-item text-danger" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>
            Logout</a>

    </div>

    <div class="main-content py-5">


        <div class="card main-card shadow-lg">
            <div class="card-header-custom">
                <h4 class="m-0"><i class="fa-solid fa-chart-line me-2"></i> Teacher Performance Report</h4>
                <small class="opacity-75">Overview of total attendance records by faculty</small>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-responsive-custom m-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Teacher Name</th>
                                <th>Branch</th>
                                <th>Year</th>
                                <th>Semester</th>
                                <th class="text-center">Total Activity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($t = mysqli_fetch_assoc($teachers)){
                        // Database Optimization: It's better to use JOIN in the main query, 
                        // but keeping your logic for now with minor cleanup.
                        $count_q = mysqli_query($conn,"
                            SELECT COUNT(*) as total FROM attendance a
                            JOIN students s ON a.student_id=s.id
                            WHERE s.branch='{$t['branch']}'
                            AND s.year='{$t['year']}'
                            AND s.semester='{$t['semester']}'
                        ");
                        $total = mysqli_fetch_assoc($count_q)['total'];
                    ?>
                            <tr>
                                <td class="ps-4" data-label="Teacher">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3 bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 35px; height: 35px;">
                                            <?php echo strtoupper(substr($t['full_name'], 0, 1)); ?>
                                        </div>
                                        <span class="fw-semibold"><?php echo $t['full_name']; ?></span>
                                    </div>
                                </td>
                                <td data-label="Branch"><span class="text-muted"><?php echo $t['branch']; ?></span></td>
                                <td data-label="Year"><span
                                        class="badge bg-light text-dark border"><?php echo $t['year']; ?> Year</span>
                                </td>
                                <td data-label="Semester"><span class="text-muted">Sem
                                        <?php echo $t['semester']; ?></span></td>
                                <td class="text-center" data-label="Attendance">
                                    <span class="badge-count">
                                        <i class="fa-solid fa-clipboard-user me-1"></i> <?php echo $total; ?> Records
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- <div class="text-center mt-4 text-muted small">
        © <?php echo date('Y'); ?> College Attendance Management System
    </div> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>