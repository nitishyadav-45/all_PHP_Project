<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}
$student_name = $_SESSION['student_name'];

$student_id = $_SESSION['student_id'];

$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests 
     WHERE student_id='$student_id' 
     AND status='Approved'"
);

$data = mysqli_fetch_assoc($query);

if(!$data){
    // echo "ID Card Not Approved Yet.";  
    echo '<div style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; margin: 20px auto; max-width: 400px; border-radius: 8px; font-family: Arial, sans-serif; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <span style="font-size: 20px; vertical-align: middle; margin-right: 8px;">⏳</span>
            <strong>Notice:</strong> ID Card Not Approved Yet.
          </div>'; 
    exit();
}


// Profile Image
$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Roboto:wght@400;700&family=Libre+Barcode+39+Text&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">


    <style>
    /* Base Settings to ensure printing with colors */
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            background-color: white !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .id-card-container {
            box-shadow: none !important;
            margin: 0 auto !important;
            page-break-inside: avoid;
        }

        /* Hide unnecessary UI elements during print to only show ID Card */
        .print-btn,
        .navbar,
        .sidebar {
            display: none !important;

        }

        /* Remove container margin so card aligns properly on paper */
        .container {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }
    }

    body {
        background-color: #f4f6f9;
        font-family: 'Roboto', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
    }


    /* add start */
    

    .container {
        margin-left: 300px;
        min-height: 100vh;
        transition: all 0.3s ease-in-out;
    }


    .id-card-container {
        width: 100%;
        max-width: 900px;
        background: linear-gradient(135deg, #fdfdfd 0%, #ebf4fa 100%);
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border: 2px solid gray;
        border-radius: 15px;
    }

    /* Abstract Shapes Background */
    .shape-top-left {
        position: absolute;
        top: 0;
        left: 0;
        width: 200px;
        height: 200px;
        background: #00b4d8;
        clip-path: polygon(0 0, 100% 0, 0 100%);
        z-index: 1;
    }

    .shape-top-left-dark {
        position: absolute;
        top: 40px;
        left: 0;
        width: 150px;
        height: 150px;
        background: #233261;
        clip-path: polygon(0 0, 100% 0, 0 100%);
        z-index: 2;
    }

    .shape-top-right {
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 100px;
        background: #2b78c5;
        border-bottom-left-radius: 50px;
        border-bottom-right-radius: 50px;
        transform: translateX(30px) translateY(-20px);
    }

    /* Header Section */
    .card-header-section {
        position: relative;
        padding: 30px 20px 20px 150px;
        /* Space for logo */
        z-index: 3;
    }

    .logo-shield {
        position: absolute;
        top: 0;
        left: 100px;
        width: 90px;
        height: 120px;
        background-color: #233261;
        clip-path: polygon(0 0, 100% 0, 100% 75%, 50% 100%, 0 75%);
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        font-size: 2.5rem;
        z-index: 4;
    }

    .university-name {
        font-family: 'Playfair Display', serif;
        color: #233261;
        font-size: 2.1rem;
        margin-bottom: 0;
        line-height: 1.1;
    }

    .university-address {
        color: #333;
        font-size: 1.1rem;
        text-align: center;
        /* margin-top: 5px; */
    }

    .university-addresss {
        color: #233261;
        font-weight: bold;
        font-size: 1.1rem;
        text-align: center;
        margin-top: 5px;
    }

    /* Main Body Section */
    .photo-section {
        background-color: #233261;
        padding: 20px;
        height: 100%;

    }

    .photo-section img {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border: 2px solid #233261;
        background-color: white;
    }

    .collage-mohar {

        margin-top: -90px;

        height: 100px;
    }

    .principal-singnature {
        text-align: center;
    }

    .principal-singnature img {
        margin-top: -20px;
    }

    .principal-singnature .sing {
        margin-top: -20px;
    }

    td {
        padding: 2px;

    }


    .student-card-title {
        background-color: #2b78c5;
        color: white;
        padding: 12px 40px;
        font-size: 1.8rem;
        font-weight: 700;
        border-radius: 0 30px 30px 0;
        display: inline-block;
        margin-left: -15px;
        /* Pulls slightly over the photo section */
        margin-top: 20px;
        margin-bottom: 40px;
    }

    /* Details Table */
    .details-table {
        width: 100%;
        font-size: 1.2rem;
        color: #233261;
        margin-left: 10px;
        margin-top: -20px;
    }

    .details-table td {
        /* padding: 10px 5px; */
        vertical-align: top;
    }

    .text {
        margin-left: 50px;

    }


    /* Utility */
    .text-navy {
        color: #233261 !important;
    }

    /* Mobile Responsive Logic */
    @media (max-width: 768px) {
        .sidebar {
            left: -260px;
            /* Mobile par sidebar hide rahega */
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.5);
        }

        .sidebar.active {
            left: 0;
            /* Button click par show hoga */
        }


        /* Mobile par form full width lega */
        .container {
            margin-left: 0;
        }
    }
    </style>
</head>

<body>
    
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container-fluid">

            <button class="btn btn-dark d-md-none me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="../index.php">Student Dashboard</a>

            <span class="text-white welcome-text d-none d-lg-block"
                style="font-weight:bold; position: absolute; left: 50%; transform: translateX(-50%); font-size:20px;">
                <?php echo "Welcome $student_name"; ?>
            </span>

            <div class="ms-auto d-flex align-items-center">




                <span class="me-3 text-white d-none d-sm-inline">
                    <?php echo " $student_name"; ?>
                </span>

                <div class="dropdown">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $profile_img; ?>" alt="image" width="40" height="40"
                            class="rounded-circle border border-2 border-secondary">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small  shadow"
                        aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="change_password.php">
                                <i class="fas fa-lock me-2"></i> Forgot Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger " href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="sidebar animate__animated animate__fadeInLeft ">

        <a href="dashboard.php" ><i class="bi bi-speedometer2 me-2"></i></i>Dashboard</a>
        <a href="view_attendance.php" ><i class="fas fa-calendar-check me-2"></i>Attendance</a>
        <!-- <a href="#"><i class="fas fa-file-alt me-2"></i>Reports</a> -->
        <a href="view_holidays.php" ><i class=" fa-solid fa-bell me-2"></i>Holiday</a>
        <a href="profile.php" ><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php" class="active"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="container mx-center  mt-5">

        <div class="id-card-container">
            <div class="shape-top-left"></div>
            <div class="shape-top-left-dark"></div>
            <div class="shape-top-right"></div>

            <div class="card-header-section">
                <div class="logo-shield">
                    <img src="../assets/images/gpa.png" width="90px" alt="">
                </div>
                <div style="padding-left: 60px;">
                    <h2 class="university-name">Government Polytechnic Atraulia</h2>
                    <h5 class="university-addresss">Azamgarh, Uttar Pradesh </h5>
                    <p class="university-address">Approved by AICTE New Delhi and Affiliated to B.T.E. Lucknow</p>
                </div>
                <hr>
            </div>


            <div class="row g-0">
                <div class="col-md-5 col-5">
                    <div class="photo-section">
                        <img src="../uploads/id_cards/student_photos/<?php echo $data['student_photo']; ?>" width="90"
                            height="100">
                    </div>


                </div>

                <div class="col-md-7 col-7  position-relative">
                    <div class="student-card-title">
                        STUDENT CARD
                    </div>

                    <div class="text">
                        <table class="details-table ">
                            <tr>

                                <td>
                                    <b>Enrollment No:</b> <?php echo $data['roll_number']; ?><br>

                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <b>Name:</b> <?php echo $data['student_name']; ?><br>

                                </td>

                            </tr>
                            <tr>

                                <td>
                                    <b>Father:</b> <?php echo $data['father_name']; ?><br>

                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <b>DOB:</b> <?php echo $data['dob']; ?><br>

                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <b>Branch:</b> <?php echo $data['branch']; ?><br>

                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <b>Year: </b><?php echo $data['year']; ?><br>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Mobile No:</b> <?php echo $data['mobile']; ?>

                                </td>
                            </tr>
                        </table>
                    </div>


                </div>
                <div class="row ">
                    <div class="col-sm-6 text-end collage-mohar">

                        <img src="../uploads/id_cards/mohar/<?php echo $data['college_mohar']; ?>" width="150"><br>
                    </div>
                    <div class="col-sm-3  principal-singnature">
                        <img src="../uploads/id_cards/principal_signatures/<?php echo $data['principal_signature']; ?>"
                            width="180">
                        <p class="text-center sing">Principal Singnature</p>

                    </div>
                    <div class="col-sm-3 principal-singnature">
                        <img src="../uploads/id_cards/hod_signatures/<?php echo $data['hod_signature']; ?>" width="180">
                        <p class="text-center sing">HOD Singnature</p>

                    </div>

                </div>

            </div>

        </div>
        <button class="btn btn-primary print-btn  m-3 " onclick="window.print()">
            <i class="fas fa-print me-2"></i> Print Card
        </button>


        <!-- <a href="download_id_card.php" class="btn print-btn btn-success">Download PDF</a> -->
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <!-- <script>
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Bahar click karne par sidebar band karne ke liye
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    </script> -->

</body>

</html>