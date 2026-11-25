<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $icon_type = $_POST['icon_type']; // 'upload' ya 'link'
    $icon_value = '';

    // Logic for Image Link
    if ($icon_type === 'link') {
        $icon_value = trim($_POST['icon_link']);
        if (empty($icon_value) || !filter_var($icon_value, FILTER_VALIDATE_URL)) {
            $error = "Please enter a valid image URL.";
        }
    } 
    // Logic for File Upload
    else {
        if (isset($_FILES['icon_image']) && $_FILES['icon_image']['error'] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['icon_image']['tmp_name'];
            $file_name = $_FILES['icon_image']['name'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            $allowed_ext = ['png', 'jpg', 'jpeg', 'gif', 'svg'];
            
            if (in_array($file_ext, $allowed_ext)) {
                $new_file_name = uniqid('icon_') . '.' . $file_ext;
                $upload_dir = '../../assets/images/services/';
                
                // Folder na ho toh bana de
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $dest_path = $upload_dir . $new_file_name;
                
                if (move_uploaded_file($file_tmp, $dest_path)) {
                    $icon_value = $new_file_name;
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file format. Only PNG, JPG, GIF, SVG allowed.";
            }
        } else {
            $error = "Please upload an image.";
        }
    }

    // Insert into Database
    if (empty($error) && !empty($service_name) && !empty($description) && !empty($icon_value)) {
        try {
            $sql = "INSERT INTO services (service_name, description, icon) VALUES (:service_name, :description, :icon)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':service_name', $service_name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':icon', $icon_value); 
            
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $error = "Database insertion failed.";
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
        }
    } elseif(empty($error)) {
        $error = "Please fill in all text fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            <a href="../../logout.php" class="btn btn-sm btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-secondary"><i class="fa-solid fa-plus me-2"></i>Add New Service</h2>
                    <a href="index.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Back</a>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger shadow-sm"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Service Name</label>
                                <input type="text" class="form-control" name="service_name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold d-block">Icon Source</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="icon_type" id="type_upload" value="upload" checked onclick="toggleIconInput()">
                                    <label class="form-check-label" for="type_upload">Upload Image</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="icon_type" id="type_link" value="link" onclick="toggleIconInput()">
                                    <label class="form-check-label" for="type_link">Image URL / Link</label>
                                </div>
                            </div>

                            <div class="mb-3" id="upload_section">
                                <label class="form-label text-muted small">Select Image (PNG, JPG, SVG)</label>
                                <input class="form-control" type="file" name="icon_image" accept=".png, .jpg, .jpeg, .gif, .svg">
                            </div>

                            <div class="mb-3" id="link_section" style="display: none;">
                                <label class="form-label text-muted small">Paste Image URL (https://...)</label>
                                <input type="url" class="form-control" name="icon_link" placeholder="https://example.com/icon.png">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Description</label>
                                <textarea class="form-control" name="description" rows="5" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg"><i class="fa-solid fa-floppy-disk me-1"></i> Save Service</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleIconInput() {
            var isUpload = document.getElementById('type_upload').checked;
            document.getElementById('upload_section').style.display = isUpload ? 'block' : 'none';
            document.getElementById('link_section').style.display = isUpload ? 'none' : 'block';
        }
    </script>
</body>
</html>