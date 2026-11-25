<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}


$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));

$message = "";

/* ------------------------------
   Approve Action
--------------------------------*/
if(isset($_POST['approve'])){

    $request_id = $_POST['request_id'];

    // Principal Signature Upload
    $sign_name = $_FILES['principal_signature']['name'];
    $sign_tmp  = $_FILES['principal_signature']['tmp_name'];
    $sign_size = $_FILES['principal_signature']['size'];

    $allowed = ['jpg','jpeg','png'];
    $ext = strtolower(pathinfo($sign_name, PATHINFO_EXTENSION));

    if(in_array($ext,$allowed) && $sign_size <= 2000000){

        $new_sign = time().rand(5000,9999).".".$ext;
        move_uploaded_file($sign_tmp,"../uploads/id_cards/principal_signatures/".$new_sign);

        $update = "UPDATE id_card_requests SET
                    principal_signature='$new_sign',
                    status='Approved'
                   WHERE id='$request_id'";

        if(mysqli_query($conn,$update)){
            $message = "ID Card Approved Successfully!";
        }else{
            $message = "Database Error!";
        }

    }else{
        $message = "Invalid File! Only JPG/PNG under 2MB allowed.";
    }
}

/* ------------------------------
   Fetch Pending Admin Requests
--------------------------------*/
$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests 
     WHERE status='Pending_Admin'"
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin ID Card Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        body{
            background-color: var(--bg-dark);

            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }
    </style>

</head>

<body >
    
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
        <div class="card bg-secondary p-4 shadow">

            <h3 class="mb-4 text-center">Pending ID Card Approvals</h3>

            <?php if($message!=""){ ?>
            <div class="alert alert-info text-center">
                <?php echo $message; ?>
            </div>
            <?php } ?>

            <?php if(mysqli_num_rows($query) > 0){ ?>

            <table class="table table-bordered  table-info">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Roll</th>
                        <th>Branch</th>
                        <th>Photo</th>
                        <th>HOD Sign</th>
                        <th>Mohar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['roll_number']; ?></td>
                        <td><?php echo $row['branch']; ?></td>

                        <td>
                            <img src="../uploads/id_cards/student_photos/<?php echo $row['student_photo']; ?>"
                                width="60">
                        </td>

                        <td>
                            <img src="../uploads/id_cards/hod_signatures/<?php echo $row['hod_signature']; ?>"
                                width="60">
                        </td>

                        <td>
                            <img src="../uploads/id_cards/mohar/<?php echo $row['college_mohar']; ?>" width="60">
                        </td>

                        <td>
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">

                                <div class="mb-2">
                                    <label>Upload Principal Signature</label>
                                    <input type="file" name="principal_signature" required class="form-control">
                                </div>

                                <button type="submit" name="approve" class="btn btn-success btn-sm">
                                    Approve ID Card
                                </button>

                            </form>
                        </td>

                    </tr>

                    <?php } ?>

                </tbody>
            </table>

            <?php }else{ ?>

            <div class="alert alert-warning text-center">
                No Pending Requests
            </div>

            <?php } ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="js/script.js"></script>

</body>

</html>