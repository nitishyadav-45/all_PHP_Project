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
    $percentage = intval($_POST['percentage']);

    // वैलिडेशन (Validation)
    if (empty($name)) {
        $error_msg = "स्किल का नाम लिखना अनिवार्य है।";
    } elseif ($percentage < 0 || $percentage > 100) {
        $error_msg = "स्किल का प्रतिशत 0 से 100 के बीच ही होना चाहिए।";
    } else {
        // डेटाबेस में इंसर्ट करने की क्वेरी
        $insert_query = "INSERT INTO skills (name, percentage) VALUES ('$name', $percentage)";
        
        if ($conn->query($insert_query)) {
            $success_msg = "नई स्किल सफलतापूर्वक जोड़ दी गई है!";
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
    <title>Add New Skill | Admin Panel</title>
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
            max-width: 700px;
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
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%);
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            color: white;
            padding: 25px;
            border: none;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #fda085;
            box-shadow: 0 0 0 0.25rem rgba(253, 160, 133, 0.2);
        }
        /* रेंज स्लाइडर को कस्टमाइज करना */
        .form-range::-webkit-slider-thumb {
            background: #fda085;
        }
        .form-range::-moz-range-thumb {
            background: #fda085;
        }
        .btn-submit {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(253, 160, 133, 0.4);
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
        .preview-box {
            background: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 8px;
            padding: 20px;
        }
        .progress {
            height: 12px;
            border-radius: 6px;
            background-color: #e9ecef;
        }
        .progress-bar {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            border-radius: 6px;
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
                <h3 class="mb-1 fw-bold"><i class="bi bi-star me-2"></i> Add New Skill</h3>
                <p class="mb-0 opacity-75 style-sm">Add your technical expertise and proficiency levels</p>
            </div>
            <i class="bi bi-award fs-1 opacity-25"></i>
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
                    <label for="name" class="form-label">Skill Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" oninput="updateLivePreview()" placeholder="e.g., PHP, React.js, UI Design" required>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="percentage" class="form-label mb-0">Proficiency Percentage <span class="text-danger">*</span></label>
                        <span class="badge bg-dark fs-6" id="percentage-val">80%</span>
                    </div>
                    <input type="range" class="form-range" id="percentage" name="percentage" min="0" max="100" value="80" oninput="updateLivePreview()">
                    <div class="form-text">Slide to select how good you are at this skill.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small text-uppercase">Live Preview (How it looks on website)</label>
                    <div class="preview-box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold text-secondary" id="preview-title">Your Skill</span>
                            <span class="fw-bold" style="color: #fda085;" id="preview-percent">80%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" id="preview-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">

                <div class="d-flex justify-content-end gap-3">
                    <a href="dashboard.php" class="btn btn-cancel">Cancel</a>
                    <button type="submit" class="btn btn-submit">
                        <i class="bi bi-plus-circle me-2"></i> Add Skill
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function updateLivePreview() {
    const skillNameInput = document.getElementById('name').value;
    const percentageInput = document.getElementById('percentage').value;
    
    // टेक्स्ट और प्रोग्रेस अपडेट करें
    document.getElementById('percentage-val').innerText = percentageInput + '%';
    document.getElementById('preview-percent').innerText = percentageInput + '%';
    document.getElementById('preview-bar').style.width = percentageInput + '%';
    document.getElementById('preview-bar').setAttribute('aria-valuenow', percentageInput);
    
    if(skillNameInput.trim() !== "") {
        document.getElementById('preview-title').innerText = skillNameInput;
    } else {
        document.getElementById('preview-title').innerText = "Your Skill";
    }
}
</script>
</body>
</html>