<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

// Update
if(isset($_POST['update'])){
    $gid = $_POST['gid'];
    $status = $_POST['status'];
    $reply = mysqli_real_escape_string($conn,$_POST['reply']);

    mysqli_query($conn,"UPDATE grievances 
    SET status='$status', teacher_reply='$reply' 
    WHERE id='$gid'");
}

// Fetch
$query = mysqli_query($conn,"
SELECT g.*, s.full_name, s.email, s.mobile, s.branch, s.year 
FROM grievances g
JOIN students s ON g.student_id = s.id
WHERE g.teacher_id = '$teacher_id'
ORDER BY g.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Teacher Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background: #0f172a;
        color: white;
    }

    .card {
        border-radius: 15px;
    }

    .btn-view {
        background: linear-gradient(45deg, #3b82f6, #2563eb);
        border: none;
    }

    .modal-content {
        border-radius: 15px;
    }

    .application-box {
        color: black;
        background: white;
        padding: 20px;
        border-radius: 10px;
    }

    .btn-view {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .application-box {
        line-height: 1.8;
        font-size: 15px;
    }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h3 class="text-center mb-4">Teacher Grievance Panel</h3>

        <?php while($row = mysqli_fetch_assoc($query)){ ?>

        <div class="card p-4 mb-4 shadow">

            <h5><?php echo $row['title']; ?></h5>

            <p>
                <span class="badge bg-info"><?php echo $row['category']; ?></span>
            </p>

            <div class="d-flex justify-content-between align-items-center">

                <!-- Status -->
                <p class="mb-0">
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

                <!-- Small Button -->
                <button class="btn btn-view btn-sm px-2 py-1 text-white" data-bs-toggle="modal"
                    data-bs-target="#modal<?php echo $row['id']; ?>">
                    View <i class="bi bi-eye"></i>
                </button>

            </div>



        </div>

        <!-- MODAL -->
        <div class="modal fade" id="modal<?php echo $row['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-dark">Grievance Application</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">


                       

                        <div class="application-box">

                            <p><strong>To,</strong><br>
                                The Teacher</p>

                            <p><strong>Subject:</strong> <?php echo $row['title']; ?></p>

                            <p><strong>Respected Sir/Madam,</strong></p>

                            <p style="text-align: justify;">
                                I am <b><?php echo $row['full_name']; ?></b>, a student of
                                <b><?php echo $row['branch']; ?> (<?php echo $row['year']; ?>)</b>.
                                I would like to inform you that
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?> <br>
                                I kindly request you to look into this matter and take necessary action at the earliest.
                            </p>

                            <p style="text-align: justify;">
                                I shall be highly thankful for your support and consideration.
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
                            <p><b>Teacher Reply:</b> <?php echo $row['teacher_reply']; ?></p>

                        </div>

                        <!-- Update Form -->
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

                            <button name="update" class="btn btn-success mt-3">Update</button>
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