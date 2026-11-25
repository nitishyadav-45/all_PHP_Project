<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

// Fetch teacher data
$query = mysqli_query($conn, "SELECT * FROM teachers WHERE id='$teacher_id'");
$teacher = mysqli_fetch_assoc($query);

$message = "";

// Image Upload
if(isset($_POST['upload_image'])){
    $target_dir = "uploads/teachers/";
    if(!is_dir($target_dir)) mkdir($target_dir,0777,true);

    $file = $_FILES['profile_image'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if(in_array($ext,$allowed)){
        $new_name = "teacher_" . $teacher_id . "_" . time() . "." . $ext;
        $target_file = $target_dir . $new_name;

        if(move_uploaded_file($file['tmp_name'],$target_file)){
            mysqli_query($conn,"UPDATE teachers SET profile_image='$new_name' WHERE id='$teacher_id'");
            $_SESSION['teacher_image'] = $new_name;
            $message = "<div class='alert alert-success'>Profile image updated successfully</div>";
        } else {
            $message = "<div class='alert alert-danger'>Upload failed</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Only JPG, PNG, WEBP allowed</div>";
    }
}

$profile_img = !empty($teacher['profile_image']) ? $teacher['profile_image'] : "default.png";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#1e3c72,#2a5298);
            min-height:100vh;
        }
        .profile-card{
            max-width:420px;
            margin:auto;
            margin-top:90px;
            background:#fff;
            padding:30px;
            border-radius:20px;
            box-shadow:0 15px 40px rgba(0,0,0,0.25);
            text-align:center;
        }
        .profile-img{
            width:130px;
            height:130px;
            border-radius:50%;
            object-fit:cover;
            border:4px solid #2a5298;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-card">

        <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">⬅ Back</a>

        <h4 class="mb-3">Teacher Profile</h4>

        <?php echo $message; ?>

        <!-- Profile Image -->
        <img src="uploads/teachers/<?php echo $profile_img; ?>" class="profile-img mb-3">

        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="profile_image" class="form-control mb-3" required>
            <button type="submit" name="upload_image" class="btn btn-primary w-100">Update Image</button>
        </form>

        <hr>

        <p><strong>Name:</strong> <?php echo $teacher['full_name']; ?></p>
        <p><strong>Email:</strong> <?php echo $teacher['email']; ?></p>
        <p><strong>Mobile:</strong> <?php echo $teacher['mobile']; ?></p>

    </div>
</div>

</body>
</html>
