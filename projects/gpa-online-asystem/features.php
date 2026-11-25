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
    <link rel="stylesheet" href="assets/css/features.css">
    <link rel="icon" href="assets/images/gpa.png" type="image/x-icon" />

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
                    <li class="nav-item"><a class="nav-link active" href="#features">Features</a></li>
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
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <header class="page-header mt-5">
        <div class="container">
            <h1 class="page-title">System Features</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Features</li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="features-grid">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="mb-3">Why Choose Our System?</h2>
                    <p class="lead">Built with modern web technologies to ensure speed, security, and reliability for
                        the entire college campus.</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box-lg">
                        <div class="icon-lg">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <!-- <h4>Real-Time Tracking</h4>
                        <p>Attendance is marked and updated in the database instantly. No lag, no manual data entry
                            errors.</p> -->
                        <h3>Online Attendance</h3>
                        <p>A live, real-time attendance system is operational on campus, allowing faculty and students to track their daily records.</p>


                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box-lg">
                        <div class="icon-lg">
                            <i class="fa-solid fa-cloud-arrow-down"></i>
                        </div>
                        <!-- <h4>Automated Reports</h4>
                        <p>Generate monthly or yearly PDF/Excel reports for individual students or the whole class with
                            one click.</p> -->
                        <h3>Resource Center</h3>
                        <p>The database of study materials, previous years' papers, and lab manuals is fully active and available to students.</p>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box-lg">
                        <div class="icon-lg">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <!-- <h4>High Security</h4>
                        <p>Role-based access control ensures students cannot edit data. Only authorized faculty can
                            modify records.</p> -->
                        <h3>Experienced Faculty</h3>
                        <p>Our highly qualified heads and lecturers are continuously guiding students in their practical and theoretical subjects.</p>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box-lg">
                        <div class="icon-lg">
                            <i class="fa-solid fa-vihara"></i>
                        </div>
                        <!-- <h4>Mobile Friendly</h4>
                        <p>The interface is designed using Bootstrap 5, making it 100% responsive on Android and iOS
                            devices.</p> -->
                        <h3>Campus Facilities</h3>
                        <p>Hostels, modern computer labs, advanced workshops, and sports grounds are fully operational.</p>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box-lg">
                        <div class="icon-lg">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <!-- <h4>SMS/Email Alerts</h4>
                        <p>Parents receive automated SMS alerts if a student is absent for more than 3 consecutive days.
                        </p> -->
                        <h3>Training & Placement</h3>
                        <p>Our active Placement Cell is continuously organizing campus recruitment drives in collaboration with top tech companies and industries.</p>

                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="feature-box-lg">
                        <div class="icon-lg">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <!-- <h4>Graphical Analytics</h4>
                        <p>Visual dashboard with Pie Charts and Bar Graphs to analyze class performance at a glance.</p>
                     -->
                        <h3>Live Notice Board</h3>
                        <p>The latest campus updates, exam schedules, and essential government circulars are being updated live on our digital board.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="role-features">
        <div class="container">
            <div class="text-center mb-5">
                <h2>Role-Specific Features</h2>
                <p>Tailored interfaces for every user type.</p>
            </div>

            <ul class="nav nav-pills mb-4 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-student-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-student" type="button" role="tab">Student</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-teacher-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-teacher" type="button" role="tab">Teacher</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-admin-tab" data-bs-toggle="pill" data-bs-target="#pills-admin"
                        type="button" role="tab">Admin</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-student" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <img src="assets/images/student.jpg" class="img-fluid rounded-5 border border-secondary"
                                alt="Student Dashboard">
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <h3 class="text-primary mb-3">Student Dashboard</h3>
                            <ul class="list-unstyled role-list">
                                <li><i class="fas fa-check"></i> View daily attendance status instantly.</li>
                                <li><i class="fas fa-check"></i> Check subject-wise percentage.</li>
                                <li><i class="fas fa-check"></i> Apply for leave online.</li>
                                <li><i class="fas fa-check"></i> View academic calendar and holidays.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-teacher" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <img src="assets/images/teacher.jpg" class="img-fluid rounded-5 border border-secondary"
                                alt="Teacher Dashboard">
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <h3 class="text-danger mb-3">Faculty Dashboard</h3>
                            <ul class="list-unstyled role-list">
                                <li><i class="fas fa-check"></i> Mark attendance for multiple classes easily.</li>
                                <li><i class="fas fa-check"></i> Modify attendance in case of errors (within 24hrs).
                                </li>
                                <li><i class="fas fa-check"></i> Export class registers to PDF/Excel.</li>
                                <li><i class="fas fa-check"></i> Identify students with low attendance (Below 75%).</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-admin" role="tabpanel">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070"
                                class="img-fluid rounded-5 border border-secondary" alt="Admin Dashboard">
                        </div>
                        <div class="col-lg-6 mt-4 mt-lg-0">
                            <h3 class="text-warning mb-3">Administrator Control</h3>
                            <ul class="list-unstyled role-list">
                                <li><i class="fas fa-check"></i> Add/Remove Students and Faculty members.</li>
                                <li><i class="fas fa-check"></i> Manage Academic Sessions and Semesters.</li>
                                <li><i class="fas fa-check"></i> Reset passwords for users.</li>
                                <li><i class="fas fa-check"></i> Full database backup and restoration.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 text-center"
        style="background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));">
        <div class="container">
            <h2 class="text-white mb-3">Ready to get started?</h2>
            <p class="text-white mb-4">Join the digital revolution at Government Polytechnic Atraulia Azamgarh.</p>
            <a href="auth/login.php" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-dark">Login Now</a>
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