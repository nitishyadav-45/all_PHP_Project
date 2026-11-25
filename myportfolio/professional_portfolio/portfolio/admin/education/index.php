<?php
require_once '../../includes/auth.php';
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkAuth();

$education = getEducation($pdo);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM education WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $institution = sanitize($_POST['institution']);
    $degree = sanitize($_POST['degree']);
    $year = sanitize($_POST['year']);

    $stmt = $pdo->prepare("INSERT INTO education (institution, degree, year) VALUES (?, ?, ?)");
    $stmt->execute([$institution, $degree, $year]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Education - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Education</h2>
            <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white fw-bold">Add New Education</div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Degree</label>
                            <input type="text" name="degree" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Institution</label>
                            <input type="text" name="institution" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Year</label>
                            <input type="text" name="year" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Education</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Degree</th>
                            <th>Institution</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($education as $edu): ?>
                        <tr>
                            <td><?php echo $edu['degree']; ?></td>
                            <td><?php echo $edu['institution']; ?></td>
                            <td><?php echo $edu['year']; ?></td>
                            <td>
                                <a href="?delete=<?php echo $edu['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
