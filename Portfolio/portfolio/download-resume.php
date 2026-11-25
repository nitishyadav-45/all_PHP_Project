<?php
// This is a placeholder for resume download logic
// In a real scenario, you would provide the path to the actual PDF file
$file = 'assets/resume.pdf';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    echo "Resume file not found. Please contact the administrator.";
}
?>
