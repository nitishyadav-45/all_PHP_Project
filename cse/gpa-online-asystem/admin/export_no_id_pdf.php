<?php
session_start();
include("../config/database.php");
require('../assets/fpdf/fpdf.php');

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$branch = $_GET['branch'] ?? '';
$semester = $_GET['semester'] ?? '';
$year = $_GET['year'] ?? '';

$where = "";

if($branch != ''){
    $where .= " AND s.branch='$branch'";
}
if($semester != ''){
    $where .= " AND s.semester='$semester'";
}
if($year != ''){
    $where .= " AND s.year='$year'";
}

$query = mysqli_query($conn,
"SELECT s.* 
 FROM students s
 LEFT JOIN id_card_requests i 
 ON s.id = i.student_id 
 AND i.status='Approved'
 WHERE i.student_id IS NULL
 $where
 ORDER BY s.branch, s.semester"
);

/* ================= PDF START ================= */

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont("Arial","B",16);

/* College Title */
$pdf->Cell(190,10,"College ID Card Pending Report",0,1,"C");

$pdf->SetFont("Arial","",12);
$pdf->Ln(5);

/* Table Header */
$pdf->SetFont("Arial","B",11);
$pdf->Cell(15,10,"Sr.no",1);
$pdf->Cell(50,10,"Name",1);
$pdf->Cell(40,10,"Branch",1);
$pdf->Cell(30,10,"Semester",1);
$pdf->Cell(30,10,"Year",1);
$pdf->Ln();

/* Table Data */
$pdf->SetFont("Arial","",10);

$count = 1;

while($row = mysqli_fetch_assoc($query)){
    $pdf->Cell(15,8,$count,1);
    $pdf->Cell(50,8,$row['full_name'],1);
    $pdf->Cell(40,8,$row['branch'],1);
    $pdf->Cell(30,8,$row['semester'],1);
    $pdf->Cell(30,8,$row['year'],1);
    $pdf->Ln();
    $count++;
}

/* Total Count */
$pdf->Ln(5);
$pdf->SetFont("Arial","B",12);
$pdf->Cell(190,10,"Total Students Without ID Card: ".($count-1),0,1);

/* Download PDF */
$pdf->Output("D","students_without_id.pdf");
exit();
?>