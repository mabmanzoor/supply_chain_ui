<?php
session_start();
require 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Simple query (no hash)
    $sql = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Yahan simple text compare ho raha hai
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user["id"];
            $_SESSION['username'] = $user["username"];
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Supply Chain System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
            <h4>Login</h4>
        </div>
        <div class="card-body">

            <?php if($error != ""): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Username</label>
                <input type="text" name="username" class="form-control mb-2" required value="">

                <label>Password</label>
                <input type="password" name="password" class="form-control mb-3" required value="">

                <button class="btn btn-primary w-100">Login</button>

                <a href="signup.php" class="btn btn-link w-100">Create New Account</a>
                <a href="forgot.php" class="btn btn-link w-100">Forgot Password?</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
