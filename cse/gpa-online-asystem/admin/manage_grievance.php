<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

// Update
if(isset($_POST['update'])){
    $gid = $_POST['gid'];
    $status = $_POST['status'];
    $reply = mysqli_real_escape_string($conn,$_POST['reply']);

    mysqli_query($conn,"UPDATE grievances 
    SET status='$status', admin_reply='$reply' 
    WHERE id='$gid'");
}

// Filter
$where = "1";

if(isset($_GET['branch']) && $_GET['branch'] != ""){
    $branch = $_GET['branch'];
    $where .= " AND s.branch='$branch'";
}

if(isset($_GET['status']) && $_GET['status'] != ""){
    $status = $_GET['status'];
    $where .= " AND g.status='$status'";
}

// Fetch
$query = mysqli_query($conn,"
SELECT g.*, s.full_name, s.email, s.mobile, s.branch, s.year 
FROM grievances g
JOIN students s ON g.student_id = s.id
WHERE $where
ORDER BY g.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background: #0f172a;
        color: white;
    }

    /* Card */
    .card {
        border-radius: 15px;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Buttons */
    .btn-view {
        background: linear-gradient(45deg, #3b82f6, #2563eb);
        border: none;
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
    }

    .btn-update {
        background: linear-gradient(45deg, #22c55e, #16a34a);
        border: none;
    }

    .btn-delete {
        background: #ef4444;
        border: none;
    }

    /* Modal */
    .modal-content {
        border-radius: 15px;
    }

    /* Application */
    .application-box {
        background: white;
        color: black;
        padding: 20px;
        border-radius: 10px;
        line-height: 1.7;
    }
    .application-box{
    line-height: 1.8;
    font-size: 15px;
}
    </style>
</head>

<body>

    <div class="container mt-5">

        <h3 class="text-center mb-4">Admin Grievance Panel</h3>

        <!-- FILTER -->
        <form method="GET" class="row mb-4">
            <div class="col-md-4">
                <select name="branch" class="form-select">
                    <option value="">All Branch</option>
                    <option>CSE</option>
                    <option>ME</option>
                    <option>EE</option>
                </select>
            </div>

            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                </select>
            </div>

            <div class="col-md-4">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <?php while($row = mysqli_fetch_assoc($query)){ ?>

        <div class="card p-4 mb-4 shadow">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong><?php echo $row['full_name']; ?></strong>
                    (<?php echo $row['branch']." - ".$row['year']; ?>)
                </div>

                <!-- View Button -->
                <button class="btn btn-view text-white" data-bs-toggle="modal"
                    data-bs-target="#modal<?php echo $row['id']; ?>">
                    View
                </button>
            </div>

            <div class="mt-2">
                Email: <?php echo $row['email']; ?> |
                Mobile: <?php echo $row['mobile']; ?>
            </div>

            <h5 class="mt-3"><?php echo $row['title']; ?></h5>
            <p>

                <span class="badge bg-info"><?php echo $row['category']; ?></span>
            </p>

            <!-- Status -->
            <p class="mt-2">
                Status:
                <span class="badge 
<?php 
if($row['status']=="pending") echo "bg-warning";
elseif($row['status']=="in_progress") echo "bg-primary";
else echo "bg-success";
?>">
                    <?php echo ucfirst($row['status']); ?>
                </span>
            </p>

        </div>

        <!-- MODAL -->
        <div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Grievance Application</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- APPLICATION FORMAT -->
                        <!-- <div class="application-box">

                            <p><strong>To,</strong><br>The Admin</p>

                            <p><strong>Subject:</strong> <?php echo $row['title']; ?></p>

                            <p><strong>Respected Sir/Madam,</strong></p>

                            <p>
                                I am <b><?php echo $row['full_name']; ?></b>, student of
                                <b><?php echo $row['branch']; ?> (<?php echo $row['year']; ?>)</b>.
                            </p>

                            <p><?php echo $row['description']; ?></p>

                            <p>Kindly take necessary action.</p>

                            <br>

                            <p>Thanking You</p>

                            <p>
                                <b><?php echo $row['full_name']; ?></b><br>
                                Email: <?php echo $row['email']; ?><br>
                                Mobile: <?php echo $row['mobile']; ?>
                            </p>

                            <hr>

                            <p><b>Status:</b> <?php echo ucfirst($row['status']); ?></p>
                            <p><b>Admin Reply:</b> <?php echo $row['admin_reply']; ?></p>

                        </div> -->
                        <div class="application-box">

                            <p><strong>To,</strong><br>
                                The Admin</p>

                            <p><strong>Subject:</strong> <?php echo $row['title']; ?></p>

                            <p><strong>Respected Sir/Madam,</strong></p>

                            <p style="text-align: justify;">
                                I am <b><?php echo $row['full_name']; ?></b>, a student of
                                <b><?php echo $row['branch']; ?> (<?php echo $row['year']; ?>)</b>.
                                I would like to bring to your kind attention that
                                <?php echo nl2br($row['description']); ?> <br><br>
                                I request you to kindly look into this matter and take necessary action at the earliest.
                            </p>

                            <p style="text-align: justify;">
                                I shall be highly thankful to you for your kind support and consideration.
                            </p>

                            <br>

                            <p>Thanking You</p>

                            <p>
                                Yours sincerely,<br>
                                <b><?php echo $row['full_name']; ?></b><br>
                                Email: <?php echo $row['email']; ?><br>
                                Mobile: <?php echo $row['mobile']; ?>
                            </p>

                            <hr>

                            <p><b>Status:</b> <?php echo ucfirst($row['status']); ?></p>
                            <p><b>Admin Reply:</b> <?php echo $row['admin_reply']; ?></p>

                        </div>

                        <!-- UPDATE FORM -->
                        <form method="POST" class="mt-3">

                            <input type="hidden" name="gid" value="<?php echo $row['id']; ?>">

                            <div class="row">
                                <div class="col-md-4">
                                    <select name="status" class="form-select">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="resolved">Resolved</option>
                                    </select>
                                </div>

                                <div class="col-md-8">
                                    <input type="text" name="reply" class="form-control" placeholder="Write reply...">
                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-content-between">

                                <button name="update" class="btn btn-update text-white btn-sm">
                                    Update
                                </button>

                                <a href="?delete=<?php echo $row['id']; ?>"
                                    onclick="return confirm('Delete this grievance?')"
                                    class="btn btn-delete btn-sm text-white">
                                    Delete
                                </a>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>