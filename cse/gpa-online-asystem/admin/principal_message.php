<?php
session_start();

include("../config/database.php");

$msg = "";

if (isset($_POST['publish'])) {
    // Security Tip: Real-world mein hamesha mysqli_real_escape_string use karein
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO principal_messages(title, message, created_at) VALUES('$title', '$message', NOW())";
    
    if (mysqli_query($conn, $query)) {
        $msg = "Message Published Successfully!";
    }
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal Desk | Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    body {
        /* background-color: #f4f7f6; */
        background-color: var(--bg-dark);

        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .main-card {
    
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        /* background: linear-gradient(45deg, #1e3c72, #2a5298); */
        background:#1e293b;
        color: white;
        padding: 2rem;
        /* text-align: center; */
        /* border: none; */
        border-bottom: 5px solid #1cc88a;

    }

    .form-control:focus {
        border-color: #2a5298;
        box-shadow: 0 0 0 0.25 darkred;
        box-shadow: 0 0 8px rgba(42, 82, 152, 0.25);
    }

    .btn-publish {
        background:#1e293b;
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-publish:hover {
        background: #0f1729;
        border: 3px solid #1cc88a;
        transform: translateY(-2px);
    }

    .input-group-text {
        background-color: #f8f9fa;
    }

    .btn-add {
        background: #1cc88a;
        border: none;
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-add:hover {
        background: #17a673;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.4);
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

    <div class="main-content py-5">
        <div class="row justify-content-center">
            <div class="col-lg-11 mx-auto">

                <?php if($msg != ""){ ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?php echo $msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php } ?>

                <div class="card main-card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="fw-bold"> <i class="fas fa-pen-nib fa-1x mb-3"></i> Principal's Desk</h2>
                            <p class="mb-0 opacity-75">Compose and publish a new message for the students</p>
                        </div>
                        <a href="manage_principal_message.php" class="btn btn-light btn-add text-white px-4 mt-3">
                            <i class="fas fa-plus-circle me-1"></i> Manage Message
                        </a>
                    </div>

                    <div class="card-body p-4 p-md-5 bg-white">
                        <form method="POST" action="">

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Message Title</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-heading text-muted"></i></span>
                                    <input type="text" name="title" class="form-control form-control-lg"
                                        placeholder="e.g. Welcome Note 2026" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Your Message</label>
                                <textarea name="message" class="form-control" rows="8"
                                    placeholder="Write your inspiring message here..." required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="publish" class="btn btn-primary btn-publish btn-lg shadow">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Message
                                </button>
                            </div>

                        </form>
                    </div>

                    <div class="card-footer bg-light py-3 text-center border-0">
                        <small class="text-muted small">The message will be visible on the college homepage
                            immediately.</small>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="dashboard.php" class="text-decoration-none text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>