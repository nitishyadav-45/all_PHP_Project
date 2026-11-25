<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

/* Teacher Branch Fetch */
$tq = mysqli_query($conn,"SELECT branch FROM teachers WHERE id='$teacher_id'");
$tdata = mysqli_fetch_assoc($tq);
$branch = $tdata['branch'];

/* Approved ID Cards of Same Branch */
$query = mysqli_query($conn,
"SELECT * FROM id_card_requests 
 WHERE branch='$branch' 
 AND status='Approved'");
?>

<!DOCTYPE html>
<html>

<head>
    <title>All Student ID Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light">

    <div class="container mt-5">
        <div class="card bg-secondary p-4 shadow">

            <h3 class="text-center mb-4">Approved ID Cards - <?php echo $branch; ?></h3>

            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Father</th>
                        <th>Roll</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>
                        <td>
                            <img src="../uploads/id_cards/student_photos/<?php echo $row['student_photo']; ?>"
                                width="50">
                        </td>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['father_name']; ?></td>
                        <td><?php echo $row['roll_number']; ?></td>
                        <td><?php echo $row['year']; ?></td>
                        <td>
                            <a href="edit_id_card.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                        </td>
                    </tr>

                    <?php } ?>

                </tbody>
            </table>

        </div>
    </div>

</body>

</html>