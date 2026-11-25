<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$profile = getProfile($pdo);

if ($profile && !empty($profile['resume_file'])) {
    $file = 'assets/resume/' . $profile['resume_file'];

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    } else {
        echo "<script>alert('Resume file not found.'); window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('Resume not available.'); window.location.href='index.php';</script>";
}
?>
