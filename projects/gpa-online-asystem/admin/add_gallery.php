<?php
include("../config/database.php");

// Session start karna zaroori hai notification message dikhane ke liye redirect ke baad
session_start();

if(isset($_POST['upload'])){

    $title = $_POST['title'];
    $description = $_POST['description'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    // Duplicate rokne ke liye hum check kar sakte hain ya redirect use kar sakte hain
    if(move_uploaded_file($tmp,"../updates/gallery/".$image)){
        
        mysqli_query($conn,"INSERT INTO gallery(title,description,image,upload_date)
        VALUES('$title','$description','$image',NOW())");

        // Message ko session mein save karenge taaki redirect ke baad dikhe
        $_SESSION['msg'] = "Image Uploaded Successfully!";
    }

    // Form submit hone ke baad isi page par redirect karein (PRG Pattern)
    // Isse refresh karne par data dubara submit nahi hoga
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


// Display message and then clear it
$msg = "";
if(isset($_SESSION['msg'])){
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Gallery | Premium Admin</title>

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
    }

    body {
        /* background: #0f172a; */
        background-color: var(--bg-dark);

        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 20px;
    }

    .upload-container {
        width: 100%;
        max-width: 600px;
        animation: fadeIn 0.8s ease-in-out;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .header-icon {
        font-size: 3rem;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
    }

    .form-label {
        color: #94a3b8;
        font-weight: 500;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        background: rgba(15, 23, 42, 0.6) !important;
        border: 1px solid var(--glass-border) !important;
        color: #fff !important;
        padding: 12px 16px;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        border-color: #667eea !important;
        outline: none;
    }

    .btn-upload {
        background: var(--primary-gradient);
        border: none;
        padding: 14px;
        font-weight: 600;
        border-radius: 12px;
        width: 100%;
        margin-top: 10px;
        color: white;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(118, 75, 162, 0.5);
    }

    .alert-floating {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        min-width: 300px;
        border-radius: 12px;
        background: #10b981;
        color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
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

    <?php if($msg!=""){ ?>
    <div class="alert alert-floating alert-dismissible fade show text-center" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?php echo $msg; ?>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php } ?>

    <div class="upload-container main-content">
        <div class="glass-card text-center">
            <i class="fas fa-cloud-upload-alt header-icon"></i>
            <h3 class="fw-bold mb-2">Add Gallery Image</h3>
            <p class="text-light mb-4">Upload a new moment to the college gallery</p>

            <form method="POST" enctype="multipart/form-data" class="text-start">
                <div class="mb-3">
                    <label class="form-label">Image Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter a catchy title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"
                        placeholder="Tell something about this photo..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Select Image File</label>
                    <input type="file" name="image" class="form-control" required>
                </div>
                <button name="upload" class="btn btn-upload">
                    <i class="fas fa-upload"></i> Upload to Gallery
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    
    <script>
    setTimeout(function() {
        let alert = document.querySelector('.alert-floating');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 4000);
    </script>
</body>

</html>