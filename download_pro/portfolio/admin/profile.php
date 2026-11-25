<?php
require_once '../config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../admin_login.php');
}

$user = getUserData();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $title = sanitize($_POST['title'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $about_short = sanitize($_POST['about_short'] ?? '');
    $about_long = sanitize($_POST['about_long'] ?? '');
    $location = sanitize($_POST['location'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $working_hours = sanitize($_POST['working_hours'] ?? '');
    $projects_done = (int)($_POST['projects_done'] ?? 0);
    $happy_clients = (int)($_POST['happy_clients'] ?? 0);
    $years_experience = (int)($_POST['years_experience'] ?? 0);
    $facebook_link = sanitize($_POST['facebook_link'] ?? '');
    $twitter_link = sanitize($_POST['twitter_link'] ?? '');
    $instagram_link = sanitize($_POST['instagram_link'] ?? '');
    $linkedin_link = sanitize($_POST['linkedin_link'] ?? '');
    $github_link = sanitize($_POST['github_link'] ?? '');
    
    $user_id = $_SESSION['user_id'];
    $upload_dir = "../uploads/";

    // Ensure the upload directory exists
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 1. Profile Image Upload Handler
    $profile_image = $user['profile_image'] ?? ''; 
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_profile_name = "profile_" . time() . "." . $file_ext;
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $new_profile_name)) {
                // Delete older image file from server storage if exists
                if (!empty($user['profile_image']) && file_exists($upload_dir . $user['profile_image'])) {
                    unlink($upload_dir . $user['profile_image']);
                }
                $profile_image = $new_profile_name;
            }
        } else {
            $error = 'Invalid extension for profile image. Allowed types: JPG, PNG, WEBP.';
        }
    }

    // 2. About Image Upload Handler
    $about_image = $user['about_image'] ?? '';
    if (empty($error) && isset($_FILES['about_image']) && $_FILES['about_image']['error'] === UPLOAD_ERR_OK) {
        $file_ext = strtolower(pathinfo($_FILES['about_image']['name'], PATHINFO_EXTENSION));
        if (in_array($file_ext, ['jpg', 'jpeg', 'png', 'webp'])) {
            $new_about_name = "about_" . time() . "." . $file_ext;
            if (move_uploaded_file($_FILES['about_image']['tmp_name'], $upload_dir . $new_about_name)) {
                // Delete older about image file from server storage if exists
                if (!empty($user['about_image']) && file_exists($upload_dir . $user['about_image'])) {
                    unlink($upload_dir . $user['about_image']);
                }
                $about_image = $new_about_name;
            }
        } else {
            $error = 'Invalid extension for about image. Allowed types: JPG, PNG, WEBP.';
        }
    }

    // Database Update Command Execution Point
    if (empty($error)) {
        $query = "UPDATE users SET 
                  name = '$name',
                  email = '$email',
                  title = '$title',
                  description = '$description',
                  about_content_short = '$about_short',
                  about_content_long = '$about_long',
                  location = '$location',
                  phone = '$phone',
                  working_hours = '$working_hours',
                  projects_done = $projects_done,
                  happy_clients = $happy_clients,
                  years_experience = $years_experience,
                  facebook_link = '$facebook_link',
                  twitter_link = '$twitter_link',
                  instagram_link = '$instagram_link',
                  linkedin_link = '$linkedin_link',
                  github_link = '$github_link',
                  profile_image = '$profile_image',
                  about_image = '$about_image'
                  WHERE id = $user_id";
        
        if ($conn->query($query) === TRUE) {
            $success = 'Profile updated successfully!';
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $user = getUserData();
        } else {
            $error = 'Database Error: ' . $conn->error;
        }
    }
}

// Preview Thumbnails Logic
$user_avatar = (!empty($user['profile_image']) && file_exists('../uploads/' . $user['profile_image'])) 
    ? '../uploads/' . $user['profile_image'] 
    : 'https://via.placeholder.com/150';

$about_avatar = (!empty($user['about_image']) && file_exists('../uploads/' . $user['about_image'])) 
    ? '../uploads/' . $user['about_image'] 
    : 'https://via.placeholder.com/300x200';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            width: 100%;
        }
        
        /* Desktop Sidebar View Layout */
        .sidebar-desktop {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 25px 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            color: white;
            z-index: 1000;
        }
        
        /* Mobile Slide Sidebar Navigation */
        .offcanvas-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            width: 280px;
        }
        
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-profile {
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 25px;
        }
        
        .sidebar-profile img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        
        .sidebar-menu li a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }
        
        /* Core Content Structural Wrapper */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            transition: all 0.3s ease;
            width: calc(100% - 260px);
        }
        
        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .top-navbar h1 {
            margin: 0;
            font-size: 1.6rem;
            color: #2d3436;
            font-weight: 700;
        }
        
        .nav-profile-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .nav-profile-img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #667eea;
        }
        
        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 15px;
            min-width: 230px;
        }
        
        .content-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #2d3436;
            font-size: 0.9rem;
        }
        
        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .img-preview-wrapper {
            position: relative;
            width: 110px;
            height: 110px;
        }
        
        .img-preview-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 3px solid #667eea;
        }
        
        /* Layout Adjustment for Responsive Viewports */
        @media (max-width: 991px) {
            .sidebar-desktop {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
                width: 100%;
            }
            .top-navbar, .content-section {
                padding: 20px 15px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar-desktop">
        <div class="sidebar-brand">
            <i class="bi bi-speedometer2"></i> Admin Panel
        </div>
        <div class="sidebar-profile d-flex align-items-center gap-3">
            <img src="<?php echo $user_avatar; ?>" class="rounded-circle" alt="Avatar">
            <div>
                <h6 class="mb-0 fw-bold text-truncate" style="max-width: 140px;"><?php echo htmlspecialchars($user['name']); ?></h6>
                <small class="opacity-75">Administrator</small>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="bi bi-house"></i> Dashboard</a></li>
            <li><a href="profile.php" class="active"><i class="bi bi-person"></i> Profile</a></li>
            <li><a href="services.php"><i class="bi bi-briefcase"></i> Services</a></li>
            <li><a href="skills.php"><i class="bi bi-star"></i> Skills</a></li>
            <li><a href="projects.php"><i class="bi bi-folder"></i> Projects</a></li>
            <li><a href="testimonials.php"><i class="bi bi-chat-quote"></i> Testimonials</a></li>
            <li><a href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
            <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <div class="offcanvas offcanvas-start offcanvas-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header border-0">
            <h5 class="offcanvas-title text-white fw-bold" id="mobileSidebarLabel"><i class="bi bi-speedometer2 me-2"></i> Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body px-4">
            <div class="sidebar-profile d-flex align-items-center gap-3">
                <img src="<?php echo $user_avatar; ?>" class="rounded-circle" alt="Avatar">
                <div>
                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($user['name']); ?></h6>
                    <small class="opacity-75">Administrator</small>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php"><i class="bi bi-house"></i> Dashboard</a></li>
                <li><a href="profile.php" class="active"><i class="bi bi-person"></i> Profile</a></li>
                <li><a href="services.php"><i class="bi bi-briefcase"></i> Services</a></li>
                <li><a href="skills.php"><i class="bi bi-star"></i> Skills</a></li>
                <li><a href="projects.php"><i class="bi bi-folder"></i> Projects</a></li>
                <li><a href="testimonials.php"><i class="bi bi-chat-quote"></i> Testimonials</a></li>
                <li><a href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
                <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none text-dark fs-4 px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1>My Profile</h1>
                </div>
            </div>
            
            <div class="dropdown nav-profile-dropdown">
                <div class="dropdown-toggle d-flex align-items-center gap-2" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $user_avatar; ?>" class="nav-profile-img" alt="User Avatar">
                    <span class="d-none d-md-inline fw-semibold text-dark m-0"><?php echo htmlspecialchars($user['name']); ?> <i class="bi bi-chevron-down small text-muted ms-1"></i></span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom m-0 mt-2 shadow-lg" aria-labelledby="profileDropdown">
                    <li class="px-2 py-1 mb-2 border-bottom pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="<?php echo $user_avatar; ?>" style="width:40px; height:40px; object-fit:cover; border-radius:50%;" alt="Menu Avatar">
                            <div style="max-width: 150px;">
                                <h6 class="mb-0 fw-bold text-truncate text-dark" style="font-size:0.9rem;"><?php echo htmlspecialchars($user['name']); ?></h6>
                                <p class="mb-0 text-muted text-truncate" style="font-size:0.8rem;"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                    </li>
                    <li><a class="dropdown-item py-2 text-dark fw-medium rounded-2" href="profile.php"><i class="bi bi-person me-2 text-primary"></i> My Profile</a></li>
                    <li><a class="dropdown-item py-2 text-dark fw-medium rounded-2" href="messages.php"><i class="bi bi-envelope me-2 text-success"></i> Inbox Messages</a></li>
                    <li><hr class="dropdown-divider my-2 opacity-50"></li>
                    <li><a class="dropdown-item py-2 text-danger fw-medium rounded-2" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
                </ul>
            </div>
        </div>
        
        <?php if (!empty($success)): ?>
            <div class="alert alert-success border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="content-section">
            <form method="POST" action="" enctype="multipart/form-data">
                
                <h4 class="mb-4 text-primary fw-bold border-bottom pb-2"><i class="bi bi-person-lines-fill me-2"></i>Personal Information</h4>
                
                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        <div class="img-preview-wrapper rounded-circle overflow-hidden shadow-sm">
                            <img id="profile-preview-src" src="<?php echo $user_avatar; ?>" alt="Profile Preview">
                        </div>
                    </div>
                    <div class="col">
                        <label for="profile_image" class="form-label">Profile Avatar Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(this, 'profile-preview-src')">
                        <div class="form-text">Square size format recommended. Max limit 2MB (JPG, PNG, WEBP).</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
                    </div>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Professional Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($user['title'] ?? ''); ?>" placeholder="e.g., Web Developer & Designer">
                    </div>
                    <div class="col-md-6">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>" placeholder="e.g., Mumbai, India">
                    </div>
                </div>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="working_hours" class="form-label">Working Hours</label>
                        <input type="text" class="form-control" id="working_hours" name="working_hours" value="<?php echo htmlspecialchars($user['working_hours'] ?? ''); ?>" placeholder="e.g., Mon - Fri: 9AM - 6PM">
                    </div>
                </div>
                
                <h4 class="mb-4 text-primary fw-bold border-bottom pb-2 pt-2"><i class="bi bi-file-person me-2"></i>Biography Details</h4>
                
                <div class="row align-items-center mb-4">
                    <div class="col-auto">
                        <div class="shadow-sm rounded overflow-hidden" style="width: 140px; height: 90px; border: 2px solid #667eea;">
                            <img id="about-preview-src" src="<?php echo $about_avatar; ?>" style="width:100%; height:100%; object-fit:cover;" alt="About Banner Preview">
                        </div>
                    </div>
                    <div class="col">
                        <label for="about_image" class="form-label">About Showcase Banner</label>
                        <input type="file" class="form-control" id="about_image" name="about_image" accept="image/*" onchange="previewImage(this, 'about-preview-src')">
                        <div class="form-text">Landscape banner design layout recommended.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Short Tagline Description</label>
                    <textarea class="form-control" id="description" name="description" rows="2" placeholder="Brief description for landing screen element"><?php echo htmlspecialchars($user['description'] ?? ''); ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="about_short" class="form-label">About Section Sub-Header Title</label>
                    <input type="text" class="form-control" id="about_short" name="about_short" value="<?php echo htmlspecialchars($user['about_content_short'] ?? ''); ?>">
                </div>
                
                <div class="mb-4">
                    <label for="about_long" class="form-label">Detailed About Section Core Content</label>
                    <textarea class="form-control" id="about_long" name="about_long" rows="4" placeholder="Detailed professional bio timeline parameters"><?php echo htmlspecialchars($user['about_content_long'] ?? ''); ?></textarea>
                </div>
                
                <h4 class="mb-4 text-primary fw-bold border-bottom pb-2 pt-2"><i class="bi bi-bar-chart-line me-2"></i>Metrics & Performance Statistics</h4>
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="projects_done" class="form-label">Projects Completed</label>
                        <input type="number" class="form-control" id="projects_done" name="projects_done" value="<?php echo $user['projects_done'] ?? 0; ?>" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="happy_clients" class="form-label">Satisfied Clients</label>
                        <input type="number" class="form-control" id="happy_clients" name="happy_clients" value="<?php echo $user['happy_clients'] ?? 0; ?>" min="0">
                    </div>
                    <div class="col-md-4">
                        <label for="years_experience" class="form-label">Years of Professional Experience</label>
                        <input type="number" class="form-control" id="years_experience" name="years_experience" value="<?php echo $user['years_experience'] ?? 0; ?>" min="0">
                    </div>
                </div>
                
                <h4 class="mb-4 text-primary fw-bold border-bottom pb-2 pt-2"><i class="bi bi-share me-2"></i>Social Integration Network URLs</h4>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="facebook_link" class="form-label">Facebook Profile Link</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary"><i class="bi bi-facebook"></i></span>
                            <input type="url" class="form-control" id="facebook_link" name="facebook_link" value="<?php echo htmlspecialchars($user['facebook_link'] ?? ''); ?>" placeholder="https://facebook.com/username">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="twitter_link" class="form-label">X / Twitter Profile Link</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-dark"><i class="bi bi-twitter-x"></i></span>
                            <input type="url" class="form-control" id="twitter_link" name="twitter_link" value="<?php echo htmlspecialchars($user['twitter_link'] ?? ''); ?>" placeholder="https://x.com/username">
                        </div>
                    </div>
                </div>
                
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="instagram_link" class="form-label">Instagram Profile Link</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-danger"><i class="bi bi-instagram"></i></span>
                            <input type="url" class="form-control" id="instagram_link" name="instagram_link" value="<?php echo htmlspecialchars($user['instagram_link'] ?? ''); ?>" placeholder="https://instagram.com/username">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="linkedin_link" class="form-label">LinkedIn Professional Link</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-primary"><i class="bi bi-linkedin"></i></span>
                            <input type="url" class="form-control" id="linkedin_link" name="linkedin_link" value="<?php echo htmlspecialchars($user['linkedin_link'] ?? ''); ?>" placeholder="https://linkedin.com/in/username">
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="github_link" class="form-label">GitHub Code Repository Link</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-dark"><i class="bi bi-github"></i></span>
                        <input type="url" class="form-control" id="github_link" name="github_link" value="<?php echo htmlspecialchars($user['github_link'] ?? ''); ?>" placeholder="https://github.com/username">
                    </div>
                </div>
                
                <hr class="my-4 opacity-50">
                
                <div class="d-grid d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-submit px-5 py-2.5">
                        <i class="bi bi-cloud-arrow-up-fill me-2"></i>Save Profile Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function previewImage(inputTarget, previewElementId) {
        if (inputTarget.files && inputTarget.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (eventTarget) {
                document.getElementById(previewElementId).setAttribute('src', eventTarget.target.result);
            };
            fileReader.readAsDataURL(inputTarget.files[0]);
        }
    }
    </script>
</body>
</html>