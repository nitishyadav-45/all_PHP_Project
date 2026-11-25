<?php
session_start();
include("../config/database.php");

// Login check
if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];


$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";


// Fetch leaves
$query = mysqli_query($conn,"
SELECT * FROM leave_applications 
WHERE student_id='$student_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Leave Applications</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    body {
        /* background: #0f172a; */
        color: white;
    }

    .card {
        background: #1e293b;
        border-radius: 15px;
    }

    .status-approved {
        color: #22c55e;
    }

    .status-rejected {
        color: #ef4444;
    }

    .status-pending {
        color: #facc15;
    }

    .status-in_review {
        color: #38bdf8;
    }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container-fluid">

            <button class="btn btn-dark d-md-none me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="../index.php">Student Dashboard</a>

            <span class="text-white welcome-text d-none d-lg-block"
                style="font-weight:bold; position: absolute; left: 50%; transform: translateX(-50%); font-size:20px;">
                <?php echo "Welcome $student_name"; ?>
            </span>

            <div class="ms-auto d-flex align-items-center">




                <span class="me-3 text-white d-none d-sm-inline">
                    <?php echo " $student_name"; ?>
                </span>

                <div class="dropdown">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $profile_img; ?>" alt="image" width="40" height="40"
                            class="rounded-circle border border-2 border-secondary">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small  shadow"
                        aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="change_password.php">
                                <i class="fas fa-lock me-2"></i> Forgot Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger " href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="sidebar animate__animated animate__fadeInLeft ">

        <a href="dashboard.php" ><i class="bi bi-speedometer2 me-2"></i></i>Dashboard</a>
        <a href="view_attendance.php" ><i class="fas fa-calendar-check me-2"></i>Attendance</a>
        <!-- <a href="#"><i class="fas fa-file-alt me-2"></i>Reports</a> -->
        <a href="view_holidays.php" ><i class=" fa-solid fa-bell me-2"></i>Holiday</a>
        <a href="profile.php" ><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php" class="active"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="main-content my-5 py-5">

        <h3 class="text-center mb-4">
            <i class="fas fa-user-graduate"></i> My Leave Applications
        </h3>

        <div class="card p-3 shadow">

            <div class="table-responsive">
                <table class="table table-dark table-hover">

                    <tr>
                        <th>SR.No</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <?php while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo ucfirst($row['leave_type']); ?></td>
                        <td><?php echo $row['leave_date']; ?></td>

                        <td>
                            <span class="status-<?php echo $row['status']; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewModal<?php echo $row['id']; ?>">
                                View
                            </button>
                        </td>
                    </tr>

                    <!-- MODAL -->
                    <div class="modal fade" id="viewModal<?php echo $row['id']; ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content bg-dark text-light">

                                <div class="modal-header">
                                    <h5 class="modal-title">My Application</h5>
                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <!-- Application Format -->
                                    <div class="p-3" style="background:#020617;border-radius:10px;">

                                        <p><strong>Subject:</strong> Leave Application</p>

                                        <p>Respected Sir/Madam,</p>

                                        <p>
                                            I applied for <b><?php echo $row['leave_type']; ?></b> leave on
                                            <b><?php echo $row['leave_date']; ?></b>.
                                        </p>

                                        <p>
                                            <?php echo $row['reason']; ?>
                                        </p>

                                        <p>Thank You</p>

                                    </div>

                                    <hr>

                                    <!-- Status Timeline -->
                                    <p><b>Status:</b>
                                        <span class="status-<?php echo $row['status']; ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </p>

                                    <hr>

                                    <p><b>Teacher Remark:</b><br>
                                        <?php echo $row['teacher_remark'] ? $row['teacher_remark'] : "Not yet updated"; ?>
                                    </p>

                                    <p><b>Principal Remark:</b><br>
                                        <?php echo $row['principal_remark'] ? $row['principal_remark'] : "Not yet updated"; ?>
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </table>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>