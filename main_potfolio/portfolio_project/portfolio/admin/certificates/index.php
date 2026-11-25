<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

// --- DELETE CERTIFICATE LOGIC ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Pehle image ka path get karein taki server se bhi delete ho sake
    $stmt = $pdo->prepare("SELECT image FROM certificates WHERE id = ?");
    $stmt->execute([$id]);
    $cert = $stmt->fetch();
    
    if ($cert && !empty($cert['image']) && file_exists('../../assets/images/certificates/' . $cert['image'])) {
        unlink('../../assets/images/certificates/' . $cert['image']); // Server se delete
    }

    $stmt = $pdo->prepare("DELETE FROM certificates WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// --- ADD CERTIFICATE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $issuer = sanitize($_POST['issuer']);
    $date_issued = $_POST['date_issued'];
    
    // Image Upload Logic
    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/images/certificates/';
        
        // Folder nahi hai to bana dein
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = $uploadDir . $imageName;
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imageName = ''; // Failed to upload
        }
    }
    
    $stmt = $pdo->prepare("INSERT INTO certificates (title, issuer, date_issued, image) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $issuer, $date_issued, $imageName]);
    
    header("Location: index.php");
    exit;
}

// Fetch all certificates
$stmt = $pdo->query("SELECT * FROM certificates ORDER BY date_issued DESC");
$certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Certificates | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { border: none; border-radius: 12px; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; transition: 0.3s; }
        .cert-img { width: 80px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #ddd; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-certificate text-warning me-2"></i>Manage Certificates</h2>
            <a href="../dashboard.php" class="btn btn-outline-secondary px-4 rounded-pill">Back to Dashboard</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-primary">Add New Certificate</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Certificate Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. AWS Certified Solutions Architect" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Issuing Organization</label>
                            <input type="text" name="issuer" class="form-control" placeholder="e.g. Amazon Web Services, Coursera" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Date Issued</label>
                            <input type="date" name="date_issued" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Certificate Image / Proof</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Upload Certificate</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-dark">My Certificates</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Issuer</th>
                                <th>Issue Date</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($certificates)): ?>
                                <?php foreach($certificates as $cert): ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($cert['image'])): ?>
                                            <a href="../../assets/images/certificates/<?php echo htmlspecialchars($cert['image']); ?>" target="_blank">
                                                <img src="../../assets/images/certificates/<?php echo htmlspecialchars($cert['image']); ?>" class="cert-img shadow-sm" alt="Certificate">
                                            </a>
                                        <?php else: ?>
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center cert-img shadow-sm" style="font-size: 10px;">No Img</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($cert['title']); ?></td>
                                    <td class="text-muted"><?php echo htmlspecialchars($cert['issuer']); ?></td>
                                    <td>
                                        <span class="small bg-light px-2 py-1 rounded border fw-medium">
                                            <?php echo date('F Y', strtotime($cert['date_issued'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="edit.php?id=<?php echo $cert['id']; ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                                        <a href="?delete=<?php echo $cert['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this certificate?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No certificates uploaded yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>