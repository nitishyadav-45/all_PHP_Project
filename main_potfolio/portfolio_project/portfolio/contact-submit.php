<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs (Ensure these match the 'name' attributes in HTML form)
    $name     = sanitize($_POST['name']);
    $email    = sanitize($_POST['email']);
    $phone_no = sanitize($_POST['phone_no']); // <-- Semicolon added
    $budget   = isset($_POST['budget']) ? sanitize($_POST['budget']) : ''; 
    $subject  = sanitize($_POST['subject']);
    $message  = sanitize($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        try {
            // Include 'mobile' (or phone_no) in the query
            // I'm assuming your DB column is named 'mobile' as we discussed earlier. 
            // If you added 'budget' to DB, add it here too.
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, mobile, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone_no, $subject, $message]);
            
            echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='index.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Sorry, something went wrong. Please try again later.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='index.php';</script>";
    }
} else {
    header("Location: index.php");
    exit();
}
?>