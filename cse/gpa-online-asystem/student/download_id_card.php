<?php
session_start();
include("../config/database.php");
require('../assets/fpdf/fpdf.php');



$student_id = $_SESSION['student_id'];

$query = mysqli_query($conn,
    "SELECT * FROM id_card_requests 
     WHERE student_id='$student_id' 
     AND status='Approved'"
);

$data = mysqli_fetch_assoc($query);

if(!$data){
    die("Not Approved");
}

// ATM SIZE 85.6 x 54 mm
$pdf = new FPDF('L','mm',array(85.6,54));
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);

// Logo
$pdf->Image('../assets/images/gpa.png',5,5,10);

// College Name
$pdf->SetXY(18,5);
$pdf->Cell(0,5,'ABC College of Engineering',0,1);
$pdf->SetX(18);
$pdf->Cell(0,5,'Kanpur, Uttar Pradesh',0,1);

$pdf->Line(5,18,80,18);

// Student Photo
$pdf->Image('../uploads/id_cards/student_photos/'.$data['student_photo'],5,20,18,20);

// Details
$pdf->SetXY(25,20);
$pdf->SetFont('Arial','',7);
$pdf->Cell(0,4,'Name: '.$data['student_name'],0,1);
$pdf->SetX(25);
$pdf->Cell(0,4,'Father: '.$data['father_name'],0,1);
$pdf->SetX(25);
$pdf->Cell(0,4,'Roll: '.$data['roll_number'],0,1);
$pdf->SetX(25);
$pdf->Cell(0,4,'Branch: '.$data['branch'],0,1);
$pdf->SetX(25);
$pdf->Cell(0,4,'Year: '.$data['year'],0,1);
$pdf->SetX(25);
$pdf->Cell(0,4,'DOB: '.$data['dob'],0,1);

// Signatures
$pdf->Image('../uploads/id_cards/hod_signatures/'.$data['hod_signature'],10,40,15);
$pdf->Image('../uploads/id_cards/principal_signatures/'.$data['principal_signature'],35,40,15);
$pdf->Image('../uploads/id_cards/mohar/'.$data['college_mohar'],60,40,15);

$pdf->Output('D','Student_ID_Card.pdf');
?>