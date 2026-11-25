<?php
include("../config/database.php");
$q = mysqli_query($conn,"SELECT * FROM principal_messages ORDER BY id DESC LIMIT 1");

$data = mysqli_fetch_assoc($q);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Desk | GP Atraulia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-bg: rgba(255, 255, 255, 0.07);
        --glass-border: rgba(255, 255, 255, 0.1);
        --text-muted: #94a3b8;
    }

    body {
        background: #0f172a;
        /* Deep Dark Blue */
        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        /* padding-bottom: 50px; */
        overflow-x: hidden;
    }

    /* Decorative Background Elements */
    .bg-glow {
        position: absolute;
        width: 300px;
        height: 300px;
        background: #764ba2;
        filter: blur(150px);
        opacity: 0.2;
        z-index: -1;
        border-radius: 50%;
    }

    .principal-section {
        padding-top: 80px;
    }

    .section-title {
        font-weight: 800;
        letter-spacing: -1px;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 40px;
        font-size: 2.5rem;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s ease;
    }

    .accent-top {
        height: 6px;
        background: var(--primary-gradient);
    }

    .message-content {
        padding: 50px;
        position: relative;
    }

    .quote-icon {
        font-size: 4rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        opacity: 0.2;
        position: absolute;
        top: 20px;
        left: 30px;
    }

    .title-text {
        color: #fff;
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
    }

    .message-text {
        font-size: 1.1rem;
        line-height: 1.9;
        color: #cbd5e1;
        font-weight: 300;
        text-align: justify;
    }

    .signature-box {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid var(--glass-border);
    }

    .principal-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0;
    }

    .college-info {
        color: #764ba2;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
    }

    .best-regards {
        color: #ae95c8;
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .message-content {
            padding: 30px;
        }

        .section-title {
            font-size: 2rem;
        }

        .message-text {
            font-size: 1rem;
        }
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-university fa-lg"></i>
                GPA <span>AZAMGARH</span>
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link " href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="../features.php">Features</a></li>

                    <li class="dropdown nav-item">
                        <a href="#" class="dropbtn active text-light">Register ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link" href="../auth/register_student.php">Student Register</a>
                            <a class="nav-link" href="../auth/register_teacher.php">Teacher Register</a>

                        </div>
                    </li>

                    <li class="dropdown nav-item ms-3">
                        <a href="#" class="dropbtn active text-light">Login Portal ▾</a>
                        <div class="dropdown-content">
                            <a class="nav-link " href="../auth/login.php">Student / Teacher Login</a>
                            <a class="nav-link" href="../auth/adminlogin.php">Admin Login</a>

                        </div>
                    </li>

                    <li class="nav-item"><a class="nav-link" href="../contact.php">Contact</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="bg-glow" style="top: 10%; left: 10%;"></div>
    <div class="bg-glow" style="bottom: 10%; right: 10%;"></div>

    <section class="principal-section my-4">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">Principal's Desk</h2>
            </div>
            <?php if($data){ ?>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="glass-card">
                        <div class="accent-top"></div>

                        <div class="message-content">
                            <i class="fas fa-quote-left quote-icon"></i>

                            <h3 class="title-text">
                                <span class="d-block text-center fw-light mb-1 "
                                    style="font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px;">Official
                                    Message</span>
                                <hr>
                                <div class="mt-5">
                                    <?php echo $data['title']; ?>
                                </div>
                            </h3>

                            <div class="message-text ">
                                <?php echo nl2br($data['message']); ?>
                            </div>

                            <div class="signature-box text-end">
                                <p class="mb-1 best-regards">Best Regards,</p>
                                <p class="principal-name">Principal Office</p>
                                <p class="college-info">Government Polytechnic Atraulia</p>
                                <small class="text-primary">Azamgarh, Uttar Pradesh</small>
                            </div>
                            <?php } else { ?>

                            <h4 class="text-center text-danger">
                                No Message Available
                            </h4>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact ">
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
</body>

</html>