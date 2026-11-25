<?php
session_start();
include("../config/database.php");

// Teacher login check
if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

// Fetch leave applications (teacher wise)
$query = mysqli_query($conn,"
SELECT leave_applications.*, students.full_name, students.branch, students.mobile
FROM leave_applications
JOIN students ON leave_applications.student_id = students.id
WHERE leave_applications.teacher_id = '$teacher_id'
ORDER BY leave_applications.id DESC
");

// Status update
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remark = mysqli_real_escape_string($conn,$_POST['remark']);

    mysqli_query($conn,"UPDATE leave_applications 
    SET status='$status', teacher_remark='$remark' 
    WHERE id='$id'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Teacher Leave Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body{
    background:#0f172a;
    color:white;
}
.card{
    background:#1e293b;
    border:none;
    border-radius:15px;
}
.status-pending{color:orange;}
.status-approved{color:lightgreen;}
.status-rejected{color:red;}
</style>

</head>

<body>

<div class="container py-5">

<h3 class="mb-4 text-center">
<i class="fas fa-chalkboard-teacher"></i> Leave Applications
</h3>

<div class="card p-3 shadow">

<div class="table-responsive">
<table class="table table-dark table-hover">

<tr>
<th>Sr.no</th>
<th>Name</th>
<th>Type</th>
<th>Date</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($query)){ ?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['full_name']; ?></td>
<td><?php echo ucfirst($row['leave_type']); ?></td>
<td><?php echo $row['leave_date']; ?></td>

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
<h5 class="modal-title">Leave Application</h5>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<!-- Application Format -->
<div class="p-3" style="background:#020617;border-radius:10px;">

<p><strong>To,</strong><br>
HOD / Teacher</p>

<p><strong>Subject:</strong> Application for <?php echo $row['leave_type']; ?> leave</p>

<p>Respected Sir/Madam,</p>

<p>
I am <b><?php echo $row['full_name']; ?></b> (<?php echo $row['branch']; ?>).  
I want leave on <b><?php echo $row['leave_date']; ?></b>.
</p>

<p>
<?php echo $row['reason']; ?>
</p>

<p>
Kindly grant me leave.
</p>

<p>Thank You</p>

<p>
Mobile: <?php echo $row['mobile']; ?>
</p>

</div>

<hr>

<!-- Update Form -->
<form method="POST">

<input type="hidden" name="id" value="<?php echo $row['id']; ?>">

<div class="mb-2">
<label>Status</label>
<select name="status" class="form-select">
<option value="pending">Pending</option>
<option value="in_review">In Review</option>
<option value="approved">Approve & Send to Principal</option>
<option value="rejected">Reject</option>
</select>
</div>

<div class="mb-2">
<label>Remark</label>
<textarea name="remark" class="form-control"></textarea>
</div>

<!-- Parent Verify -->
<div class="form-check mb-2">
<input type="checkbox" name="verify" class="form-check-input">
<label>Parent Verified (for Half Leave)</label>
</div>

<button name="update" class="btn btn-success w-100">
Update Status
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