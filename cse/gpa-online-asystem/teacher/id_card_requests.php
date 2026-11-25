<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];
$message = "";

/* ------------------------------
   Approve Action
--------------------------------*/
if(isset($_POST['approve'])){

    $request_id = $_POST['request_id'];

    // HOD Signature Upload
    $hod_name = $_FILES['hod_signature']['name'];
    $hod_tmp  = $_FILES['hod_signature']['tmp_name'];
    $hod_size = $_FILES['hod_signature']['size'];

    // Mohar Upload
    $mohar_name = $_FILES['college_mohar']['name'];
    $mohar_tmp  = $_FILES['college_mohar']['tmp_name'];
    $mohar_size = $_FILES['college_mohar']['size'];

    $allowed = ['jpg','jpeg','png'];

    $hod_ext   = strtolower(pathinfo($hod_name, PATHINFO_EXTENSION));
    $mohar_ext = strtolower(pathinfo($mohar_name, PATHINFO_EXTENSION));

    if(in_array($hod_ext,$allowed) && in_array($mohar_ext,$allowed)
        && $hod_size <= 2000000 && $mohar_size <= 2000000){

        $new_hod   = time().rand(1000,9999).".".$hod_ext;
        $new_mohar = time().rand(2000,9999).".".$mohar_ext;

        move_uploaded_file($hod_tmp,"../uploads/id_cards/hod_signatures/".$new_hod);
        move_uploaded_file($mohar_tmp,"../uploads/id_cards/mohar/".$new_mohar);

        $update = "UPDATE id_card_requests SET
                    hod_signature='$new_hod',
                    college_mohar='$new_mohar',
                    status='Pending_Admin'
                   WHERE id='$request_id'
                   AND teacher_id='$teacher_id'";

        if(mysqli_query($conn,$update)){
            $message = "Request Approved & Sent to Admin.";
        }else{
            $message = "Database Error!";
        }

    }else{
        $message = "Invalid File! Only JPG/PNG under 2MB allowed.";
    }
}

/* ------------------------------
   Fetch Pending Requests
--------------------------------*/
$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests 
     WHERE teacher_id='$teacher_id' 
     AND status='Pending_Teacher'"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>ID Card Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
<div class="card bg-secondary p-4 shadow">

<h3 class="mb-4 text-center">Pending ID Card Requests</h3>

<?php if($message!=""){ ?>
<div class="alert alert-info text-center">
<?php echo $message; ?>
</div>
<?php } ?>

<?php if(mysqli_num_rows($query) > 0){ ?>

<table class="table table-bordered table-dark">
<thead>
<tr>
<th>Name</th>
<th>Roll</th>
<th>Branch</th>
<th>Photo</th>
<th>Action</th>
</tr>
</thead>
<tbody>

<?php while($row = mysqli_fetch_assoc($query)){ ?>

<tr>
<td><?php echo $row['student_name']; ?></td>
<td><?php echo $row['roll_number']; ?></td>
<td><?php echo $row['branch']; ?></td>
<td>
<img src="../uploads/id_cards/student_photos/<?php echo $row['student_photo']; ?>" width="60">
</td>

<td>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">

<div class="mb-2">
<label>Upload HOD Signature</label>
<input type="file" name="hod_signature" required class="form-control">
</div>

<div class="mb-2">
<label>Upload College Mohar</label>
<input type="file" name="college_mohar" required class="form-control">
</div>

<button type="submit" name="approve" class="btn btn-success btn-sm">
Approve & Send to Admin
</button>

</form>
</td>

</tr>

<?php } ?>

</tbody>
</table>

<?php }else{ ?>

<div class="alert alert-warning text-center">
No Pending Requests
</div>

<?php } ?>

</div>
</div>

</body>
</html>