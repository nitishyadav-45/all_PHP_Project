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


// Student Data Fetch
$student_query = mysqli_query($conn, "SELECT * FROM students WHERE id='$student_id'");
$student = mysqli_fetch_assoc($student_query);

$branch = $student['branch'];

// Same Branch Teachers fetch karein
$teachers = mysqli_query($conn, "SELECT * FROM teachers WHERE branch='$branch'");

$msg = "";

// Form Submit hone par
if(isset($_POST['submit'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $send_to = $_POST['send_to'];

    // Initial values (Donon ko default NULL rakhein)
    $teacher_id = "NULL";
    $admin_id = "NULL"; 

    if($send_to == 'teacher'){
        // Agar teacher ko bhej rahe hain
        $teacher_id = "'" . mysqli_real_escape_string($conn, $_POST['teacher_id']) . "'";
        $admin_id = "NULL"; // Admin ID explicitly empty
    } else if($send_to == 'admin'){
        // Agar admin ko bhej rahe hain
        $teacher_id = "NULL"; // Teacher ID explicitly empty
        $admin_id = "1"; // Yahan aap apni default Admin ID daal sakte hain agar database mein column hai
    }

    // Query mein dhyaan dein: teacher_id aur admin_id variables ke aaspas quotes query string mein handle kiye gaye hain
    $insert_query = "INSERT INTO grievances 
    (student_id, teacher_id, send_to, title, description, category)
    VALUES ('$student_id', $teacher_id, '$send_to', '$title', '$description', '$category')";

    if(mysqli_query($conn, $insert_query)){
        $msg = "Grievance Submitted Successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Submit Grievance</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .card {
        /* background:#1e293b; */
        border: none;
        border-radius: 15px;
    }

    .form-control,
    .form-select {
        /* background:#0f172a; */
        color: black;
        border: 1px solid #334155;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #6366f1;
        box-shadow: none;
    }

    .btn-submit {
        background: linear-gradient(45deg, #6366f1, #8b5cf6);
        border: none;
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
        <a href="my_leaves.php" ><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php" class="active"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="main-content mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card p-4 shadow">

                    <h3 class="text-center mb-4">Submit Grievance</h3>

                    <?php if($msg!=""){ ?>
                    <div class="alert alert-success"><?php echo $msg; ?></div>
                    <?php } ?>

                    <form method="POST">

                        <!-- Student Info (Auto) -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input type="text" class="form-control" value="<?php echo $student['full_name']; ?>"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="text" class="form-control" value="<?php echo $student['email']; ?>"
                                    readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label>Mobile</label>
                                <input type="text" class="form-control" value="<?php echo $student['mobile']; ?>"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Branch / Year</label>
                                <input type="text" class="form-control"
                                    value="<?php echo $student['branch'].' - '.$student['year']; ?>" readonly>
                            </div>
                        </div>

                        <!-- Send To -->
                        <div class="mb-3">
                            <label>Send To</label>
                            <select name="send_to" class="form-select" required onchange="toggleTeacher(this.value)">
                                <option value="">Select Option</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <!-- Teacher Dropdown -->
                        <div class="mb-3" id="teacherBox" style="display:none;">
                            <label>Select Teacher</label>
                            <select name="teacher_id" class="form-select">
                                <option value="">Select Teacher</option>
                                <?php while($t = mysqli_fetch_assoc($teachers)){ ?>
                                <option value="<?php echo $t['id']; ?>">
                                    <?php echo $t['full_name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label>Category</label>
                            <select name="category" class="form-select">
                                <option>Attendance Issue</option>
                                <option>Exam Issue</option>
                                <option>Fee Issue</option>
                                <option>ID Card Issue</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button name="submit" class="btn btn-submit text-white">Submit Grievance</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/script.js"></script>

    <script>
    function toggleTeacher(value) {
        let box = document.getElementById('teacherBox');
        if (value === 'teacher') {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    }
    </script>

</body>

</html>