<?php
session_start();
require 'db.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $password = $_POST["password"];  // plain text

    $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($check) > 0) {
        $msg = "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password, email) 
                VALUES ('$username', '$password', '$email')";
        if (mysqli_query($conn, $sql)) {
            $msg = "Account created successfully! Ab login karein.";
        } else {
            $msg = "Error creating account.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup - Supply Chain System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            <h4>Create Account</h4>
        </div>
        <div class="card-body">
            <?php if($msg != ""): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Username</label>
                <input type="text" name="username" class="form-control mb-2" required>

                <label>Email</label>
                <input type="email" name="email" class="form-control mb-2" required>

                <label>Password</label>
                <input type="password" name="password" class="form-control mb-3" required>

                <button class="btn btn-primary w-100">Sign Up</button>
                <a href="login.php" class="btn btn-link w-100">Back to Login</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
