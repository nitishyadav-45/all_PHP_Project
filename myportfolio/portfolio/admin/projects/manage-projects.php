<?php

require_once('../../config/auth.php');
require_once('../../config/db.php');

$projects = mysqli_query(
$conn,
"SELECT * FROM projects ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Projects</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

</head>

<body>

    <div class="container mt-5">

    <table id="projectTable" class="table table-bordered">

        <h2>Manage Projects</h2>

        <table class="table table-bordered">

            <tr>

                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Action</th>

            </tr>

            <?php while($row=mysqli_fetch_assoc($projects)): ?>

            <tr>

                <td><?= $row['id'] ?></td>

                <td>

                    <img src="../../uploads/projects/<?= $row['image'] ?>" width="100">

                </td>

                <td><?= $row['title'] ?></td>

                <td><?= $row['category'] ?></td>

                <td>

                    <a href="edit-project.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <a href="delete-project.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete Project?')">
                        Delete
                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
$('#projectTable').DataTable();
});
</script>

</body>

</html>