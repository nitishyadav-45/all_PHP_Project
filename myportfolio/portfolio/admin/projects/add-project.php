<?php

require_once('../../config/auth.php');
require_once('../../config/db.php');

$message = '';

if(isset($_POST['save']))
{

$title = $_POST['title'];
$category = $_POST['category'];
$short_description = $_POST['short_description'];
$description = $_POST['description'];
$github_link = $_POST['github_link'];
$live_link = $_POST['live_link'];

$imageName = '';

if(!empty($_FILES['image']['name']))
{

$imageName = time().'_'.$_FILES['image']['name'];

move_uploaded_file(
$_FILES['image']['tmp_name'],
'../../uploads/projects/'.$imageName
);

}

$stmt = $conn->prepare("
INSERT INTO projects
(
title,
category,
short_description,
description,
image,
github_link,
live_link
)
VALUES(?,?,?,?,?,?,?)
");

$stmt->bind_param(
"sssssss",
$title,
$category,
$short_description,
$description,
$imageName,
$github_link,
$live_link
);

$stmt->execute();

$message = "Project Added Successfully";

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Add Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container mt-5">

        <h2>Add New Project</h2>

        <?php if($message): ?>
        <div class="alert alert-success">
            <?= $message ?>
        </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Project Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <input type="text" name="category" class="form-control">
            </div>

            <div class="mb-3">
                <label>Short Description</label>
                <textarea name="short_description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Full Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Project Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label>Github Link</label>
                <input type="url" name="github_link" class="form-control">
            </div>

            <div class="mb-3">
                <label>Live Demo Link</label>
                <input type="url" name="live_link" class="form-control">
            </div>

            <button name="save" class="btn btn-success">
                Save Project
            </button>

        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if($message): ?>

<script>

Swal.fire({
icon:'success',
title:'Success',
text:'Project Added Successfully'
});

</script>

<?php endif; ?>

</body>

</html>