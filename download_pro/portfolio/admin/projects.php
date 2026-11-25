<?php
require_once '../config.php';

// चेक करें कि यूजर लॉग इन है या नहीं
if (!isLoggedIn()) {
    redirect('../admin_login.php');
}

$user = getUserData();

// डेटाबेस से सभी कैटेगरीज लेकर आएं ताकि ड्रॉपडाउन में दिखा सकें
$categories_query = "SELECT id, name FROM project_categories ORDER BY name ASC";
$categories_result = $conn->query($categories_query);

// फॉर्म सबमिट होने पर डेटा प्रोसेस करने का लॉजिक
$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // इनपुट डेटा को सुरक्षित करें (Sanitize)
    $title = $conn->real_escape_string($_POST['title']);
    $category_id = !empty($_POST['category_id']) ? intval($_POST['category_id']) : "NULL";
    $description = $conn->real_escape_string($_POST['description']);
    $live_link = $conn->real_escape_string($_POST['live_link']);
    $github_link = $conn->real_escape_string($_POST['github_link']);
    
    // इमेज अपलोड हैंडलिंग
    $image_name = "";
    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == 0) {
        $target_dir = "../uploads/projects/";
        
        // अगर फोल्डर नहीं बना है तो बना दें
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["project_image"]["name"], PATHINFO_EXTENSION);
        // इमेज का नाम यूनिक रखें ताकि ओवरराइट न हो
        $image_name = time() . '_' . uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $image_name;
        
        // सिर्फ इमेज फाइल्स अलाउ करें
        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array(strtolower($file_extension), $allowed_types)) {
            move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file);
        } else {
            $error_msg = "सिर्फ JPG, JPEG, PNG और WEBP इमेजेस ही अपलोड की जा सकती हैं।";
        }
    }

    // अगर कोई एरर नहीं है तो डेटाबेस में इंसर्ट करें
    if (empty($error_msg)) {
        $insert_query = "INSERT INTO projects (category_id, title, description, image, live_link, github_link) 
                         VALUES ($category_id, '$title', '$description', '$image_name', '$live_link', '$github_link')";
        
        if ($conn->query($insert_query)) {
            $success_msg = "प्रोजेक्ट सफलतापूर्वक जोड़ दिया गया है!";
        } else {
            $error_msg = "डेटाबेस एरर: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Project | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .main-container {
            max-width: 850px;
            margin: 50px auto;
            padding: 0 20px;
        }
        .card-custom {
            background: #ffffff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .card-header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border: none;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #764ba2;
            box-shadow: 0 0 0 0.25rem rgba(118, 75, 162, 0.15);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-cancel {
            background: #e9ecef;
            color: #495057;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-cancel:hover {
            background: #dee2e6;
            color: #212529;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="mb-4">
        <a href="dashboard.php" class="text-decoration-none text-muted fw-medium">
            <i class="bi bi-arrow-left-short fs-4 align-middle"></i> Back to Dashboard
        </a>
    </div>

    <div class="card card-custom">
        <div class="card-header-gradient d-flex align-items-center justify-content-between">
            <div>
                <h3 class="mb-1 fw-bold"><i class="bi bi-folder-plus me-2"></i> Add New Project</h3>
                <p class="mb-0 opacity-75 style-sm">Showcase your latest work in your portfolio</p>
            </div>
            <i class="bi bi-file-earmark-code fs-1 opacity-25"></i>
        </div>

        <div class="card-body p-4 p-md-5">
            
            <?php if (!empty($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?php echo $success_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_msg)): ?>
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                
                <div class="row">
                    <div class="col-md-7 mb-4">
                        <label for="title" class="form-label">Project Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="e.g., E-Commerce Platform" required>
                    </div>

                    <div class="col-md-5 mb-4">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            <?php if ($categories_result && $categories_result->num_rows > 0): ?>
                                <?php while($row = $categories_result->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the project features, tech stack used, etc..." require></textarea>
                </div>

                <div class="mb-4">
                    <label for="project_image" class="form-label">Project Image / Thumbnail</label>
                    <input type="file" class="form-construct form-control" id="project_image" name="project_image" accept="image/*">
                    <div class="form-text">Recommended size: 800x600px (Max 2MB). Allowed extensions: JPG, PNG, WEBP.</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="live_link" class="form-label">Live Preview URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-globe"></i></span>
                            <input type="url" class="form-control" id="live_link" name="live_link" placeholder="https://example.com">
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="github_link" class="form-label">GitHub Repository URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-github"></i></span>
                            <input type="url" class="form-control" id="github_link" name="github_link" placeholder="https://github.com/username/repo">
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <div class="d-flex justify-content-end gap-3">
                    <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-cloud-arrow-up me-2"></i> Save Project
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>