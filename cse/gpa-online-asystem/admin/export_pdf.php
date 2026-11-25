<?php
include("../config/database.php");
require('../assets/fpdf/fpdf.php'); // FPDF library

$pdf = new FPDF();
$pdf->AddPage();

// Report Title (Bold)
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Attendance Report',1,1,'C');
$pdf->Ln(5); // Thodi gap dene ke liye

// Filters logic (Same as yours)
$where="WHERE 1";
if(!empty($_GET['branch']))   $where.=" AND s.branch='".mysqli_real_escape_string($conn, $_GET['branch'])."'";
if(!empty($_GET['year']))     $where.=" AND s.year='".mysqli_real_escape_string($conn, $_GET['year'])."'";
if(!empty($_GET['semester'])) $where.=" AND s.semester='".mysqli_real_escape_string($conn, $_GET['semester'])."'";
if(!empty($_GET['from']) && !empty($_GET['to']))
    $where.=" AND a.date BETWEEN '".$_GET['from']."' AND '".$_GET['to']."'";

$result=mysqli_query($conn,"
SELECT s.full_name, COUNT(a.id) as total,
SUM(CASE WHEN a.status='Present' THEN 1 ELSE 0 END) as present
FROM students s
LEFT JOIN attendance a ON s.id=a.student_id
$where GROUP BY s.id
");

// --- HEADER SECTION START (Yahan Bold Set Kiya Hai) ---
$pdf->SetFont('Arial','B',10); // 'B' for Bold
$pdf->SetFillColor(230,230,230); // Header background color (optional)

$pdf->Cell(10,8,'Sr.no',1,0,'C',true);
$pdf->Cell(60,8,'Name',1,0,'C',true);
$pdf->Cell(25,8,'Total',1,0,'C',true);
$pdf->Cell(30,8,'Present',1,0,'C',true);
$pdf->Cell(30,8,'Absent',1,0,'C',true);
$pdf->Cell(35,8,'Percent',1,0,'C',true);
$pdf->Ln();
// --- HEADER SECTION END ---

// Data Rows ke liye wapas Normal Font set karein
$pdf->SetFont('Arial','',10); // '' for Normal

$i=1;
while($r=mysqli_fetch_assoc($result)){
    $total = $r['total'];
    $present = $r['present'];
    $absent = $total - $present;
    $percent = $total > 0 ? round(($present / $total) * 100, 2) : 0;

    $pdf->Cell(10,8,$i++,1,0,'C');
    $pdf->Cell(60,8,$r['full_name'],1);
    $pdf->Cell(25,8,$total,1,0,'C');
    $pdf->Cell(30,8,$present,1,0,'C');
    $pdf->Cell(30,8,$absent,1,0,'C');
    $pdf->Cell(35,8,$percent.'%',1,0,'C');
    $pdf->Ln();
}

$pdf->Output();
?>