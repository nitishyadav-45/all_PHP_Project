<?php
require_once '../config.php';

// चेक करें कि यूजर लॉग इन है या नहीं
if (!isLoggedIn()) {
    redirect('../admin_login.php');
}

$user = getUserData();

$success_msg = "";
$error_msg = "";

// फॉर्म सबमिट होने पर डेटा प्रोसेस करने का लॉजिक
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // इनपुट डेटा को सुरक्षित करें (Sanitize)
    $name = $conn->real_escape_string($_POST['name']);
    $icon_class = $conn->real_escape_string($_POST['icon_class']);
    $description = $conn->real_escape_string($_POST['description']);

    // वैलिडेशन (Validation)
    if (empty($name) || empty($icon_class)) {
        $error_msg = "सर्विस का नाम और आइकॉन चुनना अनिवार्य है।";
    } else {
        // डेटाबेस में इंसर्ट करने की क्वेरी
        $insert_query = "INSERT INTO services (name, icon_class, description) VALUES ('$name', '$icon_class', '$description')";
        
        if ($conn->query($insert_query)) {
            $success_msg = "नई सर्विस सफलतापूर्वक जोड़ दी गई है!";
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
    <title>Add New Service | Admin Panel</title>
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
            max-width: 750px;
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
            background: linear-gradient(135deg, #20bf55 0%, #01baef 100%);
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
            border-color: #20bf55;
            box-shadow: 0 0 0 0.25rem rgba(32, 191, 85, 0.15);
        }
        .btn-submit {
            background: linear-gradient(135deg, #20bf55 0%, #01baef 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(32, 191, 85, 0.3);
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
        .icon-preview-box {
            font-size: 2rem;
            color: #20bf55;
            background: #f8f9fa;
            border: 1px solid #ced4da;
            border-radius: 8px;
            width: 60px;
            height: 54px;
            display: flex;
            align-items: center;
            justify-content: center;
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
                <h3 class="mb-1 fw-bold"><i class="bi bi-briefcase me-2"></i> Add New Service</h3>
                <p class="mb-0 opacity-75 style-sm">Add what professional services you offer to clients</p>
            </div>
            <i class="bi bi-gear-wide-connected fs-1 opacity-25"></i>
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

            <form action="" method="POST">
                
                <div class="mb-4">
                    <label for="name" class="form-label">Service Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="e.g., Web Development, UI/UX Design" required>
                </div>

                <div class="mb-4">
                    <label for="icon_class" class="form-label">Select Service Icon <span class="text-danger">*</span></label>
                    <div class="d-flex gap-3">
                        <select class="form-select" id="icon_class" name="icon_class" onchange="updateIconPreview(this.value)" required>
                            <option value="">-- Choose an Icon --</option>
                            <option value="bi-code-slash">Code Slash (Web Dev)</option>
                            <option value="bi-palette">Palette (Design)</option>
                            <option value="bi-search">Search (SEO)</option>
                            <option value="bi-phone">Phone (App Dev)</option>
                            <option value="bi-laptop">Laptop (Software)</option>
                            <option value="bi-graph-up-arrow">Graph Up (Marketing)</option>
                            <option value="bi-cart3">Cart (E-Commerce)</option>
                            <option value="bi-shield-check">Shield Check (Security)</option>
                            <option value="bi-database">Database (Backend)</option>
                        </select>
                        <div class="icon-preview-box" id="icon-preview">
                            <i class="bi bi-question-lg"></i>
                        </div>
                    </div>
                    <div class="form-text">Choose an icon that best represents your service.</div>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Explain what you offer in this service..."></textarea>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <div class="d-flex justify-content-end gap-3">
                    <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-plus-circle me-2"></i> Add Service
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function updateIconPreview(iconClass) {
    const previewBox = document.getElementById('icon-preview');
    if(iconClass) {
        previewBox.innerHTML = `<i class="bi ${iconClass}"></i>`;
    } else {
        previewBox.innerHTML = `<i class="bi bi-question-lg"></i>`;
    }
}
</script>
</body>
</html>