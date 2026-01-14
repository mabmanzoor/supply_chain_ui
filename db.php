<?php
// db.php
// Yahan se har page database se connect hoga

$host = "localhost";
$user = "root";          // XAMPP default user
$pass = "";              // XAMPP default password blank hota hai
$db   = "intelligent_supply_chain_db";  // tumhara DB name

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
