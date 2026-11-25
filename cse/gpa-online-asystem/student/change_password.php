<?php
session_start();
include("../config/database.php");

$msg = "";

$student_name = $_SESSION['student_name'];


if(isset($_POST['change_pass'])){
    $email = $_POST['email'];
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $res = mysqli_query($conn,"SELECT * FROM students WHERE email='$email'");
    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);

        if(password_verify($old, $row['password'])){
            if($new === $confirm){
                $newHash = password_hash($new, PASSWORD_DEFAULT);
                mysqli_query($conn,"UPDATE students SET password='$newHash' WHERE email='$email'");
                $msg = "<div class='alert alert-success'>Password updated successfully</div>";
                echo "<script> setTimeout(function(){window.location.href = '../auth/login.php';}, 2000); </script>";

            } 

             else {
                $msg = "<div class='alert alert-danger'>New passwords do not match</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Old password incorrect</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email not found</div>";
    }
}


// Profile Image
$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";

?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Change Password</title>
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
        /* background: linear-gradient(135deg, #4e73df, #1cc88a); */
        font-family: 'Poppins', sans-serif;
    }


    .card {
        border-radius: 15px;
        background: #212529;
        
    }

    /* Form Controls Styling */
    label {
        font-size: 1rem;
        font-weight: 500;
        color: #ffff;
        margin-bottom: 0.4rem;
    }

    .toggle-eye {
        cursor: pointer;
        position: absolute;
        right: 15px;
        top: 38px;
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
        <a href="student_apply_leave.php" ><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="container mt-5">
        <div class="row  justify-content-center ">
            <div class="col-md-5">
                <div class="card  mt-5 p-4 shadow">
                    <h4 class="text-center text-light mb-3">🎓 Student Change Password</h4>
                    <?php echo $msg; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Old Password</label>
                            <input type="password" name="old_password" id="oldPass" class="form-control" required>
                            <span class="toggle-eye" onclick="togglePass('oldPass',this)">👁</span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>New Password</label>
                            <input type="password" name="new_password" id="newPass" class="form-control" required>
                            <span class="toggle-eye" onclick="togglePass('newPass',this)">👁</span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirmPass" class="form-control"
                                required>
                            <span class="toggle-eye" onclick="togglePass('confirmPass',this)">👁</span>
                        </div>

                        <button type="submit" name="change_pass" class="btn btn-primary w-100">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="assets/js/script.js"></script>
    <script>
    function togglePass(id, el) {
        let input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
    </script>

    <script>
    // Toggle button par click karne par sidebar me 'active' class add/remove karega
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Agar mobile par sidebar open hai aur user bahar click karta hai, to band ho jaye
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    </script>
</body>

</html>