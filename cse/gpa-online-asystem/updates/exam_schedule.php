<?php
include("../config/database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Schedule | Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        /* --glass-bg: rgba(255, 255, 255, 0.95); */
        --glass-bg: rgba(255, 255, 255, 0.05);

    }

    body {
        background: #0f172a;
        font-family: 'Inter', sans-serif;
        color: #334155;
        /* padding-bottom: 50px; */
    }

    /* Modern Header Box */
    .header-box {
        background: var(--primary-gradient);
        color: white;
        padding: 40px 20px;
        margin-top: 100px;
        border-radius: 20px 20px 0 0;
        text-align: center;
        margin-bottom: -50px;
        /* Overlap effect */
        box-shadow: 0 10px 25px rgba(118, 75, 162, 0.3);
        position: relative;
        z-index: 1;
    }

    .header-box h2 {
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    /* Elevated Card Design */
    .main-card {
        
        border: none;
        border-radius: 20px;
        background: var(--glass-bg);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        padding: 60px 25px 25px 25px;
        /* Top padding for overlap */
        margin-top: 0;
    }

    /* Table Styling */
    .table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .table thead th {
        background: transparent;
        color: #64748b;
        text-transform: uppercase;
        font-size: 0.75rem;
        font-weight: 700;
        border: none;
        padding: 15px;
    }

    .table tbody tr {
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.05);
        background: #fff !important;
        

    }

    .table td {
        padding: 18px 15px;
        border: none;
        vertical-align: middle;
    }

    .table td:first-child {
        border-radius: 12px 0 0 12px;
    }

    .table td:last-child {
        border-radius: 0 12px 12px 0;
    }

    /* Status Badges */
    .badge-exam {
        background: #e0e7ff;
        color: #4338ca;
        padding: 6px 12px;
        font-weight: 500;
        border-radius: 8px;
    }

    /* Modern Download Button */
    .download-btn {
        background: #10b981;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 500;
        transition: 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .download-btn:hover {
        background: #059669;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Responsive Fixes */
    @media (max-width: 768px) {
        .header-box {
            padding: 30px 15px;
            margin-bottom: -40px;
        }

        .header-box h2 {
            font-size: 1.5rem;
        }

        .main-card {
            padding: 50px 15px 15px 15px;
        }

        .table-responsive {
            border: none;
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


    <div class="container my-4">
        <div class="header-box">
            <h2><i class="fa-solid fa-calendar-check me-2"></i>Exam Schedule</h2>
            <p class="opacity-75 mb-0 font-weight-light">Access all examination timetables in one place</p>
        </div>

        <div class="card main-card ">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-file-signature me-1"></i> Title</th>
                            <th><i class="fa-solid fa-tags me-1"></i> Type</th>
                            <th><i class="fa-solid fa-clock me-1"></i> Duration</th>
                            <th><i class="fa-solid fa-calendar-day me-1"></i> Posted</th>
                            <th class="text-end px-4 "> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM exam_schedules ORDER BY id DESC");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr >
                            <td class="fw-bold text-dark">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </td>
                            <td>
                                <span class="badge-exam">
                                    <?php echo htmlspecialchars($row['exam_type']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="small">
                                    <span class="text-success"><i
                                            class="fa-regular fa-circle-play me-1"></i><?php echo date("d M Y", strtotime($row['exam_start_date'])); ?></span>
                                    <span class="text-muted mx-1">→</span>
                                    <span class="text-danger"><i
                                            class="fa-regular fa-circle-stop me-1"></i><?php echo date("d M Y", strtotime($row['exam_end_date'])); ?></span>
                                </div>
                            </td>
                            <td class="text-muted small">
                                <?php echo date("d-m-Y", strtotime($row['upload_date'])); ?>
                            </td>
                            <td class="text-end px-4">
                                <a href="../uploads/exam_schedule/<?php echo $row['file_name']; ?>"
                                    class="download-btn btn-sm" download>
                                    <i class="fa-solid fa-cloud-arrow-down"></i> PDF
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
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