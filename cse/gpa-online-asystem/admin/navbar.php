 <?php
 
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
    
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));

?>

 <html>

 <head>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

     <link rel="stylesheet" href="css/dashboard.css">
 </head>

 <body>

     <nav class="navbar navbar-dark fixed-top px-3 d-flex justify-content-between align-items-center">
         <div class="d-flex align-items-center">
             <button class="btn btn-outline-light me-3 d-lg-none border-0" id="menu-toggle"><i
                     class="fas fa-bars"></i></button>
             <a class="navbar-brand fw-bold" href="#">Admin Panel</a>
         </div>

         <h6 class="welcome-text  d-none d-lg-block position-absolute start-50 translate-middle-x fs-5">
             Welcome, <?php echo htmlspecialchars($admin['full_name']); ?>
         </h6>

         <div class="d-flex align-items-center">
             <span class="text-white me-3 d-none d-md-block" style="font-size: 0.9rem; opacity: 0.8;">
                 <?php echo htmlspecialchars($admin['email']); ?>
             </span>

             <div class="dropdown">
                 <a href="#" class="d-block text-decoration-none dropdown-toggle-no-caret" id="dropdownUser"
                     data-bs-toggle="dropdown" aria-expanded="false">
                     <img src="uploads/admin/<?php echo $admin['profile_image'] ?? 'default.png'; ?>"
                         class="profile-img" alt="Profile">
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
         <hr>
         <a class="dropdown-item text-danger" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>
             Logout</a>

     </div>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     <script src="js/script.js"></script>

 </body>

 </html>