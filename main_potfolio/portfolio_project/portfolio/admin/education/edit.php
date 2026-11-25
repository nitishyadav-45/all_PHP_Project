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
$stmt = $pdo->prepare("SELECT * FROM education WHERE id = ?");
$stmt->execute([$id]);
$edu = $stmt->fetch();

if (!$edu) {
    header("Location: index.php");
    exit;
}

// Extract Year from stored DATE format
$start_year_val = date('Y', strtotime($edu['start_date']));
$end_year_val = !empty($edu['end_date']) ? date('Y', strtotime($edu['end_date'])) : '';
// If end_date is NULL or empty, it means 'Present/Current'
$is_currently_studying = empty($edu['end_date']);

// --- UPDATE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institution = sanitize($_POST['institution']);
    $degree = sanitize($_POST['degree']);
    $description = sanitize($_POST['description']);
    
    $start_date = $_POST['start_year'] . '-01-01';
    
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    $end_date = ($is_current == 1 || empty($_POST['end_year'])) ? NULL : ($_POST['end_year'] . '-01-01');
    
    $updateStmt = $pdo->prepare("UPDATE education SET institution = ?, degree = ?, start_date = ?, end_date = ?, description = ? WHERE id = ?");
    $updateStmt->execute([$institution, $degree, $start_date, $end_date, $description, $id]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Education | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-edit text-primary me-2"></i>Edit Education</h2>
            <a href="index.php" class="btn btn-outline-secondary px-4 rounded-pill">Cancel & Back</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Institution / University</label>
                            <input type="text" name="institution" class="form-control" value="<?php echo htmlspecialchars($edu['institution']); ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Degree / Certificate</label>
                            <input type="text" name="degree" class="form-control" value="<?php echo htmlspecialchars($edu['degree']); ?>" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Start Year</label>
                            <input type="number" name="start_year" class="form-control" min="1950" max="2030" value="<?php echo htmlspecialchars($start_year_val); ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">End Year</label>
                            <input type="number" name="end_year" id="end_year" class="form-control" min="1950" max="2030" value="<?php echo htmlspecialchars($end_year_val); ?>" <?php echo $is_currently_studying ? 'disabled' : ''; ?>>
                        </div>

                        <div class="col-md-4 d-flex align-items-end pb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1" <?php echo $is_currently_studying ? 'checked' : ''; ?>>
                                <label class="form-check-label ms-2 fw-medium text-dark" for="is_current">Currently Studying Here</label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Description / Achievements</label>
                            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($edu['description']); ?></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">Update Education</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentCheckbox = document.getElementById('is_current');
            const endYearInput = document.getElementById('end_year');

            currentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    endYearInput.value = ''; 
                    endYearInput.disabled = true; 
                } else {
                    endYearInput.disabled = false; 
                }
            });
        });
    </script>
</body>
</html>