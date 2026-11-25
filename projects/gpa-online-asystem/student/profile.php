<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
// Fetch student data
$query = "SELECT * FROM students WHERE id='$student_id'";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
    
// Variables to hold notification messages
$msg = "";
$msg_type = "";

// Handle form submission
if(isset($_POST['update_profile'])){
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    // Profile image upload
    $profile_image = $student['profile_image'];
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != ''){
        $target_dir = "../assets/images/students/";
        if(!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $target_file = $target_dir . $student_id . "_" . basename($_FILES["profile_image"]["name"]);
        if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)){
            $profile_image = $target_file;
        }
    }

    // Update DB
    $update = "UPDATE students SET full_name='$name', email='$email', mobile='$mobile', profile_image='$profile_image' WHERE id='$student_id'";
    
    if(mysqli_query($conn, $update)){
        // Success Message Set Karein (Script Alert hata diya)
        $msg = "Profile Updated Successfully!";
        $msg_type = "success"; // Green color ke liye
        
        // Update session variables immediately so visuals update
        $_SESSION['student_name'] = $name;
        $_SESSION['profile_image'] = $profile_image;
        
        // Refetch data to show updated values in form immediately
        $student['full_name'] = $name;
        $student['email'] = $email;
        $student['mobile'] = $mobile;
        $student['profile_image'] = $profile_image;
        
    } else {
        // Error Message
        $msg = "Error updating profile. Please try again.";
        $msg_type = "danger"; // Red color ke liye
    }
}


// Profile Image
$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
    }



    /* adddd end   */

    .profile-card {
        /* background: linear-gradient(135deg, #ff758c, #ff7eb3); */
        background: #212529;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        color: white;
    }

    .profile-card img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid #fff;
        margin-bottom: 15px;
        background-color: #fff;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        transition: 0.4s;
    }

    /* Input field styling adjustments for transparency */
    .form-control {
        background: rgba(255, 255, 255, 0.9);
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
        <a href="profile.php" class="active"><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>



    <div class="main-content">
        <div class="container py-5 mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 animate__animated animate__fadeIn">

                    <?php if($msg != ""): ?>
                    <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show shadow-sm"
                        role="alert">
                        <strong><?php echo ($msg_type == 'success') ? 'Success!' : 'Error!'; ?></strong>
                        <?php echo $msg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <div class="profile-card text-center card-hover">
                        <form method="POST" enctype="multipart/form-data">

                            <img src="<?php echo !empty($student['profile_image']) ? $student['profile_image'] : '../assets/images/default_user.png'; ?>"
                                alt="Profile Image">

                            <div class="mb-3">
                                <input type="file" name="profile_image" class="form-control form-control-sm">
                            </div>
                            <div class="mb-3 text-start">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control"
                                    value="<?php echo $student['full_name']; ?>" required>
                            </div>
                            <div class="mb-3 text-start">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?php echo $student['email']; ?>" required>
                            </div>
                            <div class="mb-3 text-start">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control"
                                    value="<?php echo $student['mobile']; ?>" required>
                            </div>
                            <button type="submit" name="update_profile"
                                class="btn btn-light w-100 fw-bold text-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script src="assets/js/script.js"></script>

</body>

</html>