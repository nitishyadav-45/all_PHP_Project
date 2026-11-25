<?php
session_start();
include("../config/database.php");
if(!isset($_SESSION['admin_id'])){ exit(); }

$branch   = $_GET['branch'];
$year     = $_GET['year'];
$semester = $_GET['semester'];

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendance_report.csv"');

$output = fopen("php://output", "w");

// CSV Headers
fputcsv($output, ['Student Name', 'Branch', 'Year', 'Semester', 'Total Classes', 'Present', 'Absent', 'Attendance %']);

$condition = "WHERE s.branch='$branch' AND s.year='$year'";
if(!empty($semester)){
    $condition .= " AND s.semester='$semester'";
}

$query = mysqli_query($conn,"
    SELECT s.id, s.full_name, s.branch, s.year, s.semester
    FROM students s
    $condition
");

while($student = mysqli_fetch_assoc($query)){

    $sid = $student['id'];

    $total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM attendance WHERE student_id='$sid'"))['t'];
    $present = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as p FROM attendance WHERE student_id='$sid' AND status='Present'"))['p'];

    $absent = $total - $present;
    $percent = ($total>0)? round(($present/$total)*100,2):0;

    fputcsv($output, [
        $student['full_name'],
        $student['branch'],
        $student['year'],
        $student['semester'],
        $total,
        $present,
        $absent,
        $percent.'%'
    ]);
}

fclose($output);
exit();
?>
