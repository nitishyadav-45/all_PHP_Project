<?php

require_once('../config/auth.php');
require_once('../config/db.php');

if(isset($_POST['save']))
{
    $degree = $_POST['degree'];
    $institute = $_POST['institute'];
    $start_year = $_POST['start_year'];
    $end_year = $_POST['end_year'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("
    INSERT INTO education
    (
        degree,
        institute,
        start_year,
        end_year,
        description
    )
    VALUES(?,?,?,?,?)
    ");

    $stmt->bind_param(
    "sssss",
    $degree,
    $institute,
    $start_year,
    $end_year,
    $description
    );

    $stmt->execute();

    header("Location: manage-education.php");
}
?>

<form method="POST">

    <input type="text" name="degree" class="form-control mb-3" placeholder="Degree">

    <input type="text" name="institute" class="form-control mb-3" placeholder="Institute">

    <input type="text" name="start_year" class="form-control mb-3" placeholder="Start Year">

    <input type="text" name="end_year" class="form-control mb-3" placeholder="End Year">

    <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>

    <button name="save" class="btn btn-success">
        Save Education
    </button>

</form>