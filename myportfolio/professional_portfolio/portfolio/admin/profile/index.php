<?php
require_once '../../includes/auth.php';
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkAuth();

$profile = getProfile($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $name = sanitize($_POST['name']);
    // $title = sanitize($_POST['title']);
    // $bio = $_POST['bio'];
    // $email = sanitize($_POST['email']);
    // $phone = sanitize($_POST['phone']);
    // $address = sanitize($_POST['address']);
    // $facebook = sanitize($_POST['facebook']);
    // $twitter = sanitize($_POST['twitter']);
    // $linkedin = sanitize($_POST['linkedin']);
    // $github = sanitize($_POST['github']);
    $name      = sanitize($_POST['name'] ?? '');
$title     = sanitize($_POST['title'] ?? '');
$bio        = $_POST['bio'] ?? '';
$email     = sanitize($_POST['email'] ?? '');
$phone     = sanitize($_POST['phone'] ?? '');
$address   = sanitize($_POST['address'] ?? '');

$facebook  = sanitize($_POST['facebook'] ?? '');
$twitter   = sanitize($_POST['twitter'] ?? '');
$linkedin  = sanitize($_POST['linkedin'] ?? '');
$github    = sanitize($_POST['github'] ?? '');

    if ($profile) {
        $stmt = $pdo->prepare("UPDATE profile SET name=?, title=?, bio=?, email=?, phone=?, address=?, facebook=?, twitter=?, linkedin=?, github=? WHERE id=?");
        $stmt->execute([$name, $title, $bio, $email, $phone, $address, $facebook, $twitter, $linkedin, $github, $profile['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO profile (name, title, bio, email, phone, address, facebook, twitter, linkedin, github) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $title, $bio, $email, $phone, $address, $facebook, $twitter, $linkedin, $github]);
    }
    
    // Handle Image Upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/profile/";
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $pdo->prepare("UPDATE profile SET image=? WHERE id=?");
            $stmt->execute([$file_name, $profile['id'] ?? $pdo->lastInsertId()]);
        }
    }

    $message = "Profile updated successfully!";
    // $profile = getProfile($pdo);
    $profile = getProfile($pdo);

if (!$profile) {
    $profile = [];
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Profile</h2>
            <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <?php if($message): ?>
        <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control"
                                value="<?php echo $profile['name'] ?? ''; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Professional Title</label>
                            <input type="text" name="title" class="form-control"
                                value="<?php echo $profile['title'] ?? ''; ?>" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Bio</label>
                            <textarea name="bio" class="form-control"
                                rows="4"><?php echo $profile['bio'] ?? ''; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="<?php echo $profile['email'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"
                                value="<?php echo $profile['phone'] ?? ''; ?>">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control"
                                value="<?php echo $profile['address'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Facebook URL</label>
                            <input type="text" name="facebook" class="form-control"
                                value="<?php echo $profile['facebook'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">LinkedIn URL</label>
                            <input type="text" name="linkedin" class="form-control"
                                value="<?php echo $profile['linkedin'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Twitter URL</label>
                            <input type="text" name="twitter" class="form-control"
                                value="<?php echo $profile['twitter'] ?? ''; ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">GitHub URL</label>
                            <input type="text" name="github" class="form-control"
                                value="<?php echo $profile['github'] ?? ''; ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control">
                            <!-- <?php if($profile['image']): ?>
                                <img src="../../uploads/profile/<?php echo $profile['image']; ?>" width="100" class="mt-2 rounded">
                            <?php endif; ?> -->

                            <?php if (!empty($profile) && !empty($profile['image'])): ?>
                            <img src="../../uploads/profile/<?php echo htmlspecialchars($profile['image']); ?>"
                                width="100" class="mt-2 rounded">
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>