<?php
require_once '../../includes/auth.php';
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkAuth();

$certificates = getCertificates($pdo);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM certificates WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $issuer = sanitize($_POST['issuer']);
    $date = sanitize($_POST['date']);
    
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../uploads/certificates/";
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);
    }

    $stmt = $pdo->prepare("INSERT INTO certificates (title, issuer, date, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $issuer, $date, $image]);
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Certificates - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Certificates</h2>
            <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white fw-bold">Add New Certificate</div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Issuer</label>
                            <input type="text" name="issuer" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date</label>
                            <input type="text" name="date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Certificate</button>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Issuer</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($certificates as $cert): ?>
                        <tr>
                            <td><?php echo $cert['title']; ?></td>
                            <td><?php echo $cert['issuer']; ?></td>
                            <td><?php echo $cert['date']; ?></td>
                            <td>
                                <a href="?delete=<?php echo $cert['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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
