<?php
include("../config/database.php");
session_start();

// Delete Logic
if(isset($_GET['delete'])){
    $id=$_GET['delete'];
    $get=mysqli_query($conn,"SELECT image FROM gallery WHERE id='$id'");
    $data=mysqli_fetch_assoc($get);
    
    if($data){
        unlink("../updates/gallery/".$data['image']);
        mysqli_query($conn,"DELETE FROM gallery WHERE id='$id'");
        $_SESSION['delete_msg'] = "Image deleted successfully!";
    }
    header("Location: manage_gallery.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


// Flash Message handle
$msg = "";
if(isset($_SESSION['delete_msg'])){
    $msg = $_SESSION['delete_msg'];
    unset($_SESSION['delete_msg']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery | Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-bg: rgba(255, 255, 255, 0.05);
        --glass-border: rgba(255, 255, 255, 0.1);
        --danger-grad: linear-gradient(135deg, #ff6b6b, #ee5253);
        --warning-grad: linear-gradient(135deg, #feca57, #ff9f43);
    }

    body {
        /* background: #0f172a; */
        background-color: var(--bg-dark);
        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        padding: 30px 0;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
    }

    .btn-add {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(118, 75, 162, 0.4);
        color: white;
    }

    /* Table Styling */
    .custom-table {
        color: #f8fafc !important;
        vertical-align: middle;
    }

    .custom-table thead th {
        background: rgba(255, 255, 255, 0.05);
        border-bottom: 2px solid var(--glass-border);
        color: #94a3b8;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        padding: 15px;
    }

    .custom-table tbody td {
        padding: 15px;
        border-bottom: 1px solid var(--glass-border);
    }

    .gallery-img-preview {
        width: 80px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid var(--glass-border);
    }

    .action-btn {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-right: 5px;
        transition: 0.3s;
        border: none;
    }

    .btn-edit {
        background: var(--warning-grad);
        color: white;
    }

    .btn-del {
        background: var(--danger-grad);
        color: white;
    }

    .action-btn:hover {
        transform: scale(1.1);
        color: white;
    }

    /* Top Alert */
    .alert-top {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        min-width: 300px;
        border: none;
        border-radius: 12px;
        background: #ef4444;
        /* Red for delete */
        color: white;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }

    /* @media (max-width: 768px) {
        .custom-table thead {
            display: none;
        }

        .custom-table tbody td {
            display: block;
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

        .custom-table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: 600;
            color: #94a3b8;
        }
    } */
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

    <?php if($msg != ""){ ?>
    <div class="alert alert-top alert-dismissible fade show text-center" role="alert">
        <i class="fas fa-trash-alt me-2"></i> <?php echo $msg; ?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
    </div>
    <?php } ?>

    <div class="main-content px-lg-5">
        <div class="glass-card">
            <div class="header-flex">
                <div>
                    <h3 class="fw-bold mb-0"><i class="fas fa-photo-video me-2 text-info"></i>Manage Gallery</h3>
                    <p class="text-muted small mb-0">Edit or remove images from the college gallery</p>
                </div>
                <a href="add_gallery.php" class="btn btn-add">
                    <i class="fas fa-plus-circle me-2"></i>Add New Image
                </a>
            </div>

            <div class="table-responsive rounded">
                <table class="table custom-table ">
                    <thead>
                        <tr>
                            <th><i class="fas fa-image me-2"></i>Image</th>
                            <th><i class="fas fa-heading me-2"></i>Title</th>
                            <th><i class="fas fa-align-left me-2"></i>Description</th>
                            <th class="text-center"><i class="fas fa-tools me-2"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($q)){
                        ?>
                        <tr>
                            <td data-label="Image">
                                <img src="../updates/gallery/<?php echo $row['image']; ?>"
                                    class="gallery-img-preview shadow-sm">
                            </td>
                            <td data-label="Title" class="fw-semibold"><?php echo $row['title']; ?></td>
                            <td data-label="Description" class="text-muted small"><?php echo $row['description']; ?>
                            </td>
                            <td data-label="Action" class="text-center">
                                <!-- <a href="edit_gallery.php?id=<?php echo $row['id']; ?>" class="action-btn btn-edit shadow-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a> -->
                                <a href="?delete=<?php echo $row['id']; ?>" class="action-btn btn-del shadow-sm"
                                    title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Alert auto-hide after 3 seconds
    setTimeout(function() {
        let alert = document.querySelector('.alert-top');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 3000);
    </script>
</body>

</html>