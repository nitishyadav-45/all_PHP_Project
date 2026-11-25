<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];
$message = "";

/* Fetch Data */
$q = mysqli_query($conn,"SELECT * FROM id_card_requests WHERE id='$id'");
$data = mysqli_fetch_assoc($q);

/* Update */
if(isset($_POST['update'])){

    $name   = mysqli_real_escape_string($conn,$_POST['student_name']);
    $father = mysqli_real_escape_string($conn,$_POST['father_name']);
    $year   = mysqli_real_escape_string($conn,$_POST['year']);
    $mobile = mysqli_real_escape_string($conn,$_POST['mobile']);

    $update = "UPDATE id_card_requests SET
                student_name='$name',
                father_name='$father',
                year='$year',
                mobile='$mobile'
               WHERE id='$id'";

    if(mysqli_query($conn,$update)){
        $message = "ID Card Updated Successfully!";
        header("refresh:1;url=all_id_cards.php");
    }else{
        $message = "Update Failed!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit ID Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

    <div class="container mt-5">
        <div class="card bg-secondary p-4 shadow">

            <h3>Edit ID Card</h3>

            <?php if($message!=""){ ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label>Student Name</label>
                    <input type="text" name="student_name" value="<?php echo $data['student_name']; ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label>Father Name</label>
                    <input type="text" name="father_name" value="<?php echo $data['father_name']; ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label>Year</label>
                    <input type="text" name="year" value="<?php echo $data['year']; ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" value="<?php echo $data['mobile']; ?>" class="form-control">
                </div>

                <button type="submit" name="update" class="btn btn-success">
                    Update
                </button>

            </form>

        </div>
    </div>

</body>

</html>