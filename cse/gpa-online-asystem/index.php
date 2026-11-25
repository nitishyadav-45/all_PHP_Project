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
    <link rel="stylesheet" href="assets/css/index.css">

    <link rel="icon" href="assets/images/gpa.png" type="image/x-icon" />


    <style>
    .badge {
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.3;
        }

        100% {
            opacity: 1;
        }
    }

    /* --- RESPONSIVE ADJUSTMENTS --- */
    @media (max-width: 768px) {

        .about-text {
            text-align: center;
            margin-bottom: 30px;
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
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="features.php">Features</a></li>

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

                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <section id="home">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/images/main.jpeg"
                        class="d-block w-100" alt="College Building">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Government Polytechnic Atraulia</h5>
                        <p>Empowering Future Engineers with Digital Attendance Solutions.</p>
                        <a href="#about" class="btn btn-primary btn-lg rounded-pill px-5">Learn More</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop"
                        class="d-block w-100" alt="Students in Class">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Smart Attendance System</h5>
                        <p>Real-time tracking, transparent records, and secure data management.</p>
                        <a href="auth/login.php" class="btn btn-danger btn-lg rounded-pill px-5">Login Now</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=2070&auto=format&fit=crop"
                        class="d-block w-100" alt="Technology">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Seamless Integration</h5>
                        <p>Accessible on any device. Monitor your progress from anywhere.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <section class="notice-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h2 class="section-title">Latest Updates</h2>
                    <p class="mb-4">See important information for students and teachers here. Check back regularly for
                        information on exams, holidays, and assignments.</p>

                    <div class="list-group bg-dark">
                        <!-- <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fas fa-calendar-alt text-warning me-2"></i> Exam Schedule 2024
                        </a> -->

                        <!-- <a href="updates/exam_schedule.php"
                            class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fas fa-calendar-alt text-warning me-2"></i> Exam Schedule
                        </a> -->
                        <?php
                        include("config/database.php");

                        $new_badge = false;

                        $q = mysqli_query($conn,"SELECT upload_date FROM exam_schedules ORDER BY id DESC LIMIT 1");

                        if($row = mysqli_fetch_assoc($q)){

                        $upload_date = strtotime($row['upload_date']);
                        $current_date = strtotime(date("Y-m-d"));

                        $diff = ($current_date - $upload_date) / (60*60*24);

                        if($diff <= 5){
                        $new_badge = true;
                        }

                        }
                        ?>

                        <a href="updates/exam_schedule.php"
                            class="list-group-item list-group-item-action bg-dark text-light border-secondary d-flex justify-content-between align-items-center ">
                            <div>
                                <i class="fas fa-calendar-alt text-warning me-2 "></i> Exam Schedule
                            </div>
                            <?php if($new_badge){ ?>
                            <span class="badge bg-danger ms-2 ">NEW</span>
                            <?php } ?>

                        </a>


                        <!-- <a href="updates/principaldesk.php"
                            class="list-group-item list-group-item-action bg-dark text-light border-secondary d-flex justify-content-between align-items-center ">
                            <div>
                                <i class="fas fa-envelope-open-text text-success me-2"></i> Principal's Desk
                            </div>
                        </a> -->
                        <?php

                            // 1. Latest message fetch karein
                            $query = "SELECT * FROM principal_messages ORDER BY id DESC LIMIT 1";
                            $result = mysqli_query($conn, $query);
                            $row = mysqli_fetch_assoc($result);

                            $show_badge = false;

                            if ($row) {
                            // 2. Message ki date aur aaj ki date ka difference nikaalein
                            $created_at = strtotime($row['created_at']);
                            $today = strtotime(date("Y-m-d H:i:s"));
    
                            // Difference in seconds
                            // $diff = $today - $created_at;
                            $diff = ($current_date - $upload_date) / (60*60*24);

    
                            // Agar message 3 din (259200 seconds) se purana nahi hai toh badge dikhayein
                            // (3 din * 24 ghante * 60 min * 60 sec = 259200)

                            // if ($diff < 86400) {
                            if($diff <= 5){

                            $show_badge = true;
                              }
                            }
                        ?>

                        <a href="updates/principaldesk.php"
                            class="list-group-item list-group-item-action bg-dark text-light border-secondary d-flex justify-content-between align-items-center">
                            <div >
                                <i class="fas fa-envelope-open-text text-success me-2"></i>
                                Principal's Desk
                            </div>
                                <?php if ($show_badge): ?>
                                <span class="badge  bg-danger ms-2 ">
                                    New
                                </span>
                                <?php endif; ?>
                            
                        </a>

                        <a href="updates/gallery.php"
                            class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fas fa-images text-info me-2"></i> College Gallery
                        </a>
                        <a href="updates/syllabus.php" class="list-group-item list-group-item-action bg-dark text-light border-secondary">
                            <i class="fas fa-file-pdf text-danger me-2"></i> Download Syllabus
                        </a>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="notice-box">
                        <div class="notice-header">
                            <span><i class="fas fa-bullhorn me-2"></i> Notice Board</span>

                        </div>

                        <div class="marquee-container">
                            <!-- <div class="marquee-content">
                                <div class="notice-item">
                                    <span class="notice-date"><i class="far fa-clock"></i> 25 Oct, 2024</span>
                                    <p class="notice-text">Final Year students attendance submission deadline extended
                                        till 30th Oct.</p>
                                </div>
                                <div class="notice-item">
                                    <span class="notice-date"><i class="far fa-clock"></i> 24 Oct, 2024</span>
                                    <p class="notice-text">Diwali Holidays announced from 1st Nov to 5th Nov. College
                                        will reopen on 6th Nov.</p>
                                </div>
                                <div class="notice-item">
                                    <span class="notice-date"><i class="far fa-clock"></i> 20 Oct, 2024</span>
                                    <p class="notice-text">Guest Lecture on "AI in Engineering" by Dr. R.K. Singh on
                                        Monday in Seminar Hall.</p>
                                </div>
                                <div class="notice-item">
                                    <span class="notice-date"><i class="far fa-clock"></i> 18 Oct, 2024</span>
                                    <p class="notice-text">Scholarship forms are available in the office. Last date to
                                        apply is approaching.</p>
                                </div>
                                <div class="notice-item">
                                    <span class="notice-date"><i class="far fa-clock"></i> 15 Oct, 2024</span>
                                    <p class="notice-text">Library card renewal process has started for 2nd Year
                                        students.</p>
                                </div>
                            </div> -->
                            <div class="marquee-content">

                                <?php
                                    include("config/database.php");

                                    $query = mysqli_query($conn,"SELECT * FROM notices ORDER BY notice_date DESC LIMIT 10");

                                    while($row = mysqli_fetch_assoc($query)){
                                ?>

                                <?php
                                        // Notice ki date ko timestamp mein convert karein
                                        $notice_date = strtotime($row['notice_date']);
                                        // Aaj ki date ka timestamp
                                        $current_date = time();

                                        // Dono ke beech ka difference (seconds mein)
                                         $diff_in_seconds = $current_date - $notice_date;

                                        // Seconds ko days mein convert karein (1 day = 86400 seconds)
                                        $diff_in_days = floor($diff_in_seconds / 86400);

                                        // Agar difference 5 din se kam hai aur notice purana nahi hai (0 se zyada)
                                        $new_badge = ($diff_in_days <= 5 && $diff_in_days >= 0);
                                    ?>
                                <div class="notice-item">


                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="notice-date">
                                            <i class="far fa-clock"></i>
                                            <?php echo date("d M, Y",strtotime($row['notice_date'])); ?>
                                        </span>

                                        <?php 
                                            // Logic check: Agar notice 5 din ke andar ka hai
                                            $notice_time = strtotime($row['notice_date']);
                                            $days_diff = (time() - $notice_time) / (60 * 60 * 24);

                                            if($days_diff <= 5) { ?>
                                        <span class="badge bg-danger">NEW</span>
                                        <?php } ?>

                                    </div>

                                    <p class="notice-text">
                                        <?php echo $row['description']; ?>


                                    </p>

                                </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 about-text">
                    <h2 class="section-title">About The System</h2>
                    <h4 class="text-white mb-3">Digital Initiative for Smart Education</h4>
                    <p class="lead">
                        Government Polytechnic, Atraulia, Azamgarh has introduced an advanced <strong
                            class="text-primary">Online Attendance
                            System</strong> for students and teachers.
                    </p>
                    <p>
                        This portal not only records attendance but also ensures transparency and accuracy. There is no
                        longer any need for paperwork. This system is completely secure and can be easily accessed on
                        any mobile device, tablet, or computer.
                    </p>
                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> 100% paperless and
                            digital.
                        </li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Real-time report
                            generation.
                        </li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> SMS alert facility for
                            parents.</li>
                    </ul>
                    <a href="#" class="btn btn-outline-light mt-3">Read Documentation</a>
                </div>
                <div class="col-lg-6">
                    <div class="about-img-wrapper">
                        <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=2015&auto=format&fit=crop"
                            alt="Dashboard Preview">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Key Features</h2>
                <p>Designed for efficiency, security, and ease of use.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card">
                        <i class="fas fa-mobile-alt feature-icon"></i>
                        <h5>Fully Responsive</h5>
                        <p>Whether you use a smartphone, tablet, or laptop, the interface adapts perfectly to your
                            screen size.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card">
                        <i class="fas fa-user-shield feature-icon"></i>
                        <h5>Secure Login</h5>
                        <p>Encrypted authentication for Students, Teachers, and Admin to ensure data privacy.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h5>Analytics Dashboard</h5>
                        <p>Visual graphs and monthly reports to track attendance percentage instantly.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card">
                        <i class="fas fa-bell feature-icon"></i>
                        <h5>Instant Notifications</h5>
                        <p>Get notified about low attendance or holiday announcements directly on your dashboard.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card">
                        <i class="fas fa-file-export feature-icon"></i>
                        <h5>Export Reports</h5>
                        <p>Teachers can download attendance sheets in PDF or Excel format with a single click.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-card">
                        <i class="fas fa-map-marker-alt feature-icon"></i>
                        <h5>Geo-Tagging</h5>
                        <p>Ensures attendance is marked only within the college campus (Atraulia) premises.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stat-number">1000+</div>
                    <p>Students</p>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stat-number">50+</div>
                    <p>Faculty</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">3+</div>
                    <p>Departments</p>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">100%</div>
                    <p>Digitalized</p>
                </div>
            </div>
        </div>
    </section>

    <section id="login" class="login-section">
        <div class="container">
            <div class="text-center mb-5 text-white">
                <h2 class="fw-bold">Select Your Role</h2>
                <p>Please login to access your dashboard.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="login-card">
                        <div class="mb-3">
                            <i class="fas fa-user-graduate fa-4x text-light"></i>
                        </div>
                        <h4 class="text-white">Student Portal</h4>
                        <p class="text">Check your daily attendance, view history, and download reports.</p>
                        <a href="auth/login.php"><button class="btn login-btn btn-student">Student Login</button></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="login-card">
                        <div class="mb-3">
                            <i class="fas fa-chalkboard-teacher fa-4x text-light"></i>
                        </div>
                        <h4 class="text-white">Faculty Portal</h4>
                        <p class="text">Mark attendance, manage students, and generate class reports.</p>
                        <a href="auth/login.php"><button class="btn login-btn btn-teacher">Teacher Login</button></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="login-card">
                        <div class="mb-3">
                            <i class="fas fa-user-cog fa-4x text-light"></i>
                        </div>
                        <h4 class="text-white">Admin Portal</h4>
                        <p class="text">Manage system settings, add users, and oversee all data.</p>
                        <a href="auth/adminlogin.php"><button class="btn login-btn btn-admin">Admin Login</button></a>
                    </div>
                </div>
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
    </script>
</body>

</html>