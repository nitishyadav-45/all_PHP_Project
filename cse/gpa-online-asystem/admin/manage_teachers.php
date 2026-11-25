<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


$teachers = mysqli_query($conn,"SELECT * FROM teachers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Teachers | Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    body {
        /* background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); */
        background-color: var(--bg-dark);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
    }

    .main-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }

    .header-section {
        background: #4e73df;
        background: linear-gradient(45deg, #4e73df, #224abe);
        color: white;
        padding: 20px;
        border-radius: 20px 20px 0 0;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead {
        background-color: #f8f9fc;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .teacher-row:hover {
        background-color: rgba(78, 115, 223, 0.05);
        transition: 0.3s;
    }

    .badge-branch {
        background: #e74a3b;
        color: white;
        font-weight: 500;
    }

    .btn-edit {
        background-color: #f6c23e;
        color: white;
        border-radius: 8px;
    }

    .btn-delete {
        background-color: #e74a3b;
        color: white;
        border-radius: 8px;
    }

    .btn-back {
        border-radius: 50px;
        padding: 8px 25px;
        font-weight: 600;
        transition: 0.3s;
    }

    /* Responsive Improvements */
    /* @media (max-width: 768px) {
        .container {
            margin-top: 10px;
        }

        .header-section h4 {
            font-size: 1.2rem;
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

        <!-- <div class="mb-4">
            <a href="dashboard.php" class="btn btn-light btn-back shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Dashboard
            </a>
        </div> -->

        <div class="card main-card shadow-lg">
            <div class="header-section d-flex justify-content-between align-items-center">
                <h4 class="m-0"><i class="fas fa-chalkboard-teacher me-2"></i> Teacher Directory</h4>
                <span class="badge bg-light text-primary"><?php echo mysqli_num_rows($teachers); ?> Total</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="text-secondary">
                            <tr>
                                <!-- <th class="ps-4">ID</th> -->
                                <th class="ps-4">Teacher Name</th>
                                <th>Mobile Number</th>
                                <th>Branch Details</th>
                                <th>Schedule</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($t = mysqli_fetch_assoc($teachers)){ ?>
                            <tr class="teacher-row">
                                <!-- <td class="ps-4 fw-bold text-muted">#<?php echo $t['id']; ?></td> -->
                                <td>
                                    <div class="ps-4 d-flex align-items-center ">
                                        <div class="avatar-sm me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <?php echo strtoupper(substr($t['full_name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?php echo $t['full_name']; ?></div>
                                            <small class="text-muted"><i
                                                    class="far fa-envelope me-1"></i><?php echo $t['email']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span><?php echo $t['mobile']; ?> </span>
                                </td>
                                <td>
                                    <span class="badge badge-branch rounded-pill"><?php echo $t['branch']; ?></span>
                                </td>
                                
                                <td>
                                    <div class="small"><strong>Year:</strong> <?php echo $t['year']; ?></div>
                                    <div class="small text-muted"><strong>Sem:</strong> <?php echo $t['semester']; ?>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_teacher.php?id=<?php echo $t['id']; ?>"
                                            class="btn btn-edit btn-sm me-2 shadow-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_teacher.php?id=<?php echo $t['id']; ?>"
                                            class="btn btn-delete btn-sm shadow-sm"
                                            onclick="return confirm('Delete this record?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <p class="text-center text-muted mt-4 small">
            &copy; <?php echo date("Y"); ?> Admin Management System | Faculty Module
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>