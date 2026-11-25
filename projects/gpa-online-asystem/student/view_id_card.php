<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests 
     WHERE student_id='$student_id' 
     AND status='Approved'"
);

$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "ID Card Not Approved Yet.";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>My ID Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-light text-center">

    <div class="container mt-5">

        <h3>My Approved ID Card</h3>

        <div class="mt-4 p-3 bg-light text-dark" style="width:500px; height:300px; margin:auto; border-radius:10px;">

            <!-- HEADER -->
            <div style="display:flex; align-items:center;">
                <img src="../assets/images/gpa.png" width="60">
                <div style="margin-left:10px;">
                    <b style="font-size:18px;">Goverment Polytechnic Atraulia</b><br>
                    <b>Azamgarh, Uttar Pradesh</b> <br>
                    <small>Approved by AICTE New Delhi and Affiliated to B.T.E. Lucknow</small>
                </div>
            </div>

            <hr>

            <!-- BODY -->
            <div style="display:flex;">


                <div style=" margin-left:15px; text-align:left;">
                    <b>Enrollment No:</b> <?php echo $data['roll_number']; ?><br>
                    <b>Name:</b> <?php echo  $data['student_name']; ?><br>
                    <b>Father Name:</b><?php echo $data['father_name']; ?><br>
                    <b>Branch:</b> <?php echo $data['branch']; ?><br>
                    <b>Year: </b><?php echo $data['year']; ?><br>
                    <b>DOB:</b> <?php echo $data['dob']; ?><br>
                    <b>Mobile No:</b> <?php echo $data['mobile']; ?>
                </div>

                <img src="../uploads/id_cards/student_photos/<?php echo $data['student_photo']; ?>" width="90"
                    height="100" style="margin-right:-50px;">
            </div>

            <hr>

            <!-- SIGNATURES -->
            <div style="display:flex; justify-content:space-between;">

                <div>
                    <img src="../uploads/id_cards/hod_signatures/<?php echo $data['hod_signature']; ?>" width="80"><br>
                    <small>HOD</small>
                </div>

                <div>
                    <img src="../uploads/id_cards/principal_signatures/<?php echo $data['principal_signature']; ?>"
                        width="80"><br>
                    <small>Principal</small>
                </div>

                <div>
                    <img src="../uploads/id_cards/mohar/<?php echo $data['college_mohar']; ?>" width="80"><br>
                    <small>College Mohar</small>
                </div>

            </div>

        </div>

        <div class="mt-4">
            <a href="download_id_card.php" class="btn btn-success">Download PDF</a>
            <button onclick="window.print()" class="btn btn-warning">Print</button>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>