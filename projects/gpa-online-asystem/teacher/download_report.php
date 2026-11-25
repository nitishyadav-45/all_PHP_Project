<?php
session_start();
include("../config/database.php");
require('../assets/fpdf/fpdf.php');

$branch   = $_SESSION['branch'];
$semester = $_SESSION['semester'];
$year     = $_SESSION['year'];

$month = $_GET['month'];
$year_now = date('Y');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,"Monthly Attendance Report",0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,"Class: $branch - Sem $semester - $year",0,1);
$pdf->Cell(0,8,"Month: ".date('F', mktime(0,0,0,$month,1)),0,1);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,'Sr.no',1);
$pdf->Cell(50,8,'Name',1);
$pdf->Cell(30,8,'Total',1);
$pdf->Cell(30,8,'Present',1);
$pdf->Cell(30,8,'Absent',1);
$pdf->Cell(30,8,'%',1);
$pdf->Ln();

$students = mysqli_query($conn,"SELECT id, full_name FROM students WHERE branch='$branch' AND semester='$semester' AND year='$year'");

$i=1;
while($s = mysqli_fetch_assoc($students)){
    $sid = $s['id'];

    $total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as t FROM attendance WHERE student_id='$sid' AND MONTH(date)='$month' AND YEAR(date)='$year_now'"))['t'];
    $present = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as p FROM attendance WHERE student_id='$sid' AND status='Present' AND MONTH(date)='$month' AND YEAR(date)='$year_now'"))['p'];

    $absent = $total - $present;
    $percent = ($total>0)? round(($present/$total)*100,2):0;

    $pdf->Cell(10,8,$i++,1);
    $pdf->Cell(50,8,$s['full_name'],1);
    $pdf->Cell(30,8,$total,1);
    $pdf->Cell(30,8,$present,1);
    $pdf->Cell(30,8,$absent,1);
    $pdf->Cell(30,8,$percent.'%',1);
    $pdf->Ln();
}

$pdf->Output();
?>
