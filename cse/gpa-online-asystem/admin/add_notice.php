<?php
session_start();
include("../config/database.php");

if(isset($_POST['submit'])){
    // SQL Injection se bachne ke liye real_escape_string use karein
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = $_POST['date'];

    $result = mysqli_query($conn, "INSERT INTO notices(title,description,notice_date) 
               VALUES('$title','$description','$date')");

    if($result) {
        $_SESSION['status'] = "Notice successfully published!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Something went wrong!";
        $_SESSION['status_code'] = "danger";
    }

    header("Location: add_notice.php");
    exit();
}


$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Notice | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
    body {
        background-color: var(--bg-dark);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
    }

    .notification-box {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
    }
    .card{
        background:#1e293b;

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

    <div class="notification-box">
        <?php
        if(isset($_SESSION['status'])) {
        ?>
        <div class="alert alert-<?php echo $_SESSION['status_code']; ?> alert-dismissible fade show shadow"
            role="alert">
            <i
                class="fas <?php echo ($_SESSION['status_code'] == 'success') ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
            <?php echo $_SESSION['status']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
        unset($_SESSION['status']);
        unset($_SESSION['status_code']);
    }
    ?>
    </div>

    <div class="main-content mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card p-4 text-light border-0 shadow-lg">
                    <h3 class="mb-4 text-center"><i class="fas fa-bullhorn me-2"></i>Add New Notice</h3>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Notice Title</label>
                            <input type="text" name="title" placeholder="Enter notice title"
                                class="form-control bg-dark text-white border-secondary" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notice Description</label>
                            <textarea name="description" placeholder="Write notice details..."
                                class="form-control bg-dark text-white border-secondary" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notice Date</label>
                            <input type="date" name="date" class="form-control bg-dark text-white border-secondary"
                                required>
                        </div>

                        <div class="d-grid">
                            <button name="submit" class="btn btn-success fw-bold py-2">
                                <i class="fas fa-paper-plane me-2"></i>Publish Notice
                            </button>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    <script>
    // 4 second baad notification box ko apne aap band karne ke liye
    setTimeout(function() {
        let alert = document.querySelector('.alert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 4000);
    </script>

</body>

</html>