<?php

require_once('../../config/auth.php');
require_once('../../config/db.php');

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM projects WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$project = $result->fetch_assoc();

if(!$project){
    die("Project Not Found");
}

$message = '';

if(isset($_POST['update']))
{

$title = $_POST['title'];
$category = $_POST['category'];
$short_description = $_POST['short_description'];
$description = $_POST['description'];
$github_link = $_POST['github_link'];
$live_link = $_POST['live_link'];

$imageName = $project['image'];

if(!empty($_FILES['image']['name']))
{

    if(file_exists("../../uploads/projects/".$project['image']))
    {
        unlink("../../uploads/projects/".$project['image']);
    }

    $imageName = time().'_'.$_FILES['image']['name'];

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        '../../uploads/projects/'.$imageName
    );
}

$stmt = $conn->prepare("
UPDATE projects
SET
title=?,
category=?,
short_description=?,
description=?,
image=?,
github_link=?,
live_link=?
WHERE id=?
");

$stmt->bind_param(
"sssssssi",
$title,
$category,
$short_description,
$description,
$imageName,
$github_link,
$live_link,
$id
);

$stmt->execute();

header("Location: manage-projects.php");
exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">

        <h2>Edit Project</h2>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="title" value="<?= $project['title'] ?>" class="form-control mb-3">

            <input type="text" name="category" value="<?= $project['category'] ?>" class="form-control mb-3">

            <textarea name="short_description" class="form-control mb-3"><?= $project['short_description'] ?></textarea>

            <textarea name="description" class="form-control mb-3"><?= $project['description'] ?></textarea>

            <img src="../uploads/projects/<?= $project['image'] ?>" width="150" class="mb-3">

            <input type="file" name="image" class="form-control mb-3">

            <input type="url" name="github_link" value="<?= $project['github_link'] ?>" class="form-control mb-3">

            <input type="url" name="live_link" value="<?= $project['live_link'] ?>" class="form-control mb-3">

            <button name="update" class="btn btn-success">
                Update Project
            </button>

        </form>

    </div>

</body>

</html>