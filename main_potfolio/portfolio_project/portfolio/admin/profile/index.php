<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

$profile = getProfile($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic Details
    $name = sanitize($_POST['name']);
    $title = sanitize($_POST['title']);
    $about_me = $_POST['about_me'];
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);

    // Social Media Links (Using modern ?? operator)
    $facebook = $_POST['facebook'] ?? '';
    $twitter = $_POST['twitter'] ?? '';
    $instagram = $_POST['instagram'] ?? '';
    $linkedin = $_POST['linkedin'] ?? '';
    $github = $_POST['github'] ?? '';

    // Parameters array for SQL
    $params = [$name, $title, $about_me, $email, $phone, $address, $facebook, $twitter, $instagram, $linkedin, $github];
    $image_sql = "";

    // --- IMAGE UPLOAD LOGIC ---
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../../assets/images/profile/";
        
        // Ek unique naam banate hain taki purani image overwrite na ho
        $file_name = time() . '_' . basename($_FILES["profile_image"]["name"]); 
        $target_file = $target_dir . $file_name;
        
        // Image ko temporary folder se actual folder mein move karna
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            $image_sql = ", profile_image = ?"; // Query mein image column add karne ke liye
            $params[] = $file_name; // Parameters mein file ka naam add karein
        } else {
            $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle me-2"></i>Image upload fail ho gayi. Folder permissions check karein.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }

    // ID param for the WHERE clause
    $params[] = 1; 

    // Final SQL Query (Added social links and dynamic image update)
    $sql = "UPDATE profile SET 
            name = ?, title = ?, about_me = ?, email = ?, phone = ?, address = ?, 
            facebook = ?, twitter = ?, instagram = ?, linkedin = ?, github = ? 
            $image_sql 
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute($params)) {
        $message = '<div class="alert alert-success alert-dismissible fade show" role="alert"><i class="fas fa-check-circle me-2"></i>Profile updated successfully!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        // Naya data fetch karein
        $profile = getProfile($pdo);
    } else {
        if(empty($message)){
             $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-times-circle me-2"></i>Database update fail ho gaya.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Admin Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 15px;
        }
        .card-header {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
        }
        .profile-img-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #0d6efd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .input-group-text {
            width: 45px;
            justify-content: center;
        }
        .social-heading {
            font-size: 1.1rem;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
        }
        /* Custom colors for social icons */
        .bg-facebook { background-color: #1877F2; color: white; border-color: #1877F2; }
        .bg-twitter { background-color: #1DA1F2; color: white; border-color: #1DA1F2; }
        .bg-instagram { background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); color: white; border: none; }
        .bg-linkedin { background-color: #0A66C2; color: white; border-color: #0A66C2; }
        .bg-github { background-color: #333; color: white; border-color: #333; }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-11">
                <div class="card shadow-lg">
                    
                    <div class="card-header text-white d-flex justify-content-between align-items-center p-4">
                        <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profile</h4>
                        <a href="../dashboard.php" class="btn btn-sm btn-light fw-bold rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                    
                    <div class="card-body p-4 p-md-5">
                        <?php echo $message; ?>
                        
                        <form method="POST" enctype="multipart/form-data">
                            
                            <div class="row mb-4 align-items-center">
                                <div class="col-auto text-center">
                                    <?php if(!empty($profile['profile_image'])): ?>
                                        <img src="../../assets/images/profile/<?php echo htmlspecialchars($profile['profile_image']); ?>" class="profile-img-preview mb-2" alt="Profile Image">
                                    <?php else: ?>
                                        <div class="profile-img-preview mb-2 d-flex align-items-center justify-content-center bg-secondary text-white fs-1">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <label class="form-label fw-bold text-muted">Update Profile Image</label>
                                    <input type="file" name="profile_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Recommended size: 500x500px (JPG, PNG)</small>
                                </div>
                            </div>

                            <hr class="mb-4">

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="nameInput" value="<?php echo htmlspecialchars($profile['name']); ?>" placeholder="Full Name" required>
                                        <label for="nameInput">Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="title" class="form-control" id="titleInput" value="<?php echo htmlspecialchars($profile['title']); ?>" placeholder="Professional Title" required>
                                        <label for="titleInput">Professional Title</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <textarea name="about_me" class="form-control" id="aboutInput" placeholder="About Me" style="height: 120px" required><?php echo htmlspecialchars($profile['about_me']); ?></textarea>
                                <label for="aboutInput">About Me</label>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="emailInput" value="<?php echo htmlspecialchars($profile['email']); ?>" placeholder="Email">
                                        <label for="emailInput">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="phone" class="form-control" id="phoneInput" value="<?php echo htmlspecialchars($profile['phone']); ?>" placeholder="Phone Number">
                                        <label for="phoneInput">Phone Number</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <input type="text" name="address" class="form-control" id="addressInput" value="<?php echo htmlspecialchars($profile['address']); ?>" placeholder="Address">
                                <label for="addressInput">Full Address</label>
                            </div>

                            <h5 class="social-heading mt-5 mb-4"><i class="fas fa-hashtag me-2"></i>Social Media Links</h5>
                            
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-facebook"><i class="fab fa-facebook-f"></i></span>
                                        <input type="url" name="facebook" class="form-control" placeholder="Facebook URL" value="<?php echo htmlspecialchars($profile['facebook']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-twitter"><i class="fab fa-twitter"></i></span>
                                        <input type="url" name="twitter" class="form-control" placeholder="Twitter URL" value="<?php echo htmlspecialchars($profile['twitter']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-instagram"><i class="fab fa-instagram"></i></span>
                                        <input type="url" name="instagram" class="form-control" placeholder="Instagram URL" value="<?php echo htmlspecialchars($profile['instagram']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-linkedin"><i class="fab fa-linkedin-in"></i></span>
                                        <input type="url" name="linkedin" class="form-control" placeholder="LinkedIn URL" value="<?php echo htmlspecialchars($profile['linkedin']); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-github"><i class="fab fa-github"></i></span>
                                        <input type="url" name="github" class="form-control" placeholder="GitHub URL" value="<?php echo htmlspecialchars($profile['github']); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i> Save Changes
                                </button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>