<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


$msg = ""; // Message dikhane ke liye variable

/* ------------------------------
   Delete Record Logic
--------------------------------*/
if(isset($_GET['delete_id'])){
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // Database se record delete karne se pehle server se photo delete karna
    $img_query = mysqli_query($conn, "SELECT student_photo FROM id_card_requests WHERE id='$delete_id'");
    if($img_row = mysqli_fetch_assoc($img_query)){
        $photo_name = $img_row['student_photo'];
        if(!empty($photo_name)){
            $img_path = "../uploads/id_cards/student_photos/" . $photo_name;
            if(file_exists($img_path)){
                unlink($img_path); // Image file ko server se remove karta hai
            }
        }
    }

    // Database se record delete karna
    $delete_query = "DELETE FROM id_card_requests WHERE id='$delete_id'";
    if(mysqli_query($conn, $delete_query)){
        $msg = "Record deleted successfully!";
    } else {
        $msg = "Error deleting record!";
    }
}

/* ------------------------------
   Filter & Fetch Logic
--------------------------------*/
$branch = $_GET['branch'] ?? '';
$year = $_GET['year'] ?? '';
$name = $_GET['name'] ?? '';

// Default query condition
$where = "WHERE status='Approved'";

if($branch != ''){
    $where .= " AND branch='$branch'";
}
if($year != ''){
    $where .= " AND year='$year'";
}
if($name != ''){
    $where .= " AND student_name LIKE '%$name%'";
}

$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests $where ORDER BY branch, year"
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Student ID Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
    body {
        /* background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); */
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

            <h3 class="text-center mb-4">Filter & Manage ID Cards</h3>

            <?php if($msg != ""){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php } ?>

            <form method="GET" class="row mb-4">

                <div class="col-md-3">
                    <input type="text" name="branch" placeholder="Branch"
                        value="<?php echo htmlspecialchars($branch); ?>" class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="text" name="year" placeholder="Year" value="<?php echo htmlspecialchars($year); ?>"
                        class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="text" name="name" placeholder="Search by Name"
                        value="<?php echo htmlspecialchars($name); ?>" class="form-control">
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-warning w-100">Filter</button>
                </div>

            </form>

            <table class="table table-bordered table-dark">
                <thead>
                    <tr>

                        <th>Photo</th>
                        <th>Name</th>
                        <th>Father's Name</th>
                        <th>Branch</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody>

                    <?php
                    
                    while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>


                        <td>
                            <img src="../uploads/id_cards/student_photos/<?php echo $row['student_photo']; ?>"
                                width="50" alt="Student Photo">
                        </td>

                        <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['father_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['branch']); ?></td>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>

                        <td>
                            <a href="edit_id_card.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <a href="viewstudentid.php?id=<?php echo $row['id']; ?>" class="btn btn-primary  btn-sm">
                                View id card
                            </a>

                            <a href="?delete_id=<?php echo $row['id']; ?>&branch=<?php echo urlencode($branch); ?>&year=<?php echo urlencode($year); ?>&name=<?php echo urlencode($name); ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this ID card request?');">
                                Delete
                            </a>
                        </td>

                    </tr>

                    <?php } ?>

                    <?php if(mysqli_num_rows($query) == 0){ ?>
                    <tr>
                        <td colspan="6" class="text-center">No records found.</td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>