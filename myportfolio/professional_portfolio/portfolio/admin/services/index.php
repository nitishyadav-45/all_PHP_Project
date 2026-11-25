<?php
require_once '../../includes/auth.php';
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkAuth();

$services = getServices($pdo);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $icon = sanitize($_POST['icon']);
    $description = $_POST['description'];

    $stmt = $pdo->prepare("INSERT INTO services (title, icon, description) VALUES (?, ?, ?)");
    $stmt->execute([$title, $icon, $description]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Services</h2>
            <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white fw-bold">Add New Service</div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon Class (FontAwesome)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-code" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php foreach($services as $service): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="<?php echo $service['icon']; ?> fa-3x text-primary mb-3"></i>
                        <h5><?php echo $service['title']; ?></h5>
                        <p class="text-muted small"><?php echo $service['description']; ?></p>
                        <a href="?delete=<?php echo $service['id']; ?>" class="btn btn-outline-danger btn-sm">Delete</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
