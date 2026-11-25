<?php

require_once('../config/auth.php');
require_once('../config/db.php');

$result = mysqli_query(
$conn,
"SELECT * FROM experience ORDER BY id DESC"
);
?>

<h2>Experience List</h2>

<a href="add-experience.php" class="btn btn-primary mb-3">
    Add Experience
</a>

<table class="table table-bordered">

    <tr>

        <th>ID</th>
        <th>Company</th>
        <th>Designation</th>
        <th>Action</th>

    </tr>

    <?php while($row=mysqli_fetch_assoc($result)): ?>

    <tr>

        <td><?= $row['id'] ?></td>

        <td><?= $row['company_name'] ?></td>

        <td><?= $row['designation'] ?></td>

        <td>

            <a href="edit-experience.php?id=<?= $row['id'] ?>" class="btn btn-warning">
                Edit
            </a>

            <a href="delete-experience.php?id=<?= $row['id'] ?>" class="btn btn-danger">
                Delete
            </a>

        </td>

    </tr>

    <?php endwhile; ?>

</table>