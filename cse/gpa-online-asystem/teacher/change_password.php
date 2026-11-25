<?php
session_start();
include("../config/database.php");

$msg = "";

if(isset($_POST['change_pass'])){
    $email = $_POST['email'];
    $old = $_POST['old_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    $res = mysqli_query($conn,"SELECT * FROM teachers WHERE email='$email'");
    if(mysqli_num_rows($res)==1){
        $row = mysqli_fetch_assoc($res);

        if(password_verify($old, $row['password'])){
            if($new === $confirm){
                $newHash = password_hash($new, PASSWORD_DEFAULT);
                mysqli_query($conn,"UPDATE teachers SET password='$newHash' WHERE email='$email'");
                $msg = "<div class='alert alert-success'>Password updated successfully</div>";
                echo "<script> setTimeout(function(){window.location.href = '../auth/login.php';}, 2000); </script>";
            } else {
                $msg = "<div class='alert alert-danger'>New passwords do not match</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Old password incorrect</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Email not found</div>";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        
            /* background: linear-gradient(135deg, #e74a3b, #f6c23e); */
            background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);

        

    }

    .card {
        border-radius: 15px;
    }

    .toggle-eye {
        cursor: pointer;
        position: absolute;
        right: 15px;
        top: 38px;
    }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4 shadow">
                    <h4 class="text-center mb-3"> Student Change Password</h4>
                    <?php echo $msg; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Old Password</label>
                            <input type="password" name="old_password" id="oldPass" class="form-control" required>
                            <span class="toggle-eye" onclick="togglePass('oldPass',this)">👁</span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>New Password</label>
                            <input type="password" name="new_password" id="newPass" class="form-control" required>
                            <span class="toggle-eye" onclick="togglePass('newPass',this)">👁</span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirmPass" class="form-control"
                                required>
                            <span class="toggle-eye" onclick="togglePass('confirmPass',this)">👁</span>
                        </div>

                        <button type="submit" name="change_pass" class="btn btn-primary w-100">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePass(id, el) {
        let input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
    </script>
</body>

</html>