<?php
session_start();
include("../config/database.php");

// Delete Logic
if(isset($_GET['delete'])){
    $id = mysqli_real_escape_string($conn, $_GET['delete']); // Security fix
    mysqli_query($conn, "DELETE FROM principal_messages WHERE id='$id'");
    header("Location: manage_principal_message.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$admin = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM admins WHERE id='$admin_id'"));


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Principal Messages | Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css">

    <style>
    body {
        background-color: var(--bg-dark);

        font-family: 'Poppins', sans-serif;
    }

    .main-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        background: #fff;
        overflow: hidden;
    }

    .header-section {
        /* background: linear-gradient(45deg, #4e73df, #224abe); */
        background: linear-gradient(45deg, #1e3c72, #2a5298);
        color: white;
        padding: 30px;
        border-bottom: 5px solid #1cc88a;
    }

    .table {
        vertical-align: middle;
    }

    .table thead {
        background-color: #f8f9fc;
        color: #4e73df;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
    }

    .btn-add {
        background: #1cc88a;
        border: none;
        transition: 0.3s;
        font-weight: 600;
    }

    .btn-add:hover {
        background: #17a673;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(28, 200, 138, 0.4);
    }

    .badge-date {
        background: #eef2ff;
        color: #4e73df;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 0.8rem;
    }

    /* Mobile Responsive adjustments */
    @media (max-width: 768px) {
        .header-section h3 {
            font-size: 1.2rem;
        }

        .btn-add {
            width: 100%;
            margin-bottom: 15px;
        }

        .table-responsive {
            border: 0;
        }
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

    <div class=" main-content py-5">
        <div class="row">
            <div class="col-lg-11 mx-auto">

                <div class="main-card">
                    <div class="header-section d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class=" fw-bold"><i class="fas fa-envelope-open-text me-2"></i> Principal Messages</h2>
                            <p class="mb-0 opacity-75">View and manage all official messages</p>
                        </div>
                        <a href="principal_message.php" class="btn btn-light btn-add text-white px-4 mt-3">
                            <i class="fas fa-plus-circle me-1"></i> Add New Message
                        </a>
                    </div>

                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th width="80">ID</th> -->
                                        <th>Title</th>
                                        <th>Message Preview</th>
                                        <th>Posted Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $q = mysqli_query($conn, "SELECT * FROM principal_messages ORDER BY id DESC");
                                if(mysqli_num_rows($q) > 0) {
                                    while($row = mysqli_fetch_assoc($q)) {
                                ?>
                                    <tr>
                                        <!-- <td><span class="fw-bold text-secondary">#<?php echo $row['id']; ?></span></td> -->
                                        <td><span
                                                class="fw-semibold text-dark"><?php echo htmlspecialchars($row['title']); ?></span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo substr(htmlspecialchars($row['message']), 0, 80); ?>...
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge-date">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                <?php echo date('d M, Y', strtotime($row['created_at'])); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="?delete=<?php echo $row['id']; ?>"
                                                class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                onclick="return confirm('Are you sure you want to delete this message permanently?')">
                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center py-5 text-muted'>No messages found in database.</td></tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- <p class="text-center mt-4 text-muted small">© <?php echo date('Y'); ?> Admin Management System</p> -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>


</body>

</html>