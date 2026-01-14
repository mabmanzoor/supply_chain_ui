<?php
require 'db.php';
require 'auth.php';

$msg = "";

// Get warehouse list
$warehouses = mysqli_query($conn, "SELECT * FROM Warehouse");

// Get product list
$products = mysqli_query($conn, "SELECT * FROM Product");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $warehouse_id = $_POST["warehouse_id"];
    $product_id   = $_POST["product_id"];
    $quantity     = $_POST["quantity"];
    $threshold    = $_POST["threshold"];

    $sql = "INSERT INTO Inventory (warehouse_id, product_id, quantity, reorder_threshold)
            VALUES ('$warehouse_id', '$product_id', '$quantity', '$threshold')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Inventory added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Inventory</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f4f7fb; }
.card { box-shadow:0 3px 8px rgba(0,0,0,.15); margin-top:50px; }
</style>
</head>

<body>
<div class="container" style="max-width:600px;">
<div class="card">
    <div class="card-header bg-primary text-white">Add Inventory</div>
    <div class="card-body">

        <?php if($msg): ?>
            <div class="alert alert-info"><?= $msg ?></div>
        <?php endif; ?>

        <form method="post">

            <label class="form-label">Select Warehouse</label>
            <select name="warehouse_id" class="form-control mb-3" required>
                <option value="">Select</option>
                <?php while($w = mysqli_fetch_assoc($warehouses)): ?>
                    <option value="<?= $w['warehouse_id']; ?>">
                        <?= $w['warehouse_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label class="form-label">Select Product</label>
            <select name="product_id" class="form-control mb-3" required>
                <option value="">Select</option>
                <?php while($p = mysqli_fetch_assoc($products)): ?>
                    <option value="<?= $p['product_id']; ?>">
                        <?= $p['product_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control mb-3" required>

            <label class="form-label">Reorder Threshold</label>
            <input type="number" name="threshold" class="form-control mb-3" required>

            <button class="btn btn-primary w-100">Save Inventory</button>

            <a href="inventory.php" class="btn btn-link w-100 mt-2">Back</a>
        </form>

    </div>
</div>
</div>
</body>
</html>
