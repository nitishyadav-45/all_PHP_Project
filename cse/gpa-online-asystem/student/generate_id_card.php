<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_name = $_SESSION['student_name'];


$student_id = $_SESSION['student_id'];
$student_branch = $_SESSION['branch']; // login ke time set hona chahiye

$message = "";
$form_already_submitted = false;

/* ------------------------------
   Duplicate Request Check
--------------------------------*/
// Sirf student_id check kar rahe hain, status nahi.
$check_query = mysqli_query($conn,
    "SELECT * FROM id_card_requests WHERE student_id='$student_id'"
);

if(mysqli_num_rows($check_query) > 0){
    $form_already_submitted = true;
    $row = mysqli_fetch_assoc($check_query);
    // Agar aapke database mein 'status' column hai, toh current status show karega
    $current_status = isset($row['status']) ? $row['status'] : 'Pending';
    $message = "You have already submitted an ID card request. Current Status: <strong class='text-warning'>$current_status</strong>";
}

/* ------------------------------
   Fetch Teachers of Same Branch
--------------------------------*/
$teachers = mysqli_query($conn,
    "SELECT * FROM teachers WHERE branch='$student_branch'"
);

/* ------------------------------
   Form Submit
--------------------------------*/
if(isset($_POST['submit']) && !$form_already_submitted){

    $student_name = mysqli_real_escape_string($conn,$_POST['student_name']);
    $father_name = mysqli_real_escape_string($conn,$_POST['father_name']);
    $dob          = $_POST['dob'];
    $roll_number  = mysqli_real_escape_string($conn,$_POST['roll_number']);
    $branch       = mysqli_real_escape_string($conn,$_POST['branch']);
    $year         = mysqli_real_escape_string($conn,$_POST['year']);
    $mobile       = mysqli_real_escape_string($conn,$_POST['mobile']);
    $teacher_id   = $_POST['teacher_id'];

    // Image Upload
    $photo = $_FILES['student_photo']['name'];
    $tmp   = $_FILES['student_photo']['tmp_name'];
    $size  = $_FILES['student_photo']['size'];

    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    if(in_array($ext,$allowed) && $size <= 2000000){

        $new_name = time().rand(1000,9999).".".$ext;
        $upload_path = "../uploads/id_cards/student_photos/".$new_name;

        if(move_uploaded_file($tmp,$upload_path)){

            $insert = "INSERT INTO id_card_requests 
            (student_id, teacher_id, student_photo, student_name, father_name, dob, roll_number, branch, year, mobile)
            VALUES  
            ('$student_id','$teacher_id','$new_name','$student_name','$father_name','$dob','$roll_number','$branch','$year','$mobile')";

            if(mysqli_query($conn,$insert)){
                $message = "ID Card Request Submitted Successfully! Waiting for Teacher Approval.";
                $form_already_submitted = true; // Submit hone ke baad form hide karne ke liye
            }else{
                $message = "Database Error!";
            }

        }else{
            $message = "Image Upload Failed!";
        }

    }else{
        $message = "Invalid Image! Only JPG/PNG under 2MB allowed.";
    }
}


// Profile Image
$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate ID Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    /* Modern Dark Theme Background */
    body {
        /* background: linear-gradient(135deg, #111827 0%, #1f2937 100%); */
        color: #f3f4f6;
        min-height: 100vh;
        /* display: flex; */
        /* align-items: center; */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }



    /* Glassmorphism Card Style */
    .glass-card {
        /* background: rgba(31, 41, 55, 0.7); */
        background: #212529;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        padding: 2.5rem;
    }

    /* Title Styling */
    .card-title-custom {
        font-weight: 700;
        letter-spacing: 1px;
        color: #ffcc;
        text-transform: uppercase;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Form Controls Styling */
    label {
        font-size: 1rem;
        font-weight: 500;
        color: #ffff;
        margin-bottom: 0.4rem;
    }


    .form-control,
    .form-select {
        /* background-color: rgba(17, 24, 39, 0.8); */
        background-color: rgba(243, 243, 243, 0.3);
        border: 1px solid #374151;
        color: #f3f4f6;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    /* Fix for select dropdown options in dark mode */
    .form-select option {
        background-color: #1f2937;
        color: #f3f4f6;
    }

    .form-control:focus,
    .form-select:focus {
        /* background-color: rgba(17, 24, 39, 1); */
        background-color: #6c757d;
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        color: #ffffff;
    }

    .form-control[readonly] {
        background-color: rgba(55, 65, 81, 0.5);
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Custom Input File Styling */
    input[type="file"]::file-selector-button {
        background-color: #374151;
        color: white;
        border: none;
        padding: 0.3rem 1rem;
        border-radius: 5px;
        margin-right: 1rem;
        transition: all 0.3s ease;
    }

    input[type="file"]::file-selector-button:hover {
        background-color: #4b5563;
    }

    /* Glowing Button */
    .btn-warning-custom {
        background: linear-gradient(45deg, #ffc107, #ffb300);
        color: #000 !important;
        font-weight: 700;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2.5rem;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }

    .btn-warning-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.5);
        background: linear-gradient(45deg, #ffb300, #ffc107);
    }

    /* Alert Box */
    .alert-custom {
        background-color: rgba(55, 65, 81, 0.8);
        border-left: 4px solid #ffc107;
        color: #e5e7eb;
        border-radius: 10px;
    }

    .text-muted {
        color: red !important;
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

        <a href="dashboard.php"><i class="bi bi-speedometer2 me-2"></i></i>Dashboard</a>
        <a href="view_attendance.php"><i class="fas fa-calendar-check me-2"></i>Attendance</a>
        <!-- <a href="#"><i class="fas fa-file-alt me-2"></i>Reports</a> -->
        <a href="view_holidays.php"><i class=" fa-solid fa-bell me-2"></i>Holiday</a>
        <a href="profile.php"><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php "><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php " ><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php" class="active"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>
    


    <div class="main-content py-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">

                <div class="glass-card">
                    <h3 class="mb-4 text-center card-title-custom">Request ID Card</h3>

                    <?php if($message!=""){ ?>
                    <div class="alert alert-custom text-center shadow-sm">
                        <?php echo $message; ?>
                    </div>
                    <?php } ?>

                    <?php if(!$form_already_submitted){ ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Student Name</label>
                                <input type="text" name="student_name" class="form-control"
                                    placeholder="Enter full name" required>
                            </div>

                            <div class="col-md-6">
                                <label>Father's Name</label>
                                <input type="text" name="father_name" class="form-control"
                                    placeholder="Enter father's name" required>
                            </div>

                            <div class="col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Roll Number</label>
                                <input type="text" name="roll_number" class="form-control"
                                    placeholder="e.g. E0812CS21..." required>
                            </div>

                            <div class="col-md-6">
                                <label>Branch</label>
                                <input type="text" name="branch" class="form-control"
                                    value="<?php echo htmlspecialchars($student_branch); ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label>Session / Year</label>
                                <input type="text" name="year" placeholder="e.g. 2023-2026" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label>Mobile Number</label>
                                <input type="tel" name="mobile" class="form-control" placeholder="10-digit number"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label>Select Teacher (<?php echo htmlspecialchars($student_branch); ?>)</label>
                                <select name="teacher_id" class="form-select" required>
                                    <option value="" selected disabled>-- Choose a Teacher --</option>
                                    <?php while($t = mysqli_fetch_assoc($teachers)){ ?>
                                    <option value="<?php echo $t['id']; ?>">
                                        <?php echo htmlspecialchars($t['full_name']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-12 mt-4">
                                <label>Passport Size Photo</label>
                                <input type="file" name="student_photo" class="form-control" accept=".jpg, .jpeg, .png"
                                    required>
                                <small class="text-muted  mt-1 d-block"><i class="text-warning">*</i> Only JPG/PNG
                                    under
                                    2MB are allowed.</small>
                            </div>

                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" name="submit" class="btn btn-warning-custom px-5 w-100 w-md-auto">
                                Submit Request
                            </button>
                        </div>

                    </form>

                    <?php } ?>

                </div>
            </div>
        </div>
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