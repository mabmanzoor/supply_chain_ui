<?php
require 'db.php';
require 'auth.php';

$msg = "";

// Drop-down ke liye retailers & products laao
$retailers = mysqli_query($conn, "SELECT * FROM Retailer ORDER BY retailer_name");
$products  = mysqli_query($conn, "SELECT * FROM Product ORDER BY product_name");

// Default dates (aaj + 7 din)
$today    = date('Y-m-d');
$deadline = date('Y-m-d', strtotime('+7 days'));

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $retailer_id = $_POST["retailer_id"];
    $product_id  = $_POST["product_id"];
    $quantity    = $_POST["quantity"];
    $order_date  = $_POST["order_date"];
    $deadline_date = $_POST["deadline_date"];
    $status      = $_POST["status"];

    $sql = "INSERT INTO CustomerOrder 
            (retailer_id, product_id, quantity, order_date, deadline_date, status)
            VALUES ('$retailer_id', '$product_id', '$quantity', '$order_date', '$deadline_date', '$status')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Order added successfully!";
        // Agar direct list par bhejna ho to uncomment:
        // header("Location: orders.php");
        // exit;
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Customer Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f7fb; }
        .card { box-shadow:0 3px 8px rgba(0,0,0,.15); margin-top:50px; }
    </style>
</head>
<body>
<div class="container" style="max-width:650px;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <b>Add New Customer Order</b>
        </div>
        <div class="card-body">

            <?php if($msg): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>

            <p class="text-muted">
                Retailer + Product select karo, quantity & dates fill karo. Save karne par order CustomerOrder table me chala jayega.
            </p>

            <form method="post">
                <!-- Retailer -->
                <div class="mb-3">
                    <label class="form-label">Retailer</label>
                    <select name="retailer_id" class="form-control" required>
                        <option value="">Select Retailer</option>
                        <?php while($r = mysqli_fetch_assoc($retailers)): ?>
                            <option value="<?= $r['retailer_id']; ?>">
                                <?= $r['retailer_name']; ?> (<?= $r['city']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Product -->
                <div class="mb-3">
                    <label class="form-label">Product</label>
                    <select name="product_id" class="form-control" required>
                        <option value="">Select Product</option>
                        <?php while($p = mysqli_fetch_assoc($products)): ?>
                            <option value="<?= $p['product_id']; ?>">
                                <?= $p['product_name']; ?> (<?= $p['unit_price']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Quantity -->
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>

                <!-- Dates -->
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Order Date</label>
                        <input type="date" name="order_date" class="form-control" value="<?= $today; ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Deadline Date</label>
                        <input type="date" name="deadline_date" class="form-control" value="<?= $deadline; ?>" required>
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <button class="btn btn-primary w-100">Save Order</button>
                <a href="orders.php" class="btn btn-link w-100 mt-2">Back to Orders List</a>

            </form>
        </div>
    </div>
</div>
</body>
</html>
