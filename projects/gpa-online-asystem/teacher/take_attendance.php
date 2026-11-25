<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$branch   = $_SESSION['branch'];
$semester = $_SESSION['semester'];
$year     = $_SESSION['year'];

$date = date("Y-m-d");
$message = "";

// Fetch students
$students_query = "SELECT id, full_name FROM students 
                   WHERE branch='$branch' AND semester='$semester' AND year='$year'
                   ORDER BY full_name ASC";
$students_result = mysqli_query($conn, $students_query);

// Save attendance
if(isset($_POST['submit_attendance'])){
    foreach($_POST['status'] as $student_id => $status){
        $check = "SELECT * FROM attendance WHERE student_id='$student_id' AND date='$date'";
        $check_res = mysqli_query($conn, $check);

        if(mysqli_num_rows($check_res) == 0){
            $insert = "INSERT INTO attendance (student_id, date, status) 
                       VALUES ('$student_id', '$date', '$status')";
            mysqli_query($conn, $insert);
        } else {
            $update = "UPDATE attendance SET status='$status' WHERE student_id='$student_id' AND date='$date'";
            mysqli_query($conn, $update);
        }
    }
    $message = "<div class='alert alert-success alert-dismissible fade show animate__animated animate__fadeIn'>
                <i class='fas fa-check-circle me-2'></i> Attendance saved successfully!
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Attendance | Smart Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass: rgba(255, 255, 255, 0.95);
        }
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background: var(--primary-gradient);
            color: white;
            padding: 40px 0 100px 0;
            border-radius: 0 0 40px 40px;
            margin-bottom: -60px;
        }
        .main-card {
            background: var(--glass);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        .table thead {
            background: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .student-row:hover {
            background-color: #f8faff;
        }
        /* Custom Radio Buttons */
        .btn-check:checked + .btn-outline-success {
            background-color: #28a745;
            color: white;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
        }
        .btn-check:checked + .btn-outline-danger {
            background-color: #dc3545;
            color: white;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }
        .action-bar {
            background: white;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .search-box {
            max-width: 300px;
            border-radius: 30px;
        }
    </style>
</head>
<body>

<div class="header-section shadow">
    <div class="container text-center animate__animated animate__fadeIn">
        <h2 class="fw-bold">Mark Attendance</h2>
        <p class="opacity-75">
            <i class="fas fa-university me-2"></i> <?php echo "$branch | Sem $semester | $year"; ?> <br>
            <i class="fas fa-calendar-alt me-2"></i> <?php echo date("d F, Y"); ?>
        </p>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex justify-content-between mb-3 mt-4">
                <a href="dashboard.php" class="btn btn-light shadow-sm rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2 text-primary"></i> Back
                </a>
                <button type="button" onclick="markAllPresent()" class="btn btn-success shadow-sm rounded-pill px-4">
                    <i class="fas fa-check-double me-2"></i> Mark All Present
                </button>
            </div>

            <?php echo $message; ?>

            <div class="main-card p-4 animate__animated animate__fadeInUp">
                <div class="action-bar shadow-sm">
                    <div class="input-group search-box">
                        <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" id="studentSearch" class="form-control border-start-0" placeholder="Search student name...">
                    </div>
                    <span class="badge bg-primary px-3 py-2 rounded-pill">Total Students: <?php echo mysqli_num_rows($students_result); ?></span>
                </div>

                <form method="POST">
                    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                        <table class="table align-middle" id="attendanceTable">
                            <thead>
                                <tr class="text-secondary small text-uppercase">
                                    <th class="ps-4">Sr.</th>
                                    <th>Student Name</th>
                                    <th class="text-center">Status Selection</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1;
                                mysqli_data_seek($students_result, 0); // Reset pointer
                                while($student = mysqli_fetch_assoc($students_result)) { ?>
                                <tr class="student-row">
                                    <td class="ps-4 fw-bold text-muted"><?php echo $i++; ?></td>
                                    <td class="fw-semibold"><?php echo $student['full_name']; ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check present-radio" 
                                                   name="status[<?php echo $student['id']; ?>]" 
                                                   id="p_<?php echo $student['id']; ?>" 
                                                   value="Present" required>
                                            <label class="btn btn-outline-success px-4" for="p_<?php echo $student['id']; ?>">P</label>

                                            <input type="radio" class="btn-check" 
                                                   name="status[<?php echo $student['id']; ?>]" 
                                                   id="a_<?php echo $student['id']; ?>" 
                                                   value="Absent" required>
                                            <label class="btn btn-outline-danger px-4" for="a_<?php echo $student['id']; ?>">A</label>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="sticky-bottom bg-white p-3 border-top text-center mt-3" style="border-radius: 0 0 20px 20px;">
                        <button type="submit" name="submit_attendance" class="btn btn-primary btn-lg px-5 shadow-lg rounded-pill">
                            <i class="fas fa-cloud-upload-alt me-2"></i> Submit Attendance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Search Functionality
    document.getElementById('studentSearch').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let rows = document.querySelector("#attendanceTable tbody").rows;
        
        for (let i = 0; i < rows.length; i++) {
            let nameCol = rows[i].cells[1].textContent.toUpperCase();
            if (nameCol.indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }      
        }
    });

    // Mark All Present Function
    function markAllPresent() {
        const presentRadios = document.querySelectorAll('.present-radio');
        presentRadios.forEach(radio => {
            radio.checked = true;
        });
        
        // Visual feedback
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        btn.innerHTML = "<i class='fas fa-check'></i> All Selected!";
        btn.classList.replace('btn-success', 'btn-dark');
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.replace('btn-dark', 'btn-success');
        }, 1500);
    }
</script>

</body>
</html>