<?php
session_start();
include("../config/database.php");

// Admin check
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

// Filters
$where = "1";

if(isset($_GET['name']) && $_GET['name'] != ""){
    $name = mysqli_real_escape_string($conn,$_GET['name']);
    $where .= " AND students.full_name LIKE '%$name%'";
}

if(isset($_GET['semester']) && $_GET['semester'] != ""){
    $sem = $_GET['semester'];
    $where .= " AND students.semester='$sem'";
}

if(isset($_GET['year']) && $_GET['year'] != ""){
    $year = $_GET['year'];
    $where .= " AND students.year='$year'";
}

// Fetch Data
$query = mysqli_query($conn,"
SELECT leave_applications.*, students.full_name, students.branch, students.mobile, students.semester, students.year
FROM leave_applications
JOIN students ON leave_applications.student_id = students.id
WHERE $where
ORDER BY leave_applications.id DESC
");

// Update Status
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remark = mysqli_real_escape_string($conn,$_POST['remark']);

    mysqli_query($conn,"UPDATE leave_applications 
    SET status='$status', principal_remark='$remark' 
    WHERE id='$id'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Leave Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    body {
        background: #0f172a;
        color: white;
    }

    .card {
        background: #1e293b;
        border-radius: 15px;
    }

    .status-approved {
        color: #22c55e;
    }

    .status-rejected {
        color: #ef4444;
    }

    .status-pending {
        color: #facc15;
    }
    </style>
</head>

<body>

    <div class="container py-5">

        <h3 class="text-center mb-4">
            <i class="fas fa-user-shield"></i> Principal Leave Panel
        </h3>

        <!-- FILTER -->
        <div class="card p-3 mb-4">

            <form method="GET" class="row g-2">

                <div class="col-md-4">
                    <input type="text" name="name" placeholder="Search Name" class="form-control">
                </div>

                <div class="col-md-3">
                    <select name="semester" class="form-select">
                        <option value="">Semester</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="year" class="form-select">
                        <option value="">Year</option>
                        <option>1st</option>
                        <option>2nd</option>
                        <option>3rd</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>

            </form>

        </div>

        <!-- TABLE -->
        <div class="card p-3">

            <div class="table-responsive">
                <table class="table table-dark table-hover">

                    <tr>
                        <th>Sr.No</th>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    <?php while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['branch']; ?></td>
                        <td><?php echo ucfirst($row['leave_type']); ?></td>

                        <td>
                            <span class="status-<?php echo $row['status']; ?>">
                                <?php echo ucfirst($row['status']); ?>
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#viewModal<?php echo $row['id']; ?>">
                                View
                            </button>
                        </td>
                    </tr>

                    <!-- MODAL -->
                    <div class="modal fade" id="viewModal<?php echo $row['id']; ?>">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content bg-dark text-light">

                                <div class="modal-header">
                                    <h5 class="modal-title">Application Review</h5>
                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <!-- Application Format -->
                                    <div class="p-3" style="background:#020617;border-radius:10px;">

                                        <p><b>Student:</b> <?php echo $row['full_name']; ?></p>
                                        <p><b>Branch:</b> <?php echo $row['branch']; ?></p>
                                        <p><b>Semester:</b> <?php echo $row['semester']; ?></p>
                                        <p><b>Year:</b> <?php echo $row['year']; ?></p>

                                        <hr>

                                        <p><b>Leave Type:</b> <?php echo $row['leave_type']; ?></p>
                                        <p><b>Date:</b> <?php echo $row['leave_date']; ?></p>

                                        <p><b>Reason:</b><br>
                                            <?php echo $row['reason']; ?>
                                        </p>

                                        <hr>

                                        <p><b>Teacher Remark:</b><br>
                                            <?php echo $row['teacher_remark']; ?>
                                        </p>

                                    </div>

                                    <hr>

                                    <!-- Final Approval -->
                                    <form method="POST">

                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                        <div class="mb-2">
                                            <label>Status</label>
                                            <select name="status" class="form-select">
                                                <option value="approved">Approve</option>
                                                <option value="rejected">Reject</option>
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label>Principal Remark</label>
                                            <textarea name="remark" class="form-control"></textarea>
                                        </div>

                                        <button name="update" class="btn btn-success w-100">
                                            Submit Decision
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                    <?php } ?>

                </table>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>