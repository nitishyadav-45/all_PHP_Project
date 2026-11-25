<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']); // Security fix: Escape ID
$message = "";

// Data Fetching
$q = mysqli_query($conn,"SELECT * FROM id_card_requests WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


if(isset($_POST['update'])){
    $name   = mysqli_real_escape_string($conn,$_POST['student_name']);
    $father = mysqli_real_escape_string($conn,$_POST['father_name']);
    $branch = mysqli_real_escape_string($conn,$_POST['branch']);
    $year   = mysqli_real_escape_string($conn,$_POST['year']);
    $mobile = mysqli_real_escape_string($conn,$_POST['mobile']);

    $update = "UPDATE id_card_requests SET
                student_name='$name',
                father_name='$father',
                branch='$branch',
                year='$year',
                mobile='$mobile'
               WHERE id='$id'";

    if(mysqli_query($conn,$update)){
        $message = "ID Card Updated Successfully!";
        header("refresh:2;url=manage_id_cards.php");
    }else{
        $message = "Update Failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit ID Card | Admin Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body {
            background: #121212; 
            /* background-image: radial-gradient(circle at 20% 30%, #1e293b 0%, #121212 100%); */
             background-color: var(--bg-dark);

            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            color: white;
            transition: transform 0.3s ease;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff !important;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25 row rgba(13, 110, 253, 0.25);
        }
        .btn-update {
            background: linear-gradient(45deg, #198754, #20c997);
            border: none;
            font-weight: 600;
            padding: 12px;
        }
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 135, 84, 0.4);
        }
        .floating-label label {
            color: #adb5bd;
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

    <div class="main-content">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card main-card p-4 p-md-5 shadow-lg">
                    <div class="text-center ">
                        <div class="bg-primary d-inline-block p-3 rounded-circle mb-3">
                            <i class="fas fa-user-edit fa-2x"></i>
                        </div>
                        <h2 class="fw-bold">Edit ID Card</h2>
                        <p class="text-secondary">Update student information below</p>
                    </div>

                    <?php if($message != ""){ ?>
                    <div class="alert alert-info border-0 shadow-sm text-center">
                        <i class="fas fa-check-circle me-2"></i> <?php echo $message; ?>
                    </div>
                    <?php } ?>

                    <form method="POST">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-secondary">Student Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-secondary border-secondary"><i class="fas fa-user"></i></span>
                                    <input type="text" name="student_name" value="<?php echo $data['student_name']; ?>" class="form-control" placeholder="Enter Full Name" required>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-secondary">Father's Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-secondary border-secondary"><i class="fas fa-users"></i></span>
                                    <input type="text" name="father_name" value="<?php echo $data['father_name']; ?>" class="form-control" placeholder="Father's Name" required>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-secondary">Branch</label>
                                <input type="text" name="branch" value="<?php echo $data['branch']; ?>" class="form-control" placeholder="e.g. CSE" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-uppercase fw-bold text-secondary">Year</label>
                                <input type="text" name="year" value="<?php echo $data['year']; ?>" class="form-control" placeholder="e.g. 2024" required>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label small text-uppercase fw-bold text-secondary">Mobile Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent text-secondary border-secondary"><i class="fas fa-phone"></i></span>
                                    <input type="text" name="mobile" value="<?php echo $data['mobile']; ?>" class="form-control" placeholder="10 Digit Number" required>
                                </div>
                            </div>

                            <div class="col-12 d-grid gap-2">
                                <button type="submit" name="update" class="btn btn-update text-white rounded-3">
                                    <i class="fas fa-save me-2"></i> Update Record
                                </button>
                                <a href="manage_id_cards.php" class="btn btn-outline-secondary border-0 mt-2">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>