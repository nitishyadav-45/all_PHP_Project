<?php
session_start();
include("../config/database.php");

// Admin session check
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


// URL se ID get karna (example: view_id_card.php?id=5)
if(!isset($_GET['id']) || empty($_GET['id'])){
    echo '<div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin: 20px auto; max-width: 400px; border-radius: 8px; font-family: Arial, sans-serif; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <strong>Error:</strong> Invalid Request! ID is missing.
          </div>';
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Admin ke liye query - ID ke base par data fetch kar rahe hain
$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests WHERE id='$id'"
);

$data = mysqli_fetch_assoc($query);

if(!$data){
    echo '<div style="background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; margin: 20px auto; max-width: 400px; border-radius: 8px; font-family: Arial, sans-serif; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
            <span style="font-size: 20px; vertical-align: middle; margin-right: 8px;">⏳</span>
            <strong>Notice:</strong> ID Card data not found.
          </div>'; 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student ID Card - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Roboto:wght@400;700&family=Libre+Barcode+39+Text&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    /* Base Settings to ensure printing with colors */
    @media print {

        .navbar,
        .sidebar,
        .print-btn,
        .back-btn,
        #menu-toggle,
        .dropdown {
            display: none !important;
        }

        /* Main content ki margin aur padding reset karein taki card page ke beech mein aaye */
        .main-content {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            position: static !important;
        }

        body {

            /* -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            background-color: white !important; */
            background-color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* .id-card-container {
            box-shadow: none !important;
            margin: 0 auto !important;
            page-break-inside: avoid;
        } */

        .id-card-container {
            box-shadow: none !important;
            border: 1px solid #ccc !important;
            /* Printing ke liye halka border */
            margin: 20px auto !important;
            page-break-inside: avoid;
        }

        /* Hide unnecessary UI elements during print if needed */
        .print-btn,
        .back-btn {
            display: none !important;
        }

    }

    body {
        /* background-color: #f4f6f9; */
        background-color: var(--bg-dark);

        font-family: 'Roboto', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding: 20px;
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
        vertical-align: top;
    }

    .text {
        margin-left: 50px;
    }

    /* Utility */
    .text-navy {
        color: #233261 !important;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-dark fixed-top px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-light me-3 d-lg-none border-0" id="menu-toggle"><i
                    class="fas fa-bars"></i></button>
            <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
        </div>

        <span class="welcome-text d-none d-lg-block position-absolute start-50 translate-middle-x fs-5">
            Welcome, <?php echo htmlspecialchars($admin['full_name']); ?>
            <button class="btn  print-btn" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Print Card
            </button>
        </span>


        <div class="d-flex align-items-center">
            <span class="text-white me-3 d-none d-md-block" style="font-size: 0.9rem; opacity: 0.8;">
                <?php echo htmlspecialchars($admin['email']); ?>
            </span>

            <div class="dropdown">
                <a href="#" class="d-block text-decoration-none dropdown-toggle-no-caret" id="dropdownUser"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="uploads/admin/<?php echo $admin['profile_image'] ?? 'default.png'; ?>" class="profile-img"
                        alt="Profile">
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow mt-2"
                    aria-labelledby="dropdownUser">
                    <li>
                        <span class="dropdown-header text-info d-md-none">
                            <?php echo htmlspecialchars($admin['full_name']); ?></span>
                    </li>

                    <li><a class="dropdown-item text-light" href="profile.php"><i class="fas fa-user-circle me-2"></i>
                            My Profile</a></li>
                    <li><a class="dropdown-item text-light" href="change_password.php"><i class="fas fa-key me-2"></i>
                            Change Password</a></li>
                    <li>
                        <hr class="dropdown-divider border-secondary">
                    </li>
                    <li><a class="dropdown-item text-danger" href="../auth/logout.php"><i
                                class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
        <a href="manage_students.php"><i class="fa fa-users"></i> Students</a>
        <a href="manage_teachers.php"><i class="fa fa-chalkboard-teacher"></i> Teachers</a>
        <a href="attendance_reports.php"><i class="fa fa-calendar-check"></i> Attendance</a>
        <a href="attendance_reports.php"><i class="fa fa-file-pdf"></i> Reports</a>
        <a href="profile.php"><i class="fa fa-id-badge"></i> Profile</a>
        <a href="change_password.php"><i class="fa-solid fa-unlock"></i> Password</a>
        <hr class="border-info border-2">
        <a class="dropdown-item text-danger" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>
            Logout</a>

    </div>


    <div class="main-content mt-5">
        <!-- <div class="position-absolute top-0 end-0 m-3 d-flex gap-2">
            <a href="javascript:history.back()" class="btn btn-secondary back-btn">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
            <button class="btn btn-primary print-btn" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Print Card
            </button>
        </div> -->

        <div class="id-card-container ">
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
                                    <b>Academic Year: </b><?php echo $data['year']; ?><br>
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

                <div class="row w-100 m-0">
                    <div class="col-sm-6 text-end collage-mohar">
                        <?php if(!empty($data['college_mohar'])) { ?>
                        <img src="../uploads/id_cards/mohar/<?php echo $data['college_mohar']; ?>" width="150"><br>
                        <?php } ?>
                    </div>
                    <div class="col-sm-3 principal-singnature">
                        <?php if(!empty($data['principal_signature'])) { ?>
                        <img src="../uploads/id_cards/principal_signatures/<?php echo $data['principal_signature']; ?>"
                            width="180">
                        <?php } ?>
                        <p class="text-center sing">Principal Signature</p>
                    </div>
                    <div class="col-sm-3 principal-singnature">
                        <?php if(!empty($data['hod_signature'])) { ?>
                        <img src="../uploads/id_cards/hod_signatures/<?php echo $data['hod_signature']; ?>" width="180">
                        <?php } ?>
                        <p class="text-center sing">HOD Signature</p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>