<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Fetch Existing Data
$stmt = $pdo->prepare("SELECT * FROM certificates WHERE id = ?");
$stmt->execute([$id]);
$cert = $stmt->fetch();

if (!$cert) {
    header("Location: index.php");
    exit;
}

// --- UPDATE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $issuer = sanitize($_POST['issuer']);
    $date_issued = $_POST['date_issued'];
    
    $imageName = $cert['image']; // Default keep old image

    // Handle New Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/images/certificates/';
        $newImageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $newImageName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Delete old image
            if (!empty($cert['image']) && file_exists($uploadDir . $cert['image'])) {
                unlink($uploadDir . $cert['image']);
            }
            $imageName = $newImageName; // Update DB with new image name
        }
    }
    
    $updateStmt = $pdo->prepare("UPDATE certificates SET title = ?, issuer = ?, date_issued = ?, image = ? WHERE id = ?");
    $updateStmt->execute([$title, $issuer, $date_issued, $imageName, $id]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Certificate | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-warning me-2"></i>Edit Certificate</h2>
            <a href="index.php" class="btn btn-outline-secondary px-4 rounded-pill">Cancel & Back</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Certificate Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($cert['title']); ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Issuing Organization</label>
                            <input type="text" name="issuer" class="form-control" value="<?php echo htmlspecialchars($cert['issuer']); ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Date Issued</label>
                            <input type="date" name="date_issued" class="form-control" value="<?php echo htmlspecialchars($cert['date_issued']); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Update Image (Leave blank to keep current)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <?php if(!empty($cert['image'])): ?>
                                <div class="mt-2 small text-muted d-flex align-items-center">
                                    Current Image: 
                                    <a href="../../assets/images/certificates/<?php echo htmlspecialchars($cert['image']); ?>" target="_blank" class="ms-2">
                                        <img src="../../assets/images/certificates/<?php echo htmlspecialchars($cert['image']); ?>" width="60" class="rounded border shadow-sm">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">Update Certificate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>