<?php
session_start();
require 'db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $newpass  = $_POST["newpass"];

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($check) == 1) {
        $update = mysqli_query($conn, 
            "UPDATE users SET password='$newpass' WHERE username='$username'");
        $msg = "Password reset ho gaya! Ab new password se login karein.";
    } else {
        $msg = "User nahi mila!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password - Supply Chain System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark text-center">
            <h4>Reset Password</h4>
        </div>
        <div class="card-body">
            <?php if($msg != ""): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Username</label>
                <input type="text" name="username" class="form-control mb-2" required>

                <label>New Password</label>
                <input type="password" name="newpass" class="form-control mb-3" required>

                <button class="btn btn-warning w-100">Reset Password</button>
                <a href="login.php" class="btn btn-link w-100">Back to Login</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
