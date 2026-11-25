<?php
session_start();
include("../config/database.php");

$message = "";
$msg_type = ""; // success, danger, warning, info

if(isset($_POST['login'])){

    $user_input = $_POST['user_input'];
    $password   = $_POST['password'];

    // 🔹 Check in Students
    $student_sql = "SELECT * FROM students WHERE email='$user_input' OR mobile='$user_input'";
    $student_res = mysqli_query($conn, $student_sql);

    if(mysqli_num_rows($student_res) == 1){
        $student = mysqli_fetch_assoc($student_res);

        if(password_verify($password, $student['password'])){
            $_SESSION['user_role'] = "student";
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['full_name'];
            $_SESSION['branch'] = $student['branch'];
            $_SESSION['semester'] = $student['semester'];
            $_SESSION['year'] = $student['year'];
            $_SESSION['profile_image'] = $student['profile_image'];
            

            $teacher_id = $_SESSION['teacher_id'];

            header("Location: ../student/dashboard.php");
            exit();
        } else {
            $message = "❌ Wrong password!";
            $msg_type = "danger";
        }
    }

    // 🔹 Check in Teachers
    if(empty($message)) {
        $teacher_sql = "SELECT * FROM teachers WHERE email='$user_input' OR mobile='$user_input'";
        $teacher_res = mysqli_query($conn, $teacher_sql);

        if(mysqli_num_rows($teacher_res) == 1){
            $teacher = mysqli_fetch_assoc($teacher_res);

            if(password_verify($password, $teacher['password'])){
                $_SESSION['user_role'] = "teacher";
                $_SESSION['teacher_id'] = $teacher['id'];
                $_SESSION['teacher_name'] = $teacher['full_name'];
                $_SESSION['branch'] = $teacher['branch'];
                $_SESSION['semester'] = $teacher['semester'];
                $_SESSION['year'] = $teacher['year'];

                $_SESSION['teacher_image'] = $teacher['profile_image'];


                if(empty($teacher['branch']) || empty($teacher['semester']) || empty($teacher['year'])){
                    header("Location: ../teacher/complete_profile.php");
                    exit();
                } else {
                    header("Location: ../teacher/dashboard.php");
                    exit();
                }
            } else {
                $message = "❌ Wrong password!";
                $msg_type = "danger";
            }
        }
    }

    // 🔹 If no user found at all
    if(empty($message) && mysqli_num_rows($student_res) == 0 && (!isset($teacher_res) || mysqli_num_rows($teacher_res) == 0)){
        $message = "⚠️ No account found with this Email or Mobile!";
        $msg_type = "warning";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Attendance System | GP Atraulia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- <link rel="stylesheet" href="../assets/css/about.css"> -->

    <style>
    body {
        margin: 0;
        min-height: 100vh;
        font-family: 'Segoe UI', sans-serif;
        color: #fff;
        /*background:
                linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
                url('https://images.unsplash.com/photo-1519389950473-47ba0277781c') center/cover no-repeat fixed;*/
    }

    .login-wrapper {
        background:
            linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.85)),
            url('https://images.unsplash.com/photo-1519389950473-47ba0277781c') center/cover no-repeat;
    }

    /* Glass Card */
    .login-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.7);
    }

    /* Left Image Panel with Dark Overlay */
    .left-panel {
        position: relative;
        background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f') center/cover no-repeat;
        min-height: 500px;
    }

    .left-panel::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        /* Darkness level */
    }

    /* Inputs */
    .form-control {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #fff;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        box-shadow: none;
        border-color: #ff4d6d;
    }

    .input-group {
        margin-bottom: 8px;
    }

    .input-group-text {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid #444;
        border-left: none;
        color: #888;
        padding: 4px 10px;
    }

    /* Button */
    .btn-custom {
        background: linear-gradient(90deg, #ff4d6d, #ff1e56);
        border: none;
        font-weight: 600;
    }

    .btn-custom:hover {
        opacity: 0.9;
    }

    .small-text a {
        color: #ff4d6d;
        text-decoration: none;
    }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-university fa-lg"></i>
                GPA <span>AZAMGARH</span>
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link " href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="../about.php">About </a></li>
                    <li class="nav-item"><a class="nav-link" href="../features.php">Features</a></li>

                    <li class="dropdown nav-item">
                        <a href="#" class="dropbtn active text-light">Register ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link " href="register_student.php">Student Register</a>
                            <a class="nav-link" href="register_teacher.php">Teacher Register</a>

                        </div>
                    </li>

                    <li class="dropdown nav-item ms-3">
                        <a href="#" class="dropbtn active text-light">Login Portal ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link active" href="login.php">Student / Teacher Login</a>
                            <a class="nav-link" href="adminlogin.php">Admin Login</a>

                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="login-wrapper py-5 mt-5">
        <div class="container">
            <div class="row login-card">

                <!-- Left Image -->
                <div class="col-md-6 d-none d-md-block left-panel"></div>

                <!-- Right Form -->
                <div class="col-md-6 p-5">
                    <h2 class="fw-bold">Welcome Back </h2>
                    <p class="text-secondary mb-4">Login to continue your journey</p>

                    <?php if(!empty($message)): ?>
                    <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php endif; ?>

                    

                    <form method="POST">

                        <div class="mb-3">
                            <label>Email or Mobile</label>
                            <input type="text" name="user_input" class="form-control"
                                placeholder="Enter email or mobile" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="pass" class="form-control"
                                    placeholder="Enter password" required>
                                <span class="input-group-text"><i class="fa fa-eye"
                                        onclick="togglePass('pass')"></i></span>

                            </div>
                        </div>

                        <button type="submit" name="login" class="btn btn-custom w-100 py-2 mt-2">Login</button>

                        <div class="text-center mt-3">Don’t have an account?
                            <a href="register_student.php">Student Register</a> /
                            <a href="register_teacher.php">Teacher Register</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <footer id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-logo">GP ATRAULIA</div>
                    <p>Government Polytechnic Atraulia, Azamgarh is committed to providing technical education with
                        modern standards. This attendance system is a step towards a digital campus.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#login">Login</a></li>
                        <li><a href="#">Syllabus</a></li>
                        <li><a href="#">Results</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-white mb-3">Contact Us</h5>
                    <ul class="list-unstyled footer-links">
                        <li><i class="fas fa-map-marker-alt me-2 text-warning"></i> Atraulia, Azamgarh, Uttar Pradesh,
                            India - 223223</li>
                        <li><i class="fas fa-phone me-2 text-warning"></i> +91 98765 43210</li>
                        <li><i class="fas fa-envelope me-2 text-warning"></i> info@gpatraulia.ac.in</li>
                        <li><i class="fas fa-clock me-2 text-warning"></i> Mon - Sat: 9:00 AM - 5:00 PM</li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5 class="text-white mb-3">Location</h5>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13020.372086681919!2d82.92961681194811!3d26.385745584730078!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3991028865857cb7%3A0x7162682f394878b1!2sGovernment%20Polytechnic%20Atraulia%20Azamgarh!5e1!3m2!1sen!2sin!4v1771062840841!5m2!1sen!2sin"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
            <hr class="border-secondary mt-4">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2026 Government Polytechnic Atraulia. All Rights Reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed By: <a href="https://nitishportfolio-pro.netlify.app/"
                            target="_blank">Nitish Kumar Yadav</a> </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Navbar Scrolled Effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.style.padding = '10px 0';
            navbar.style.backgroundColor = 'rgba(18, 18, 18, 1)'; // Solid dark
        } else {
            navbar.style.padding = '15px 0';
            navbar.style.backgroundColor = 'rgba(18, 18, 18, 0.95)'; // Slight transparency
        }
    });

    // Initialize Tooltips (if any)
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    // show padssword icon
    function togglePass(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        input.type = input.type === "password" ? "text" : "password";
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
    </script>
</body>

</html>