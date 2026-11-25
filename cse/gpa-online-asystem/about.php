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
    <link rel="stylesheet" href="assets/css/about.css">
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
                    <li class="nav-item"><a class="nav-link active" href="#about">About </a></li>
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

    <header class="page-header mt-5">
        <div class="container">
            <h1 class="page-title">About Our College</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="college-section">
        <div class="container">
            <div class="row align-items-center my-5">
                <div class="col-sm-7">
                    <h3>Welcome To Government Polytechnic Atraulia Azamgarh</h3>
                    <p>Government Polytechnic Atraulia, located in Azamgarh, Uttar Pradesh, is a premier institution
                        dedicated to technical education and skill development. Established with the vision of promoting
                        technical proficiency among students, the college has become a vital part of the region's
                        educational landscape.</p>
                    <h3>Courses Offered</h3>
                    <p class="text-secondary">The polytechnic offers a range of diploma programs in various disciplines,
                        including:</p> <br>
                    <p>
                        1. Computer Science and Engineering <br>
                        2. Electrical Engineering <br>
                        3. Mechanical Engineering <br>
                        4. P.G Diploma in Computer Application.
                    </p>
                </div>
                <div class="college-image col-sm-5">
                    <img src="assets/images/main.jpeg" alt="">
                </div>

            </div>
        </div>

    </section>

    <section class="principal-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <img src="assets/images/images.jpeg" alt="Principal" class="principal-img">
                </div>
                <div class="col-lg-8">
                    <!-- <h5 class="text-secondary text-uppercase mb-2">Welcome to GPA Azamgarh</h5> -->
                    <h2 class="mb-4">Principal's About</h2>
                    <p>Dr. Subodh Kant is a distinguished academician and visionary leader with over 14 years of
                        expertise in technical education. Holding a Ph.D. in Computer Science and Engineering, he
                        currently serves as the Principal of Government Polytechnic Atraulia, Azamgarh, and Director at
                        AICCEDS. Dr. Kant has been instrumental in transforming technical education in Uttar Pradesh by
                        prioritizing infrastructure development, digital governance, and robust industry-academia
                        collaboration. His administrative leadership is marked by progressive curriculum reforms and the
                        establishment of modern laboratories to bridge the gap between classroom learning and industry
                        demands.</p>

                    <div class="quote-box">
                        <p class="mb-0">"Education is the most powerful weapon which you can use to change the world.
                            Technology amplifies that power."</p>
                    </div>

                    <div class="mt-4">
                        <h5 class="mb-0 text-white">Dr. Subodh Kant </h5>
                        <small class="text-secondary">Principal, Goverment Polytechnic Atraulia</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mv-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mv-card">
                        <i class="fas fa-bullseye mv-icon"></i>
                        <h3>Our Mission</h3>
                        <p class="mt-3">Government Polytechnic Atraulia, Azamgarh, is committed to providing quality
                            technical education that fosters innovation and skill development. Its mission is to empower
                            students with practical knowledge and competencies essential for the evolving job market.
                            The institution aims to promote holistic development through a supportive learning
                            environment, industry collaboration, and community engagement. By nurturing critical
                            thinking and entrepreneurship, Government Polytechnic Atraulia seeks to prepare graduates
                            who can contribute effectively to society and drive progress in their respective fields.
                            Ultimately, the goal is to enhance the employability of students and support regional
                            economic development.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mv-card">
                        <i class="fas fa-lightbulb mv-icon"></i>
                        <h3>Our Vision</h3>
                        <p class="mt-3">Government Polytechnic Atraulia, Azamgarh, envisions becoming a leading
                            institution in technical education, recognized for excellence and innovation. The college
                            aims to create a dynamic learning environment that fosters creativity, critical thinking,
                            and practical skills among students. By aligning its curriculum with industry demands and
                            emerging technologies, the institution seeks to produce competent professionals ready to
                            meet the challenges of the modern workforce. Additionally, it strives to promote sustainable
                            development and social responsibility, ensuring that graduates not only excel in their
                            careers but also contribute positively to society and the economy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="dept-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Our Departments</h2>
                <div style="width: 60px; height: 3px; background: var(--secondary-color); margin: 0 auto;"></div>
            </div>
            <div class="row g-3 justify-content-center">
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="dept-box">
                        <i class="fas fa-laptop-code mb-3 fa-2x text-warning"></i>
                        <h5>Computer Science</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="dept-box">
                        <i class="fas fa-cogs mb-3 fa-2x text-danger"></i>
                        <h5>Mechanical Engg.</h5>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="dept-box">
                        <i class="fas fa-bolt mb-3 fa-2x text-info"></i>
                        <h5>Electrical Engg.</h5>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <div class="dept-box">
                        <i class="fas fa-keyboard mb-3 fa-2x text-primary"></i>
                        <h5>P.G Computer App.</h5>
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