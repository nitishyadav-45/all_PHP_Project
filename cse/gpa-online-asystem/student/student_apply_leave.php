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


// Student data fetch
$student = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM students WHERE id='$student_id'"));

// Branch wise teachers
$teachers = mysqli_query($conn,
"SELECT * FROM teachers WHERE branch='".$student['branch']."'");

// Submit logic
$msg = "";

if(isset($_POST['apply'])){

    $teacher_id = $_POST['teacher_id'];
    $leave_type = $_POST['leave_type'];
    $leave_date = $_POST['leave_date'];
    $reason     = mysqli_real_escape_string($conn, $_POST['reason']);

    // Half Leave Time Validation
    date_default_timezone_set("Asia/Kolkata");
    $current_time = date("H:i");

    if($leave_type == "half"){
        if($current_time < "12:00" || $current_time > "14:00"){
            $msg = "❌ Half Leave only allowed between 12 PM to 2 PM";
        }
    }

    if($msg == ""){
        mysqli_query($conn,"INSERT INTO leave_applications
        (student_id, teacher_id, leave_type, leave_date, reason)
        VALUES('$student_id','$teacher_id','$leave_type','$leave_date','$reason')");

        $msg = "✅ Leave Applied Successfully!";
    }
}

$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply Leave</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">


    <style>
    body {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 20px;
        /* background: #1e293b; */
        border: 1px solid #334155;
    }

    .form-control,
    .form-select {
        /* background: #0f172a; */
        border: 1px solid #334155;
        color: black;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
    }

    .btn-submit {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        padding: 12px;
        font-weight: bold;
    }

    .auto-field {
        /* background: #020617; */
        color: black !important;
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
        <a href="student_apply_leave.php" class="active"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="main-content my-5 py-5">

        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card p-4 shadow-lg">

                    <h3 class="text-center mb-4">
                        <i class="fas fa-file-alt me-2"></i> Apply Leave
                    </h3>

                    <?php if($msg != ""){ ?>
                    <div class="alert alert-info text-center"><?php echo $msg; ?></div>
                    <?php } ?>

                    <form method="POST">

                        <!-- Auto Fields -->
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-user"></i> Name</label>
                                <input type="text" class="form-control auto-field"
                                    value="<?php echo $student['full_name']; ?>" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><i class="fas fa-code-branch"></i> Branch</label>
                                <input type="text" class="form-control auto-field"
                                    value="<?php echo $student['branch']; ?>" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><i class="fas fa-layer-group"></i> Semester</label>
                                <input type="text" class="form-control auto-field"
                                    value="<?php echo $student['semester']; ?>" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><i class="fas fa-calendar"></i> Year</label>
                                <input type="text" class="form-control auto-field"
                                    value="<?php echo $student['year']; ?>" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label><i class="fas fa-phone"></i> Mobile</label>
                                <input type="text" class="form-control auto-field"
                                    value="<?php echo $student['mobile']; ?>" readonly>
                            </div>

                        </div>

                        <hr>

                        <!-- Leave Type -->
                        <div class="mb-3">
                            <label><i class="fas fa-list"></i> Leave Type</label>
                            <select name="leave_type" class="form-select" required>
                                <option value="">Select Leave Type</option>
                                <option value="half">Half Day Leave</option>
                                <option value="full">Full Day Leave</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label><i class="fas fa-calendar-day"></i> Leave Date</label>
                            <input type="date" name="leave_date" class="form-control" required>
                        </div>

                        <!-- Teacher -->
                        <div class="mb-3">
                            <label><i class="fas fa-chalkboard-teacher"></i> Select Teacher (HOD)</label>
                            <select name="teacher_id" class="form-select" required>

                                <option value="">Select Teacher</option>

                                <?php while($t = mysqli_fetch_assoc($teachers)){ ?>

                                <option value="<?php echo $t['id']; ?>">
                                    <?php echo $t['full_name']; ?>
                                </option>

                                <?php } ?>

                            </select>
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label><i class="fas fa-comment"></i> Reason</label>
                            <textarea name="reason" rows="4" class="form-control"
                                placeholder="Write your leave application..." required></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button name="apply" class="btn btn-submit text-white">
                                <i class="fas fa-paper-plane me-2"></i> Submit Application
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script stc="assets/js/script.js"></script>

</body>

</html>