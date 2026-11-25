<?php
session_start();
include("../config/database.php");

// Admin login check
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// Fetch admin data
$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();

// Update profile info
$msg = "";
if(isset($_POST['update_profile'])){
    $name = trim($_POST['full_name']);
    if($name != ""){
        $stmt = $conn->prepare("UPDATE admins SET full_name=? WHERE id=?");
        $stmt->bind_param("si", $name, $admin_id);
        if($stmt->execute()){
            $msg = "<div class='alert alert-success'>Profile Updated Successfully</div>";
            $admin['full_name'] = $name; // update local array
        } else {
            $msg = "<div class='alert alert-danger'>Error updating profile</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Full Name cannot be empty</div>";
    }
}

// Profile image upload
if(isset($_POST['upload_image'])){
    if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error']==0){
        $target_dir = "uploads/admin/";
        if(!is_dir($target_dir)) mkdir($target_dir,0777,true);

        $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $image_name = "admin_" . $admin_id . "_" . time() . ".".$ext;
        $target_file = $target_dir . $image_name;

        if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)){
            $stmt = $conn->prepare("UPDATE admins SET profile_image=? WHERE id=?");
            $stmt->bind_param("si", $image_name, $admin_id);
            $stmt->execute();
            $msg = "<div class='alert alert-success'>Profile Image Updated</div>";
            $admin['profile_image'] = $image_name;
        } else {
            $msg = "<div class='alert alert-danger'>Error uploading image</div>";
        }
    } else {
        $msg = "<div class='alert alert-warning'>Please select an image</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#141e30,#243b55);
            font-family: 'Poppins', sans-serif;
            min-height:100vh;
        }
        .profile-card{
            max-width:500px;
            margin:auto;
            margin-top:100px;
            background:white;
            border-radius:20px;
            padding:30px;
            box-shadow:0 15px 35px rgba(0,0,0,0.3);
            transition:0.4s;
        }
        .profile-card:hover{
            transform:translateY(-5px);
        }
        .profile-img{
            width:120px;
            height:120px;
            border-radius:50%;
            object-fit:cover;
            border:4px solid #243b55;
        }
        .btn-custom{
            border-radius:30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-card text-center">

        <!-- Back Button -->
        <div class="text-start mb-3">
            <a href="dashboard.php" class="btn btn-secondary btn-sm btn-custom">⬅ Back to Dashboard</a>
        </div>

        <h3 class="mb-3">Admin Profile</h3>

        <?php echo $msg; ?>

        <!-- Profile Image -->
        <img src="uploads/admin/<?php echo $admin['profile_image'] ?? 'default.png'; ?>" class="profile-img mb-3">

        <form method="POST" enctype="multipart/form-data" class="mb-4">
            <input type="file" name="profile_image" class="form-control mb-2" required>
            <button type="submit" name="upload_image" class="btn btn-dark btn-sm btn-custom w-100">Change Profile Image</button>
        </form>

        <hr>

        <!-- Profile Info Update -->
        <form method="POST">
            <div class="mb-3 text-start">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($admin['full_name']); ?>" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Email (readonly)</label>
                <input type="email" class="form-control" value="<?php echo htmlspecialchars($admin['email']); ?>" readonly>
            </div>

            <button type="submit" name="update_profile" class="btn btn-primary btn-custom w-100">Update Profile</button>
        </form>

    </div>
</div>

</body>
</html>
