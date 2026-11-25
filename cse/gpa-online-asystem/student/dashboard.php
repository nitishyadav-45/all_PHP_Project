<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];
$branch = $_SESSION['branch'];
$semester = $_SESSION['semester'];
$year = $_SESSION['year'];

// Fetch student attendance summary
$total_classes_query = "SELECT COUNT(*) as total FROM attendance WHERE student_id='$student_id'";
$total_classes_res = mysqli_query($conn, $total_classes_query);
$total_classes = mysqli_fetch_assoc($total_classes_res)['total'];

$present_query = "SELECT COUNT(*) as present FROM attendance WHERE student_id='$student_id' AND status='Present'";
$present_res = mysqli_query($conn, $present_query);
$total_present = mysqli_fetch_assoc($present_res)['present'];

$total_absent = $total_classes - $total_present;
$total_percent = ($total_classes > 0) ? round(($total_present/$total_classes)*100,2) : 0;

// Month-wise attendance
$months = [];
$present_per_month = [];
$monthly_attendance = []; // table data

for($m=1;$m<=12;$m++){
    $month_name = date('F', mktime(0,0,0,$m,1));
    $months[] = $month_name;

    $month_total_query = "SELECT COUNT(*) as total FROM attendance WHERE student_id='$student_id' AND MONTH(date)='$m'";
    $month_total_res = mysqli_query($conn, $month_total_query);
    $month_total = mysqli_fetch_assoc($month_total_res)['total'];

    $month_present_query = "SELECT COUNT(*) as total FROM attendance WHERE student_id='$student_id' AND MONTH(date)='$m' AND status='Present'";
    $month_present_res = mysqli_query($conn, $month_present_query);
    $month_present = mysqli_fetch_assoc($month_present_res)['total'];

    $month_absent = $month_total - $month_present;
    $month_percent = ($month_total > 0) ? round(($month_present/$month_total)*100,2) : 0;

    $present_per_month[] = $month_present;

    $monthly_attendance[] = [
        'month' => $month_name,
        'total' => $month_total,
        'present' => $month_present,
        'absent' => $month_absent,
        'percent' => $month_percent
    ];
}
$img_query = mysqli_query($conn, "SELECT profile_image FROM students WHERE id='$student_id'");
$img_data = mysqli_fetch_assoc($img_query);

$profile_img = (!empty($img_data['profile_image']) && file_exists($img_data['profile_image']))
    ? $img_data['profile_image']
    : "../assets/images/default_user.png";
// Profile Image
$profile_img = isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : "../assets/images/default_user.png";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    body {
        font-family: 'Poppins', sans-serif;

    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100%;
        width: 250px;
        background: #212529;
        color: white;
        padding-top: 70px;
        z-index: 1040;
        /* Yeh line sidebar ko cards ke upar layegi */
        transition: all 0.3s ease-in-out;
        /* Smooth open/close effect */
        overflow-y: auto;
        /* Agar menu bada ho to scroll ho jaye */
    }

    .sidebar a {
        color: white;
        display: block;
        padding: 15px;
        text-decoration: none;
        transition: 0.3s;
    }

    .sidebar a i {
        font-size: 1.1rem;
        width: 25px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: rgba(99, 102, 241, 0.15);
        color: #fff;
        border-radius: 8px;
    }


    .navbar {
        /* z-index: 999; */
        z-index: 1050;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
        /* new add */
        transition: all 0.3s ease-in-out;
    }


    .card-hover:hover {
        transform: translateY(-10px);
        transition: 0.4s;
    }

    .gradient-card {
        background: linear-gradient(135deg, #ff758c, #ff7eb3);
        color: white;
    }

    .table thead {
        background: #6610f2;
        color: white;
    }

    .table-hover tbody tr:hover {
        background-color: #f0f0f0;
    }

    /* Mobile Responsive Fixes */
    @media(max-width:768px) {
        .sidebar {
            left: -260px;
            /* Sidebar ko puri tarah hide karne ke liye */
            box-shadow: 5px 0 15px rgba(0, 0, 0, 0.5);
            /* Mobile par shadow */
        }

        .sidebar.active {
            left: 0;
            /* JS se jab class add hogi tab bahar aayega */
        }

        .main-content {
            margin-left: 0;
        }

        /* Navbar me welcome text ko mobile par hide karein taki layout na tute */
        .welcome-text {
            display: none !important;
        }
    }

    /* Sidebar Links Styling */
    .sidebar-link {
        color: #adb5bd;
        text-decoration: none;
        padding: 0.8rem 1.2rem;
        display: block;
        transition: all 0.3s;
    }

    .sidebar-link:hover,
    .sidebar-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);

    }
    </style>
</head>

<body>



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container-fluid">

            <button class="btn btn-dark d-md-none me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="../index.php">Student Dashboard</a>

            <span class="text-white welcome-text d-none d-lg-block"
                style="font-weight:bold; position: absolute; left: 50%; transform: translateX(-50%); font-size:20px;">
                <?php echo "Welcome $student_name"; ?>
            </span>

            <div class="ms-auto d-flex align-items-center">




                <span class="me-3 text-white d-none d-sm-inline">
                    <?php echo " $student_name"; ?>
                </span>

                <div class="dropdown">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $profile_img; ?>" alt="image" width="40" height="40"
                            class="rounded-circle border border-2 border-secondary">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small  shadow"
                        aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="change_password.php">
                                <i class="fas fa-lock me-2"></i> Forgot Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger " href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="sidebar animate__animated animate__fadeInLeft ">

        <a href="dashboard.php" class="active"><i class="bi bi-speedometer2 me-2"></i></i>Dashboard</a>
        <a href="view_attendance.php"><i class="fas fa-calendar-check me-2"></i>Attendance</a>
        <a href="#"><i class="fas fa-file-alt me-2"></i>Reports</a>
        <a href="view_holidays.php"><i class=" fa-solid fa-bell me-2"></i>Holiday</a>
        <a href="profile.php"><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>




    <div class="main-content">
        <div class="container-fluid mt-5 ">


            <div class="row g-4 mt-5 mb-4">
                <div class="col-md-3">
                    <div class="card p-3 text-center card-hover gradient-card">
                        <h5>Total Classes</h5>
                        <h2><?php echo $total_classes; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center card-hover gradient-card"
                        style="background:linear-gradient(135deg,#6a11cb,#2575fc);">
                        <h5>Present</h5>
                        <h2><?php echo $total_present; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center card-hover gradient-card"
                        style="background:linear-gradient(135deg,#ff9966,#ff5e62);">
                        <h5>Absent</h5>
                        <h2><?php echo $total_absent; ?></h2>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 text-center card-hover gradient-card"
                        style="background:linear-gradient(135deg,#00c6ff,#0072ff);">
                        <h5>Attendance %</h5>
                        <h2><?php echo $total_percent; ?>%</h2>
                    </div>
                </div>
            </div>

            <div class="card p-4 shadow mb-4 card-hover ">
                <h5 class="mb-3">Monthly Attendance Chart</h5>
                <canvas id="attendanceChart" height="100"></canvas>
            </div>

            <!-- Attendance Table -->
            <div class="card p-4 shadow card-hover mb-5">
                <h5 class="mb-3">Monthly Attendance Details</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Total Classes</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Attendance %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($monthly_attendance as $m): ?>
                            <tr>
                                <td><?php echo $m['month']; ?></td>
                                <td><?php echo $m['total']; ?></td>
                                <td><?php echo $m['present']; ?></td>
                                <td><?php echo $m['absent']; ?></td>
                                <td><?php echo $m['percent']; ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- <footer class="text-center mt-4 p-3 bg-dark text-white fixed-bottom">
        © <?php echo date("Y"); ?> Smart Attendance System | Developed by Nitish
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Present Days',
                data: <?php echo json_encode($present_per_month); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Days'
                    }
                }
            }
        }
    });
    </script>

    <script>
    // Toggle button par click karne par sidebar me 'active' class add/remove karega
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Agar mobile par sidebar open hai aur user bahar click karta hai, to band ho jaye
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    </script>

</body>

</html>