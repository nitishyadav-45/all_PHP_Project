<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}


$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


// Delete holiday logic
// if(isset($_GET['delete'])){
//     $id = intval($_GET['delete']);
//     mysqli_query($conn, "DELETE FROM holidays WHERE id=$id");
//     header("Location: manage_holidays.php"); // Page refresh taaki deleted item turant hat jaye
//     exit();
// }

// Delete holiday logic
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM holidays WHERE id=$id");
    
    // Yaha 'msg=deleted' add kiya gaya hai redirect ke saath
    header("Location: manage_holidays.php?msg=deleted"); 
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM holidays ORDER BY holiday_date DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Holidays</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
    body {
        background-color: var(--bg-dark);
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
    }

    .table-container {
        /* background: #fff; */
        background:#1e293b;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .text-truncate-custom {
    max-width: 150px; /* Aap apne hisaab se width set kar sakte hain */
    white-space: nowrap;
    overflow: hidden;
    /* text-overflow: ellipsis; */
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

    <div class="main-content ">
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class=" mb-0">

                        <h3 class="mb-0 text-center text-light  "> Holiday List</h3>
                        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <strong>Success!</strong> Holiday list se delete kar di gayi hai.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php endif; ?>
                        <!-- <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">⬅ Back to Dashboard</a> -->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th >Reason</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                            $count = 1;
                            while($row = mysqli_fetch_assoc($result)){ 
                            ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            <?php echo date("d M Y", strtotime($row['holiday_date'])); ?>
                                        </span>
                                    </td>
                                    <!-- <td ><?php echo htmlspecialchars($row['reason']); ?></td> -->
                                     <td class="text-nowrap px-3"><?php echo htmlspecialchars($row['reason']); ?></td>
                                    <td>
                                        <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Kya aap wakai ise delete karna chahte hain?');">
                                            🗑 Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>

                                <?php if(mysqli_num_rows($result) == 0): ?>
                                <tr>
                                    <td colspan="5" class="text-muted py-4">Koi holiday nahi mili.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>