<?php
session_start();
include("../config/database.php");
require('../assets/fpdf/fpdf.php');


if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


$branch = $_GET['branch'] ?? '';
$semester = $_GET['semester'] ?? '';
$year = $_GET['year'] ?? '';

$where = "";

if($branch != ''){
    $where .= " AND s.branch='$branch'";
}
if($semester != ''){
    $where .= " AND s.semester='$semester'";
}
if($year != ''){
    $where .= " AND s.year='$year'";
}

$query = mysqli_query($conn,
"SELECT s.* 
 FROM students s
 LEFT JOIN id_card_requests i 
 ON s.id = i.student_id 
 AND i.status='Approved'
 WHERE i.student_id IS NULL
 $where
 ORDER BY s.branch"
);

$chart_query = mysqli_query($conn,
"SELECT s.branch, COUNT(s.id) as total
 FROM students s
 LEFT JOIN id_card_requests i 
 ON s.id = i.student_id 
 AND i.status='Approved'
 WHERE i.student_id IS NULL
 GROUP BY s.branch"
);

$branches = [];
$totals = [];

while($c = mysqli_fetch_assoc($chart_query)){
    $branches[] = $c['branch'];
    $totals[] = $c['total'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>ID Card Not Generated</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        background-color: var(--bg-dark);

        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
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

    <div class=" main-content mt-5">
        <div class="card bg-secondary p-4 shadow">

            <h3 class="text-center mb-4">Students Without ID Card</h3>

            <!-- FILTER -->
            <form method="GET" class="row mb-4">

                <div class="col-md-3">
                    <input type="text" name="branch" placeholder="Branch" value="<?php echo $branch; ?>"
                        class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="text" name="semester" placeholder="Semester" value="<?php echo $semester; ?>"
                        class="form-control">
                </div>

                <div class="col-md-3">
                    <input type="text" name="year" placeholder="Year" value="<?php echo $year; ?>" class="form-control">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-warning w-100">Filter</button>
                </div>

            </form>

            <!-- BUTTONS -->
            <div class="mb-3">
                <a href="export_no_id_excel.php?branch=<?php echo $branch; ?>&semester=<?php echo $semester; ?>&year=<?php echo $year; ?>"
                    class="btn btn-success">Download Excel</a>

                <a href="export_no_id_pdf.php?branch=<?php echo $branch; ?>&semester=<?php echo $semester; ?>&year=<?php echo $year; ?>"
                    class="btn btn-primary">
                    Download PDF
                </a>
            </div>

            <table class="table table-dark table-bordered">
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>Branch</th>
                        <th>Semester</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                    $count=0;
                    while($row = mysqli_fetch_assoc($query)){ 
                    $count++;
                    ?>
                    <tr>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['branch']; ?></td>
                        <td><?php echo $row['semester']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>

            <h5>Total Students Without ID: <?php echo $count; ?></h5>

            <hr>

            <!-- <h4 class="text-center">Branch Wise Chart</h4>
            <canvas id="myChart"></canvas> -->

        </div>
        <div class="row">
            <div class="col-sm-12 mx-auto my-5 border border-secondary bg-secondary rounded-5">
                <h4 class="text-center text-decoration-underline">Branch Wise Chart</h4>
                <canvas id="myChart"></canvas>

            </div>
        </div>
    </div>

    <!-- <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($branches); ?>,
            datasets: [{
                label: 'Students Without ID Card',
                data: <?php echo json_encode($totals); ?>,
                backgroundColor: 'darkblue'

            }]
        }
    });
    </script> -->

    <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($branches); ?>,
            datasets: [{
                label: 'Students Without ID Card',
                data: <?php echo json_encode($totals); ?>,
                backgroundColor: 'darkblue'
            }]
        },
        options: {
            plugins: {
                legend: {
                    labels: {
                        // Top label (Legend) ka color yahan se change hoga
                        color: 'white',
                        font: {
                            size: 14
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        // Y-axis ke numbers ka color
                        color: 'black'
                    }
                },
                x: {
                    ticks: {
                        // X-axis (Branches) ke labels ka color
                        color: 'black'
                    }
                }
            }
        }
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

</body>

</html>