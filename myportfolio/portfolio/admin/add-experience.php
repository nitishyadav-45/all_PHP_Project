<?php

require_once('../config/auth.php');
require_once('../config/db.php');

if(isset($_POST['save']))
{
    $company_name = $_POST['company_name'];
    $designation = $_POST['designation'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("
    INSERT INTO experience
    (
    company_name,
    designation,
    start_date,
    end_date,
    description
    )
    VALUES(?,?,?,?,?)
    ");

    $stmt->bind_param(
    "sssss",
    $company_name,
    $designation,
    $start_date,
    $end_date,
    $description
    );

    $stmt->execute();

    header("Location: manage-experience.php");
}
?>


<form method="POST">

    <input type="text" name="company_name" class="form-control mb-3" placeholder="Company Name">

    <input type="text" name="designation" class="form-control mb-3" placeholder="Designation">

    <input type="text" name="start_date" class="form-control mb-3" placeholder="Start Date">

    <input type="text" name="end_date" class="form-control mb-3" placeholder="End Date">

    <textarea name="description" class="form-control mb-3"></textarea>

    <button name="save" class="btn btn-success">
        Save Experience
    </button>

</form>