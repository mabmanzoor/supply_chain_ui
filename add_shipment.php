<?php
require 'db.php';
require 'auth.php';

$msg = "";

// Dropdown ke liye orders (join retailer + product taake naam dikh jaye)
$orders = mysqli_query($conn, "
    SELECT 
        co.order_id,
        r.retailer_name,
        p.product_name,
        co.quantity,
        co.status
    FROM CustomerOrder co
    JOIN Retailer r ON r.retailer_id = co.retailer_id
    JOIN Product p  ON p.product_id = co.product_id
    ORDER BY co.order_id DESC
");

// Warehouses dropdown
$warehouses = mysqli_query($conn, "SELECT * FROM Warehouse ORDER BY warehouse_name");

// Default date: aaj
$today = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $order_id    = $_POST['order_id'];
    $warehouse_id = $_POST['from_warehouse_id'];
    $cost_per_unit = $_POST['transport_cost_per_unit'];
    $shipment_date  = $_POST['shipment_date'];

    // Order se retailer_id, product_id, quantity nikaal lo
    $order_q = mysqli_query($conn, "
        SELECT retailer_id, product_id, quantity
        FROM CustomerOrder
        WHERE order_id = '$order_id' LIMIT 1
    ");

    if ($order_q && mysqli_num_rows($order_q) == 1) {
        $order_row = mysqli_fetch_assoc($order_q);

        $to_retailer_id = $order_row['retailer_id'];
        $product_id     = $order_row['product_id'];
        $quantity       = $order_row['quantity'];

        $insert = "
            INSERT INTO Shipment 
            (order_id, from_warehouse_id, to_retailer_id, product_id, quantity, transport_cost_per_unit, shipment_date)
            VALUES
            ('$order_id', '$warehouse_id', '$to_retailer_id', '$product_id', '$quantity', '$cost_per_unit', '$shipment_date')
        ";

        if (mysqli_query($conn, $insert)) {
            $msg = "Shipment added successfully!";
            // agar direct list pe bhejna ho:
            // header('Location: shipments.php'); exit;
        } else {
            $msg = "Error inserting shipment: " . mysqli_error($conn);
        }

    } else {
        $msg = "Selected order not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Shipment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f7fb; }
        .card { box-shadow:0 3px 8px rgba(0,0,0,.15); margin-top:50px; }
    </style>
</head>
<body>
<div class="container" style="max-width:700px;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <b>Add New Shipment</b>
        </div>
        <div class="card-body">

            <?php if($msg): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>

            <p class="text-muted">
                Pehle order select karein, phir kis warehouse se ship karna hai select karein,
                transport cost aur date fill kar dein. System order se retailer, product aur quantity
                automatically le lega.
            </p>

            <form method="post">

                <!-- Order dropdown -->
                <div class="mb-3">
                    <label class="form-label">Select Order</label>
                    <select name="order_id" class="form-control" required>
                        <option value="">Select Order</option>
                        <?php while($o = mysqli_fetch_assoc($orders)): ?>
                            <option value="<?= $o['order_id']; ?>">
                                #<?= $o['order_id']; ?> -
                                <?= $o['retailer_name']; ?> |
                                <?= $o['product_name']; ?> |
                                Qty: <?= $o['quantity']; ?> |
                                Status: <?= $o['status']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- From warehouse -->
                <div class="mb-3">
                    <label class="form-label">From Warehouse</label>
                    <select name="from_warehouse_id" class="form-control" required>
                        <option value="">Select Warehouse</option>
                        <?php while($w = mysqli_fetch_assoc($warehouses)): ?>
                            <option value="<?= $w['warehouse_id']; ?>">
                                <?= $w['warehouse_name']; ?> (<?= $w['city']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Cost per unit -->
                <div class="mb-3">
                    <label class="form-label">Transport Cost Per Unit</label>
                    <input type="number" step="0.01" name="transport_cost_per_unit" 
                           class="form-control" required>
                </div>

                <!-- Date -->
                <div class="mb-3">
                    <label class="form-label">Shipment Date</label>
                    <input type="date" name="shipment_date" class="form-control" 
                           value="<?= $today; ?>" required>
                </div>

                <button class="btn btn-primary w-100">Save Shipment</button>
                <a href="shipments.php" class="btn btn-link w-100 mt-2">Back to Shipments List</a>

            </form>

        </div>
    </div>
</div>
</body>
</html>
