<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

// profile images
$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";


// Student Data
$student = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE id='$student_id'"));

// Fetch grievances
$query = mysqli_query($conn,"
SELECT * FROM grievances 
WHERE student_id='$student_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Grievances</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    body {
        background: #0f172a;
        color: white;
    }

    /* Card */
    .card {
        border-radius: 15px;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Buttons */
    .btn-small {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Status */
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .pending {
        background: #f59e0b;
    }

    .in_progress {
        background: #3b82f6;
    }

    .resolved {
        background: #22c55e;
    }

    /* Modal */
    .modal-content {
        border-radius: 15px;
    }

    /* Application */
    .application-box {
        background: white;
        color: black;
        padding: 20px;
        border-radius: 10px;
        line-height: 1.8;
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

        <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i></i>Dashboard</a>
        <a href="view_attendance.php"><i class="fas fa-calendar-check me-2"></i>Attendance</a>
        <!-- <a href="#"><i class="fas fa-file-alt me-2"></i>Reports</a> -->
        <a href="view_holidays.php"><i class=" fa-solid fa-bell me-2"></i>Holiday</a>
        <a href="profile.php"><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php "><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php " class="active"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="main-content mt-5 px-4">

        <h3 class="text-center mb-4">My Grievances</h3>

        <?php while($row = mysqli_fetch_assoc($query)){ ?>

        <div class="card p-4 mb-4 shadow">

            <!-- Top -->
            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <strong><?php echo $row['title']; ?></strong><br>
                    <small><?php echo date("d M Y",strtotime($row['created_at'])); ?></small>
                </div>

                <div class="d-flex align-items-center gap-2">

                    <span class="status-badge <?php echo $row['status']; ?>">
                        <?php echo ucfirst(str_replace("_"," ",$row['status'])); ?>
                    </span>

                    <button class="btn btn-primary btn-small" data-bs-toggle="modal"
                        data-bs-target="#modal<?php echo $row['id']; ?>">
                        <i class="bi bi-eye"></i>
                    </button>

                </div>

            </div>

            <p class="mt-2 mb-0">
                <strong>Category:</strong> <?php echo $row['category']; ?>
            </p>

        </div>

        <!-- MODAL -->
        <div class="modal fade" id="modal<?php echo $row['id']; ?>">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Grievance Application</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- APPLICATION FORMAT -->
                        <div class="application-box">

                            <p><strong>To,</strong><br>
                                <?php echo ($row['send_to']=="admin") ? "The Admin" : "The Teacher"; ?>
                            </p>

                            <p><strong>Subject:</strong> <?php echo $row['title']; ?></p>

                            <p><strong>Respected Sir/Madam,</strong></p>

                            <p style="text-align:justify;">
                                I am <b><?php echo $student['full_name']; ?></b>, a student of
                                <b><?php echo $student['branch']; ?> (<?php echo $student['year']; ?>)</b>.
                                I would like to bring to your kind attention that
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?> <br>
                                I kindly request you to take necessary action at the earliest.
                            </p>

                            <p style="text-align:justify;">
                                I shall be highly thankful for your support and consideration.
                            </p>

                            <br>

                            <p>Thanking You</p>

                            <p>
                                Yours sincerely,<br>
                                <b><?php echo $student['full_name']; ?></b><br>
                                Email: <?php echo $student['email']; ?><br>
                                Mobile: <?php echo $student['mobile']; ?>
                            </p>

                            <hr>

                            <p><b>Status:</b> <?php echo ucfirst(str_replace("_"," ",$row['status'])); ?></p>

                            <?php if($row['teacher_reply'] != ""){ ?>
                            <p><b>Teacher Reply:</b><br>
                                <?php echo nl2br($row['teacher_reply']); ?>
                            </p>
                            <?php } ?>

                            <?php if($row['admin_reply'] != ""){ ?>
                            <p><b>Admin Reply:</b><br>
                                <?php echo nl2br($row['admin_reply']); ?>
                            </p>
                            <?php } ?>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>