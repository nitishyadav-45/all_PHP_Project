<?php
include("../config/database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Gallery | Premium View</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-bg: rgba(255, 255, 255, 0.05);
    }

    body {
        background: #0f172a;
        /* Deep Dark Blue */
        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        /* padding-bottom: 50px; */
    }

    /* .gallery-header {
            padding: 60px 0;
            text-align: center;

        }

        .gallery-header h2 {
            font-weight: 700;
            letter-spacing: 1px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            font-size: 2.5rem;
        } */

    /* Modern Header Box */
    .header-box {
        background: var(--primary-gradient);
        color: white;
        padding: 40px 20px;
        border-radius: 20px;
        text-align: center;
        /* margin-bottom: -50px; */
        box-shadow: 0 10px 25px rgba(118, 75, 162, 0.3);
        position: relative;
        z-index: 1;

    }

    .header-box h2 {
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Gallery Card Styling */
    .gallery-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        /* height: 100%; */
        margin-top: 100px;
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        border-color: #667eea;
    }

    /* Image Handling */
    .img-container {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .gallery-card img {
        width: 100%;
        /* height: 250px; */
        height:300px;
        object-fit: cover;
        /* Aspect ratio maintain karne ke liye */
        transition: transform 0.5s ease;
    }

    .gallery-card:hover img {
        transform: scale(1.1);
    }

    .card-body {
        padding: 20px;
        background: rgba(15, 23, 42, 0.8);
    }

    .card-title {
        color: #fff;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .card-text {
        color: #94a3b8;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* Modal styling for Full Image view */
    .modal-content {
        background: transparent;
        border: none;
       
    }

    .modal-body img {
        border-radius: 10px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
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

    <div class="container-fluid px-5 my-5">
        <!-- <header class="gallery-header">
            <h2><i class="fas fa-images me-2"></i>Campus Life Gallery</h2>
            <p class="text-light">Capturing moments that last a lifetime</p>
        </header> -->

        <div class="header-box " style="margin-top:100px;">
            <h2><i class="fas fa-images me-2"></i>Campus Life Gallery</h2>

            <p class="opacity-75 mb-0 font-weight-light">Capturing moments that last a lifetime</p>
        </div>

        <div class="row g-4">
            <?php
            $q = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($q)){
            ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card gallery-card">
                    <div class="img-container" data-bs-toggle="modal"
                        data-bs-target="#imgModal<?php echo $row['id']; ?>">
                        <img src="../updates/gallery/<?php echo htmlspecialchars($row['image']); ?>"
                            alt="<?php echo htmlspecialchars($row['title']); ?>" loading="lazy">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text text-truncate"><?php echo $row['description']; ?></p>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imgModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-body text-center p-0">
                            <img src="../updates/gallery/<?php echo htmlspecialchars($row['image']); ?>" class=" w-100">
                            <div class="p-3 bg-dark text-white rounded-bottom">
                                <h4><?php echo $row['title']; ?></h4>
                                <p><?php echo $row['description']; ?></p>
                                <button type="button" class="btn btn-sm btn-outline-light"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>


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