<?php

require_once('../../config/auth.php');
require_once('../../config/db.php');

if(isset($_POST['save']))
{

$skill = $_POST['skill_name'];
$percentage = $_POST['percentage'];

$stmt = $conn->prepare(
"INSERT INTO skills(skill_name,percentage)
VALUES(?,?)"
);

$stmt->bind_param(
"si",
$skill,
$percentage
);

$stmt->execute();

header("Location:index.php");

}
?>

<form method="POST">

    <div class="mb-3">

        <label>Skill Name</label>

        <input type="text" name="skill_name" class="form-control">

    </div>

    <div class="mb-3">

        <label>Percentage</label>

        <input type="number" name="percentage" class="form-control">

    </div>

    <button name="save" class="btn btn-success">

        Save Skill

    </button>

</form>