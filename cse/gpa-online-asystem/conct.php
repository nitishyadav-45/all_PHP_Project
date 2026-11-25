<?php
include("config/database.php");

$success = "";
$error = "";

if(isset($_POST['send_message'])){

    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // 🔒 Basic Validation
    if(empty($name) || empty($mobile) || empty($email) || empty($subject) || empty($message)){
        $error = "All fields are required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = "Invalid email format!";
    }
    elseif(!preg_match("/^[0-9]{10}$/",$mobile)){
        $error = "Mobile number must be 10 digits!";
    }
    else{
        $query = "INSERT INTO enquiries (name,mobile,email,subject,message) 
                  VALUES ('$name','$mobile','$email','$subject','$message')";
        if(mysqli_query($conn,$query)){
            $success = "Your enquiry has been sent successfully!";
        } else {
            $error = "Something went wrong. Try again!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#667eea,#764ba2);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .contact-card{
            background:white;
            border-radius:20px;
            padding:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.2);
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn{
            from{opacity:0; transform:translateY(20px);}
            to{opacity:1; transform:translateY(0);}
        }
        .form-control:focus{
            box-shadow:0 0 10px rgba(102,126,234,0.5);
            border-color:#667eea;
        }
        .btn-custom{
            background:#667eea;
            color:white;
            border-radius:30px;
        }
        .btn-custom:hover{
            background:#5a67d8;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="contact-card">

                <h3 class="text-center mb-4">📩 Contact Us</h3>

                <!-- Bootstrap Alerts -->
                <?php if($success){ ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php } ?>

                <?php if($error){ ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required pattern="[A-Za-z ]+">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="mobile" class="form-control" required pattern="[0-9]{10}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" rows="4" class="form-control" required></textarea>
                    </div>

                    <button type="submit" name="send_message" class="btn btn-custom w-100">
                        Send Message
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>
