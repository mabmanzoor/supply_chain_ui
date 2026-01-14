<?php
require 'db.php';
require 'auth.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = $_POST["product_name"];
    $price = $_POST["unit_price"];

    $sql = "INSERT INTO Product (product_name, unit_price)
            VALUES ('$name', '$price')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Product added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f4f7fb; }
.card { box-shadow:0 3px 8px rgba(0,0,0,.15); margin-top:50px; }
</style>
</head>
<body>
<div class="container" style="max-width:600px;">
<div class="card">
    <div class="card-header bg-primary text-white">Add New Product</div>
    <div class="card-body">

        <?php if($msg): ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php endif; ?>

        <form method="post">
            <label class="form-label">Product Name</label>
            <input type="text" name="product_name" class="form-control mb-2" required>

            <label class="form-label">Unit Price</label>
            <input type="number" step="0.01" name="unit_price" class="form-control mb-3" required>

            <button class="btn btn-primary w-100">Save</button>
            <a href="products.php" class="btn btn-link w-100">Back</a>
        </form>

    </div>
</div>
</div>
</body>
</html>
