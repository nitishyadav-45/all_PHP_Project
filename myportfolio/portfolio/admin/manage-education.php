<?php

require_once('../config/auth.php');
require_once('../config/db.php');

$result = mysqli_query(
$conn,
"SELECT * FROM education ORDER BY id DESC"
);

?>

<h2>Education List</h2>

<a href="add-education.php" class="btn btn-primary mb-3">
    Add Education
</a>

<table class="table table-bordered">

    <tr>
        <th>ID</th>
        <th>Degree</th>
        <th>Institute</th>
        <th>Action</th>
    </tr>

    <?php while($row=mysqli_fetch_assoc($result)): ?>

    <tr>

        <td><?= $row['id'] ?></td>

        <td><?= $row['degree'] ?></td>

        <td><?= $row['institute'] ?></td>

        <td>

            <a href="edit-education.php?id=<?= $row['id'] ?>" class="btn btn-warning">
                Edit
            </a>

            <a href="delete-education.php?id=<?= $row['id'] ?>" class="btn btn-danger">
                Delete
            </a>

        </td>

    </tr>

    <?php endwhile; ?>

</table>