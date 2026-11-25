<?php
include("config/database.php");

$success = "";
$error = "";

if(isset($_POST['send_message'])){

    // 1. INPUT SANITIZATION (Security ke liye zaroori hai)
    // User input ko clean karein taaki database hack na ho sake
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $mobile = mysqli_real_escape_string($conn, trim($_POST['mobile']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $subject = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    // 2. BASIC VALIDATION
    if(empty($name) || empty($mobile) || empty($email) || empty($subject) || empty($message)){
        $error = "All fields are required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format!";
    }
    elseif(!preg_match("/^[0-9]{10}$/",$mobile)){
        $error = "Mobile number must be 10 digits!";
    }
    else{
        // 3. DATABASE INSERTION
        $query = "INSERT INTO enquiries (name, mobile, email, subject, message) 
                  VALUES ('$name', '$mobile', '$email', '$subject', '$message')";
        
        if(mysqli_query($conn, $query)){
            $success = "Your enquiry has been sent successfully!";

            // ===================================================
            // 4. SMS SENDING LOGIC (Yahan add kiya gaya hai)
            // ===================================================
            
            // API URL
            $url = "http://sms.bulkssms.com/submitsms.jsp";
            
            // Parameters set karna
            $params = [
                "user"      => "BRIJESH",
                "key"       => "066c862acdXX",
                "mobile"    => $mobile, // User ka mobile number form se
                "message"   => "Thanks for enquiry we will contact you soon.\n\n-Bulk SMS",
                "senderid"  => "UPDSMS",
                "accusage"  => "1",
                "entityid"  => "1201159543060917386",
                "tempid"    => "1207169476099469445"
            ];

            // URL aur Parameters ko jodna
            $queryString = http_build_query($params);
            $finalUrl = $url . "?" . $queryString;

            // CURL library ka use karke SMS bhejna (Yeh best tarika hai)
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $finalUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
            // Request execute karna
            $sms_response = curl_exec($ch);
            
            // Connection close karna
            curl_close($ch);

            // (Optional) Aap chahein to $sms_response check kar sakte hain debugging ke liye
            // echo $sms_response; 

            // ===================================================
            // SMS LOGIC END
            // ===================================================

        } else {
            $error = "Something went wrong. Try again!";
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

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="icon" href="assets/images/gpa.png" type="image/x-icon"/>



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
                    <li class="nav-item"><a class="nav-link " href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="about.php">About </a></li>
                    <li class="nav-item"><a class="nav-link " href="features.php">Features</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li> -->

                    <li class="dropdown nav-item">
                        <a href="#" class="dropbtn active text-light">Register ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link" href="auth/register_student.php">Student Register</a>
                            <a class="nav-link" href="auth/register_teacher.php">Teacher Register</a>

                        </div>
                    </li>

                    <li class="dropdown nav-item ms-3">
                        <a href="#" class="dropbtn active text-light">Login Portal ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link " href="auth/login.php">Student / Teacher Login</a>
                            <a class="nav-link" href="auth/adminlogin.php">Admin Login</a>

                        </div>
                    </li>

                    <!-- <li class="nav-item"><a class="nav-link" href="#login">Login Portal</a></li> -->
                    <li class="nav-item"><a class="nav-link active" href="#contact">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>



    <header class="page-header mt-5 ">
        <div class="container">
            <h1 class="page-title">Get In Touch</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="contact-info-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Our Location</h4>
                        <p class="text-secondary mb-0">Atraulia, Azamgarh</p>
                        <p class="text-secondary">Uttar Pradesh, India - 223223</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Call Us</h4>
                        <p class="text-secondary mb-0">Admin: +91 98765 43210</p>
                        <p class="text-secondary">Office: +91 5462 123456</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email Us</h4>
                        <p class="text-secondary mb-0">info@gpatraulia.ac.in</p>
                        <p class="text-secondary">support@gpatraulia.ac.in</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="form-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <h2 class="mb-4">Send us a Message</h2>
                    <!-- Bootstrap Alerts -->
                    <?php if($success){ ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php } ?>

                    <?php if($error){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php } ?>

                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" placeholder="Enter Full Name" class="form-control"
                                    required pattern="[A-Za-z ]+">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" placeholder="000000000" class="form-control" required
                                    pattern="[0-9]{10}">

                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email"
                                required>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Write Subject">

                        </div>
                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-control" rows="5"
                                placeholder="Type your message here..."></textarea>
                        </div>
                        <button type="submit" name="send_message" class="btn btn-primary px-5 py-2 rounded-pill">Send
                            Message</button>
                    </form>
                </div>

                <div class="col-lg-5">
                    <h2 class="mb-4">Find Us</h2>
                    <div class="map-frame">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d13020.372086681919!2d82.92961681194811!3d26.385745584730078!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3991028865857cb7%3A0x7162682f394878b1!2sGovernment%20Polytechnic%20Atraulia%20Azamgarh!5e1!3m2!1sen!2sin!4v1771062840841!5m2!1sen!2sin"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="py-5 bg-dark border-top border-secondary">
        <div class="container">
            <h3 class="text-center mb-4">Frequently Asked Questions</h3>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item bg-transparent border-bottom border-secondary">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-transparent text-light shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne">
                                    How do I reset my password?
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body text-secondary">You can contact the Admin department or click
                                    on the "Forgot Password" link on the login page.</div>
                            </div>
                        </div>
                        <div class="accordion-item bg-transparent border-bottom border-secondary">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-transparent text-light shadow-none"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo">
                                    Can parents access the attendance?
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body text-secondary">Yes, parents can log in using the Student ID
                                    to view attendance records, but they cannot edit any data.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->



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
    </script>
</body>

</html>