<?php
include("../config/database.php");

$message = "";
$msg_type = ""; // success, danger, warning

if(isset($_POST['register'])) {

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $mobile    = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    // Password match check
    if($password !== $confirm){
        $message = "⚠️ Passwords do not match!";
        $msg_type = "warning";
    } 
    else {

        // 🔍 Check duplicate email
        $check_email = mysqli_query($conn, "SELECT * FROM teachers WHERE email='$email'");
        
        // 🔍 Check duplicate mobile
        $check_mobile = mysqli_query($conn, "SELECT * FROM teachers WHERE mobile='$mobile'");

        if(mysqli_num_rows($check_email) > 0){
            $message = "❌ Email already exists!";
            $msg_type = "danger";
        }
        elseif(mysqli_num_rows($check_mobile) > 0){
            $message = "❌ Mobile number already exists!";
            $msg_type = "danger";
        }
        else {
            // ✅ Insert data
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO teachers (full_name, mobile, email, password)
                    VALUES ('$full_name', '$mobile', '$email', '$hashed_password')";

            if(mysqli_query($conn, $sql)){
                $message = "🎉 Registration Successful! You can login now.";
                $msg_type = "success";
            } else {
                $message = "❌ Something went wrong!";
                $msg_type = "danger";
            }
        }
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
    /* --- MAIN WRAPPER --- */
    .register-wrapper {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072') no-repeat center center/cover;
        padding-top: 40px;
        /* Space for Navbar */
        position: relative;
    }

    /* Dark overlay */
    .register-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.8);
        z-index: 0;
    }

    /* --- COMPACT GLASS CARD --- */
    .register-box {
        position: relative;
        z-index: 2;
        /* Above footer */
        background: rgba(30, 30, 30, 0.5);
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        width: 900px;
        max-width: 95%;
        height: auto;
        max-height: 80vh;
        /* Reduced slightly to make room for footer */
        display: flex;
        overflow: hidden;
    }

    /* Left Image Side */
    .register-img {
        background: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070') center center/cover;
        width: 50%;
        position: relative;
    }

    .register-img::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.3), rgba(30, 30, 30, 0.9));
    }

    /* Right Form Side */
    .form-side {
        width: 50%;
        padding: 25px 35px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    h3 {
        font-size: 1.5rem;
        color: white;
        margin-bottom: 5px;
    }

    .subtitle {
        font-size: 0.8rem;
        color: #888;
        margin-bottom: 15px;
        display: block;
    }

    /* --- COMPACT INPUT STYLES --- */
    .form-control,
    .form-select {
        background: rgba(0, 0, 0, 0.2);
        border: 1px solid #444;
        border-radius: 5px;
        color: white;
        padding: 8px 10px;
        font-size: 0.85rem;
        margin-bottom: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        background: rgba(0, 0, 0, 0.4);
        border-color: var(--secondary-color);
        box-shadow: none;
        color: white;
    }

    .form-select {
        color: #aaa;
    }

    option {
        background: #222;
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

    .btn-main {
        background: linear-gradient(90deg, var(--secondary-color), #ff4b5c);
        color: white;
        padding: 8px;
        border: none;
        border-radius: 5px;
        font-weight: 500;
        width: 100%;
        margin-top: 5px;
        transition: 0.3s;
    }

    .btn-main:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
    }

    .login-link {
        font-size: 0.8rem;
        margin-top: 10px;
        text-align: center;
    }

    /* --- ABSOLUTE FOOTER (NEW ADDITION) --- */
    .absolute-footer {
        position: absolute;
        bottom: 10px;
        width: 100%;
        text-align: center;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.75rem;
        z-index: 1;
    }

    .absolute-footer a {
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        margin: 0 5px;
        transition: 0.3s;
    }

    .absolute-footer a:hover {
        color: var(--secondary-color);
    }

    /* --- RESPONSIVE FIX --- */
    @media (max-width: 768px) {
        .register-img {
            display: none;
        }

        .form-side {
            width: 100%;
        }

        .register-box {
            height: auto;
            max-height: 85vh;
        }

        .absolute-footer {
            font-size: 0.65rem;
            bottom: 5px;
        }
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
                            <a class="nav-link active" href="#registerteacher">Teacher Register</a>

                        </div>
                    </li>

                    <li class="dropdown nav-item ms-3">
                        <a href="#" class="dropbtn active text-light">Login Portal ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link " href="login.php">Student / Teacher Login</a>
                            <a class="nav-link" href="adminlogin.php">Admin Login</a>

                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <section class="register-wrapper ">
        <div class="register-box my-5 ">

            <div class="register-img"></div>

            <div class="form-side">
                <h3 class="fw-bold">Teacher Registration</h3>
                <span class="subtitle">Join the digital campus today.</span>

                <?php if(!empty($message)): ?>
                <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>


                <form method="POST">
                    <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                    <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required>


                    <div class="input-group ">
                        <input type="password" name="password" id="pass" class="form-control" placeholder="Password"
                            style="margin-bottom:0" required>
                        <span class="input-group-text"><i class="fa fa-eye" onclick="togglePass('pass')"></i></span>
                    </div>

                    <div class="input-group">
                        <input type="password" name="confirm_password" id="cpass" class="form-control"
                            placeholder="Confirm Password" required style="margin-bottom:0">
                        <span class="input-group-text"><i class="fa fa-eye" onclick="togglePass('cpass')"></i></span>
                    </div>

                    <button type="submit" name="register" class="btn btn-main">Create Account</button>

                    <p class="login-link text-secondary">
                        Already have an account?
                        <a href="login.php" class="text-white text-decoration-none fw-bold">Login</a>
                    </p>
                </form>
            </div>
        </div>


    </section>

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