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
$branch   = $_GET['branch']   ?? '';
$year     = $_GET['year']     ?? '';
$semester = $_GET['semester'] ?? '';
$from     = $_GET['from']     ?? '';
$to       = $_GET['to']       ?? '';

// Build Query
$where = "WHERE 1";

if($branch)   $where .= " AND s.branch='$branch'";
if($year)     $where .= " AND s.year='$year'";
if($semester) $where .= " AND s.semester='$semester'";
if($from && $to) $where .= " AND a.date BETWEEN '$from' AND '$to'";

$query = "
SELECT s.id, s.full_name, s.branch, s.year, s.semester,
COUNT(a.id) AS total_classes,
SUM(a.status='Present') AS present_count
FROM students s
LEFT JOIN attendance a ON s.id = a.student_id
$where
GROUP BY s.id
ORDER BY s.full_name ASC
";

$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Attendance Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
     .card-header-custom {
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        background: #1e293b;
        color: white;
        padding: 20px;
        text-align: center;
        border-radius: 20px 20px 0 0 ;
    }
    .radius{
        background: #1e293b;
        border-radius:0 0 20px 20px;
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
        <div class=" card-header-custom  d-flex justify-content-between align-items-center ">
            <div class="mb-0">
                <h3 class="text-light"><i class="fas fa-chart-bar"></i> Attendance Reports</h3>
            </div>
            <!-- <a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a> -->

            <div class=" text-end">
                <a href="export_excel.php?branch=<?= $branch ?>&year=<?= $year ?>&semester=<?= $semester ?>&from=<?= $from ?>&to=<?= $to ?>"
                    class="btn btn-success">
                    📁 Export Excel
                </a>

                <a href="export_pdf.php?branch=<?= $branch ?>&year=<?= $year ?>&semester=<?= $semester ?>&from=<?= $from ?>&to=<?= $to ?>"
                    class="btn btn-danger">
                    📥 Download PDF
                </a>

                <button class="btn btn-primary" onclick="showGraph()">📊 View Graph</button>
            </div>
        </div>
        <!-- 🔍 Filters -->
        <div class="card p-3 shadow rounded-0 ">
            <form method="GET" class="row g-2">
                <div class="col-md-2">
                    <input type="text" name="branch" class="form-control" placeholder="Branch" value="<?= $branch ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" name="year" class="form-control" placeholder="Year" value="<?= $year ?>">
                </div>
                <div class="col-md-2">
                    <input type="text" name="semester" class="form-control" placeholder="Semester"
                        value="<?= $semester ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="from" class="form-control" value="<?= $from ?>">
                </div>
                <div class="col-md-2">
                    <input type="date" name="to" class="form-control" value="<?= $to ?>">
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>

        </div>



        <!-- 📋 Report Table -->
        <div class="card  p-3 shadow  radius">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Total Classes</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Attendance %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row=mysqli_fetch_assoc($result)) {
                    $total = $row['total_classes'] ?? 0;
                    $present = $row['present_count'] ?? 0;
                    $absent = $total - $present;
                    $percent = $total>0 ? round(($present/$total)*100,2) : 0;
                ?>
                        <tr>
                            <td><?= $row['full_name'] ?></td>
                            <td><?= $row['branch'] ?></td>
                            <td><?= $row['year'] ?></td>
                            <td><?= $row['semester'] ?></td>
                            <td><?= $total ?></td>
                            <td class="text-success fw-bold"><?= $present ?></td>
                            <td class="text-danger fw-bold"><?= $absent ?></td>
                            <td class="fw-bold"><?= $percent ?>%</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card p-4 mt-4 shadow" id="graphSection" style="display:none;">
            <h5 class="text-center mb-3">Student Attendance Graph</h5>
            <canvas id="attendanceChart"></canvas>
        </div>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    function showGraph() {
        document.getElementById('graphSection').style.display = 'block';
    }

    const ctx = document.getElementById('attendanceChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
            mysqli_data_seek($result,0);
            while($r=mysqli_fetch_assoc($result)){
                echo "'".$r['full_name']."',";
            }
            ?>
            ],
            datasets: [{
                label: 'Attendance %',
                data: [
                    <?php
                mysqli_data_seek($result,0);
                while($r=mysqli_fetch_assoc($result)){
                    $total=$r['total_classes']??0;
                    $present=$r['present_count']??0;
                    $percent=$total>0?round(($present/$total)*100,2):0;
                    echo "$percent,";
                }
                ?>
                ],
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>