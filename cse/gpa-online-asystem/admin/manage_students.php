<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();

}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


// Filters
$branch_filter = $_GET['branch'] ?? '';
$year_filter   = $_GET['year'] ?? '';

// Build query
$query = "SELECT * FROM students WHERE 1";

if($branch_filter != ''){
    $query .= " AND branch='$branch_filter'";
}
if($year_filter != ''){
    $query .= " AND year='$year_filter'";
}

$query .= " ORDER BY full_name ASC";
$students = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    body {
        /* background: #f4f6f9; */
        background-color: var(--bg-dark);

    }

    .card {
        border-radius: 15px;
        /* background-color: var(--card-bg); */

    }

    .table thead {
        background: #343a40;
        color: white;
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
        <hr>
        <a class="dropdown-item text-danger" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>
            Logout</a>

    </div>

    <div class="main-content mt-5">
        <!-- <a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a> -->
        <div class="card  shadow p-4">

            <h3 class="mb-4 text-center">🎓 Manage Students</h3>

            <!-- 🔍 Filters -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5">
                    <select name="branch" class="form-select">
                        <option value="">Select Branch</option>
                        <option value="CSE">CSE</option>
                        <option value="E.E">Electrical</option>
                        <option value="M.E">Mechanical</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="year" class="form-select">
                        <option value="">Select Year</option>
                        <option value="First Year">First Year</option>
                        <option value="Second Year">Second Year</option>
                        <option value="Third Year">Third Year</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <!-- 📋 Student Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>Sr.no</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <!-- <th>Attendance %</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                $i = 1;
                while($row = mysqli_fetch_assoc($students)){
                    $sid = $row['id'];

                    // Attendance % calculation
                    $total_q = mysqli_query($conn,"SELECT COUNT(*) as total FROM attendance WHERE student_id='$sid'");
                    $total = mysqli_fetch_assoc($total_q)['total'];

                    $present_q = mysqli_query($conn,"SELECT COUNT(*) as present FROM attendance WHERE student_id='$sid' AND status='Present'");
                    $present = mysqli_fetch_assoc($present_q)['present'];

                    $percent = ($total > 0) ? round(($present/$total)*100,2) : 0;

                    echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['branch']}</td>
                        <td>{$row['year']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['mobile']}</td>
                        <td>{$row['email']}</td>
                       <!--<td><span class='badge bg-success'>{$percent}%</span></td>-->
                        <td>
                            <a href='view_student_attendance.php?id=$sid' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>
                            <a href='edit_student.php?id=$sid' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>
                            
                        </td>
                        </tr>";
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Sidebar Toggle
    document.getElementById("menu-toggle").addEventListener("click", function(e) {
        e.preventDefault();
        document.getElementById("sidebar").classList.toggle("active");
    });

    document.addEventListener("click", function(event) {
        var sidebar = document.getElementById("sidebar");
        var menuToggle = document.getElementById("menu-toggle");

        if (window.innerWidth <= 992 && sidebar.classList.contains("active")) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                sidebar.classList.remove("active");
            }
        }
    });
    </script>

</body>

</html>