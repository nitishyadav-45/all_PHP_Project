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
$stmt = $pdo->prepare("SELECT * FROM experiences WHERE id = ?");
$stmt->execute([$id]);
$exp = $stmt->fetch();

if (!$exp) {
    header("Location: index.php");
    exit;
}

// --- UPDATE EXPERIENCE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = sanitize($_POST['company']);
    $position = sanitize($_POST['position']);
    $start_date = $_POST['start_date'];
    $description = sanitize($_POST['description']);
    
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    $end_date = ($is_current == 1 || empty($_POST['end_date'])) ? NULL : $_POST['end_date'];
    
    $updateStmt = $pdo->prepare("UPDATE experiences SET company = ?, position = ?, start_date = ?, end_date = ?, is_current = ?, description = ? WHERE id = ?");
    $updateStmt->execute([$company, $position, $start_date, $end_date, $is_current, $description, $id]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Experience | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-primary me-2"></i>Edit Experience</h2>
            <a href="index.php" class="btn btn-outline-secondary px-4 rounded-pill">Cancel & Back</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Company Name</label>
                            <input type="text" name="company" class="form-control" value="<?php echo htmlspecialchars($exp['company']); ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Position / Job Title</label>
                            <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($exp['position']); ?>" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Start Date</label>
                            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($exp['start_date']); ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo $exp['end_date'] ? htmlspecialchars($exp['end_date']) : ''; ?>" <?php echo $exp['is_current'] ? 'disabled' : ''; ?>>
                        </div>

                        <div class="col-md-4 d-flex align-items-end pb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1" <?php echo $exp['is_current'] ? 'checked' : ''; ?>>
                                <label class="form-check-label ms-2 fw-medium text-dark" for="is_current">I currently work here</label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Job Description</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($exp['description']); ?></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">Update Experience</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentCheckbox = document.getElementById('is_current');
            const endDateInput = document.getElementById('end_date');

            currentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    endDateInput.value = ''; 
                    endDateInput.disabled = true; 
                } else {
                    endDateInput.disabled = false; 
                }
            });
        });
    </script>
</body>
</html>