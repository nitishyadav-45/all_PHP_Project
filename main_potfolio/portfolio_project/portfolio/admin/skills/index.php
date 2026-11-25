<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['skill_name']);
    $percentage = sanitize($_POST['percentage']);
    
    $stmt = $pdo->prepare("INSERT INTO skills (skill_name, percentage) VALUES (?, ?)");
    $stmt->execute([$name, $percentage]);
}

$skills = getSkills($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Skills | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between mb-4">
            <h3>Manage Skills</h3>
            <a href="../dashboard.php" class="btn btn-secondary">Back</a>
        </div>
        
        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <div class="col-md-6">
                        <input type="text" name="skill_name" class="form-control" placeholder="Skill Name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="percentage" class="form-control" placeholder="Percentage (0-100)" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Add Skill</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Skill</th>
                            <th>Percentage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($skills as $skill): ?>
                        <tr>
                            <td><?php echo $skill['skill_name']; ?></td>
                            <td><?php echo $skill['percentage']; ?>%</td>
                            <td>
                                <a href="?delete=<?php echo $skill['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
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
