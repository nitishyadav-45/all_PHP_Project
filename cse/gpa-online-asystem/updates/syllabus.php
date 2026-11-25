<?php
include("../config/database.php");

$where = "WHERE status='approved'";

/* FILTER & SEARCH */
if(isset($_GET['branch']) && $_GET['branch'] != ""){
    $branch = mysqli_real_escape_string($conn, $_GET['branch']);
    $where .= " AND branch='$branch'";
}

if(isset($_GET['semester']) && $_GET['semester'] != ""){
    $semester = mysqli_real_escape_string($conn, $_GET['semester']);
    $where .= " AND semester='$semester'";
}

if(isset($_GET['search']) && $_GET['search'] != ""){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where .= " AND subject_name LIKE '%$search%'";
}

$query = mysqli_query($conn, "SELECT * FROM syllabus $where ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syllabus Hub | Modern Download Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">


    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-bg: rgba(255, 255, 255, 0.95);
    }

    body {
        background: #0f172a;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .header-section {
        background: var(--primary-gradient);
        color: white;
        padding: 60px 0;
        margin-bottom: -50px;
        border-radius: 0 0 50px 50px;
    }

    /* Search Bar Styling */
    .filter-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 40px;
    }

    .form-control,
    .form-select {
        border-radius: 10px;
        padding: 12px;
        border: 1px solid #e0e0e0;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.2);
        border-color: #764ba2;
    }

    /* Syllabus Cards */
    .syllabus-card {
        /* background:#764ba2 !important; */
        border: none;
        border-radius: 20px;
        background: white;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        height: 100%;
        position: relative;
    }

    .syllabus-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .card-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(118, 75, 162, 0.1);
        color: #764ba2;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        background: var(--primary-gradient);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .btn-download {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s;
        color: white;
        width: 100%;
    }

    .btn-download:hover {
        opacity: 0.9;
        box-shadow: 0 5px 15px rgba(118, 75, 162, 0.4);
        color: white;
    }

    .stats-info {
        font-size: 0.85rem;
        color: #6c757d;
        border-top: 1px solid #eee;
        padding-top: 15px;
        margin-top: 15px;
    }

    /* Custom Empty State */
    .empty-state {
        padding: 50px;
        text-align: center;
    }

    .section {
        margin-top: 75px;
    }
    </style>
</head>

<body>

    <nav class=" navbar navbar-expand-lg fixed-top">
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

    <div class="section ">
        <div class="header-section text-center ">
            <div class="container">
                <h1 class="display-5 fw-bold"><i class="fas fa-book-open me-2"></i>Syllabus Repository</h1>
                <p class="lead opacity-75">Access and download your academic curriculum with ease.</p>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="filter-card">
                        <form method="GET" class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Search Subject</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0"><i
                                            class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0"
                                        placeholder="e.g. Mathematics..." value="<?php echo $_GET['search'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Branch</label>
                                <input type="text" name="branch" class="form-control" placeholder="e.g. CS, ME"
                                    value="<?php echo $_GET['branch'] ?? ''; ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Semester</label>
                                <select name="semester" class="form-select">
                                    <option value="">All Semesters</option>
                                    <?php for($i=1; $i<=6; $i++): ?>
                                    <option value="Sem <?php echo $i; ?>"
                                        <?php echo (isset($_GET['semester']) && $_GET['semester'] == "Sem $i") ? 'selected' : ''; ?>>
                                        Semester <?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button class="btn btn-primary w-100 py-2 fw-bold"
                                    style="background:#764ba2; border:none;">
                                    <i class="fas fa-filter me-2"></i>Apply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row  g-4 mb-5">
                <?php 
                        if(mysqli_num_rows($query) > 0){
                            while($row = mysqli_fetch_assoc($query)){ 
                ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card syllabus-card p-4">
                        <span class="card-badge">
                            <i class="fas fa-university me-1"></i> <?php echo $row['branch']; ?>
                        </span>

                        <div class="icon-box">
                            <i class="fas fa-file-pdf"></i>
                        </div>

                        <h5 class="fw-bold mb-2 text-dark"><?php echo $row['subject_name']; ?></h5>
                        <p class="text-muted small mb-3">
                            <?php echo substr($row['description'], 0, 100) . '...'; ?>
                        </p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-dark border">
                                <i class="far fa-calendar-alt me-1 text-primary"></i> <?php echo $row['semester']; ?>
                            </span>
                        </div>

                        <a href="download_syllabus.php?id=<?php echo $row['id']; ?>" class="btn btn-download">
                            <i class="fas fa-cloud-download-alt me-2"></i>Download Now
                        </a>

                        <div class="stats-info d-flex justify-content-between">
                            <span><i class="far fa-eye me-1"></i> Public Access</span>
                            <span class="fw-bold text-success">
                                <i class="fas fa-arrow-down me-1"></i> <?php echo $row['download_count']; ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php 
                } 
            } else {
                echo '<div class="empty-state">
                        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                        <h3>No Syllabus Found</h3>
                        <p class="text-light">Try adjusting your filters or search keywords.</p>
                        <a href="?" class="btn btn-outline-primary">Clear All Filters</a>
                      </div>';
            }
            ?>
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