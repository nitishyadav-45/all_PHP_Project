<?php
session_start();
include("../config/database.php");
require('../assets/fpdf/fpdf.php');

if(!isset($_SESSION['admin_id'])){ exit(); }

$branch   = $_GET['branch'];
$year     = $_GET['year'];
$semester = $_GET['semester'];

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);

$pdf->Cell(190,10,"Attendance Report",0,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,8,"Branch: $branch | Year: $year | Semester: ".($semester?:'All'),0,1,'C');
$pdf->Ln(5);

// Table Header
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,8,'Name',1);
$pdf->Cell(20,8,'Sem',1);
$pdf->Cell(25,8,'Total',1);
$pdf->Cell(25,8,'Present',1);
$pdf->Cell(25,8,'Absent',1);
$pdf->Cell(30,8,'Attendance %',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);

$condition = "WHERE s.branch='$branch' AND s.year='$year'";
if(!empty($semester)){
    $condition .= " AND s.semester='$semester'";
}

$query = mysqli_query($conn,"
    SELECT s.id, s.full_name, s.semester
    FROM students s
    $condition
");

while($student = mysqli_fetch_assoc($query)){

    $sid = $student['id'];

    $total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM attendance WHERE student_id='$sid'"))['t'];
    $present = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as p FROM attendance WHERE student_id='$sid' AND status='Present'"))['p'];

    $absent = $total - $present;
    $percent = ($total>0)? round(($present/$total)*100,2):0;

    $pdf->Cell(35,8,$student['full_name'],1);
    $pdf->Cell(20,8,$student['semester'],1);
    $pdf->Cell(25,8,$total,1);
    $pdf->Cell(25,8,$present,1);
    $pdf->Cell(25,8,$absent,1);
    $pdf->Cell(30,8,$percent.'%',1);
    $pdf->Ln();
}

$pdf->Output("D","attendance_report.pdf");
exit();
?>
