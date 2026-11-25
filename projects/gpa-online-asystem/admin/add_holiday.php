<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


$msg = "";

if(isset($_POST['add_holiday'])){
    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $date  = $_POST['holiday_date'];
    $reason = mysqli_real_escape_string($conn,$_POST['reason']);

    $insert = mysqli_query($conn,"INSERT INTO holidays (title, holiday_date, reason) 
                                  VALUES ('$title','$date','$reason')");

    if($insert){
        $msg = "<div class='alert alert-success border-0 shadow-sm animate__animated animate__fadeIn'>
                    <i class='fas fa-check-circle me-2'></i> Holiday Added Successfully 🎉
                </div>";
    } else {
        $msg = "<div class='alert alert-danger border-0 shadow-sm'>
                    <i class='fas fa-exclamation-triangle me-2'></i> Error adding holiday
                </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declare Holiday | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    body {

        color: #333;
        background-color: var(--bg-dark);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
    }

    .card {
        background:#1e293b;
        color:white;
        border: none;
        border-radius: 15px;
    }

    .form-control {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25 margin rgba(13, 110, 253, 0.15);
        border-color: #0d6efd;
    }

    .btn-primary {
        padding: 12px;
        border-radius: 8px;
        font-weight: 600;
        background: linear-gradient(45deg, #0d6efd, #0b5ed7);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }

    .icon-box {
        width: 60px;
        height: 60px;
        background: #e7f1ff;
        color: #0d6efd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 24px;
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
        color: light;
    }

    .input-group-text {
        background-color: #0f172a;
        border-right: none;
        color: #6c757d;
    }

    .form-control {
        border-left: none;
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
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 ">

                <div class="card shadow-lg p-4 mb-4">
                    <div class="icon-box">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h3 class="text-center fw-bold ">Declare Holiday</h3>

                    <?php echo $msg; ?>
                    <hr>

                    <form method="POST">
                        <div class="mb-3">
                            <label>Holiday Title</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" name="title" class="form-control" placeholder="e.g. Diwali Festival"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Select Date</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                <input type="date" name="holiday_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label>Reason / Description</label>
                            <div class="input-group">
                                <span class="input-group-text  pt-2"><i
                                        class="fas fa-pen-nib"></i></span>
                                <textarea name="reason" class="form-control" rows="3" placeholder="Write reason here..."
                                    required></textarea>
                            </div>
                        </div>

                        <button type="submit" name="add_holiday" class="btn btn-primary w-100 shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i> Add Holiday Now
                        </button>
                    </form>

                    <hr class="my-4">

                    
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>