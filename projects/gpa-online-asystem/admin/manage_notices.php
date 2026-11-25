<?php
session_start();
include("../config/database.php");
$query = mysqli_query($conn,"SELECT * FROM notices ORDER BY notice_date DESC");


$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));

?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Notices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    
        body {
        /* background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); */
        background-color: var(--bg-dark);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
    }
    /* Isse message top par fix ho jayega */
    .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        min-width: 300px;
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

        <?php if(isset($_SESSION['status'])): ?>
        <div class="alert alert-<?php echo $_SESSION['status_code']; ?> alert-dismissible fade show shadow"
            role="alert">
            <strong><i class="fas fa-info-circle me-2"></i></strong> <?php echo $_SESSION['status']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['status']); unset($_SESSION['status_code']); ?>
        <?php endif; ?>

        <h3 class="mb-4 text-center text-light"><i class="fas fa-bullhorn text-warning"></i> Manage Notices</h3>

        <div class="d-flex justify-content-between mb-3">
            <a href="add_notice.php" class="btn btn-success"><i class="fa fa-plus"></i> Add New Notice</a>
            
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)){ ?>
                    <tr>
                        
                        <td class="text-info"><?php echo $row['title']; ?></td>
                        <td><?php echo substr($row['description'], 0, 60); ?>...</td>
                        <td><?php echo date('d-M-Y', strtotime($row['notice_date'])); ?></td>
                        <td class="text-center">
                            <a href="edit_notice.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="delete_notice.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                               >
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    
    <script>
    // Message 3 second baad apne aap gayab ho jayega
    setTimeout(function() {
        let alert = document.querySelector('.alert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
    </script>
</body>

</html>