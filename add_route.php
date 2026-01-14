<?php
require 'db.php';
require 'auth.php';

$msg1 = "";
$msg2 = "";

// Dropdowns ke liye data lao
$suppliers   = mysqli_query($conn, "SELECT * FROM Supplier ORDER BY supplier_name");
$warehouses  = mysqli_query($conn, "SELECT * FROM Warehouse ORDER BY warehouse_name");
$warehouses2 = mysqli_query($conn, "SELECT * FROM Warehouse ORDER BY warehouse_name"); // 2nd form ke liye
$retailers   = mysqli_query($conn, "SELECT * FROM Retailer ORDER BY retailer_name");

// Form handling
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ---------- Form 1: Supplier → Warehouse ----------
    if (isset($_POST['form_type']) && $_POST['form_type'] == 's_to_w') {

        $supplier_id  = $_POST['supplier_id'];
        $warehouse_id = $_POST['warehouse_id'];
        $cost         = $_POST['cost_per_unit'];

        $sql = "
            INSERT INTO Route (from_node_type, from_node_id, to_node_id, cost_per_unit)
            VALUES ('supplier', '$supplier_id', '$warehouse_id', '$cost')
        ";

        if (mysqli_query($conn, $sql)) {
            $msg1 = "Supplier → Warehouse route added successfully!";
        } else {
            $msg1 = "Error: " . mysqli_error($conn);
        }

    }

    // ---------- Form 2: Warehouse → Retailer ----------
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'w_to_r') {

        $warehouse_id = $_POST['warehouse_id2'];
        $retailer_id  = $_POST['retailer_id'];
        $cost2        = $_POST['cost_per_unit2'];

        $sql2 = "
            INSERT INTO Route (from_node_type, from_node_id, to_node_id, cost_per_unit)
            VALUES ('warehouse', '$warehouse_id', '$retailer_id', '$cost2')
        ";

        if (mysqli_query($conn, $sql2)) {
            $msg2 = "Warehouse → Retailer route added successfully!";
        } else {
            $msg2 = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Route</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f4f7fb; }
        .card { box-shadow:0 3px 8px rgba(0,0,0,.15); margin-top:30px; }
    </style>
</head>
<body>
<div class="container" style="max-width:900px;">

    <h3 class="mt-4">Add Routes</h3>
    <p class="text-muted">
        Neeche do forms hain: pehla Supplier → Warehouse route ke liye, doosra Warehouse → Retailer route ke liye.
    </p>

    <!-- Form 1: Supplier → Warehouse -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Supplier → Warehouse Route
        </div>
        <div class="card-body">

            <?php if($msg1): ?>
                <div class="alert alert-info"><?= $msg1; ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="form_type" value="s_to_w">

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Supplier</label>
                        <select name="supplier_id" class="form-control" required>
                            <option value="">Select Supplier</option>
                            <?php while($s = mysqli_fetch_assoc($suppliers)): ?>
                                <option value="<?= $s['supplier_id']; ?>">
                                    <?= $s['supplier_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col">
                        <label class="form-label">Warehouse</label>
                        <select name="warehouse_id" class="form-control" required>
                            <option value="">Select Warehouse</option>
                            <?php while($w = mysqli_fetch_assoc($warehouses)): ?>
                                <option value="<?= $w['warehouse_id']; ?>">
                                    <?= $w['warehouse_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cost Per Unit</label>
                    <input type="number" step="0.01" name="cost_per_unit" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">Save Supplier → Warehouse Route</button>
            </form>
        </div>
    </div>

    <!-- Form 2: Warehouse → Retailer -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            Warehouse → Retailer Route
        </div>
        <div class="card-body">

            <?php if($msg2): ?>
                <div class="alert alert-info"><?= $msg2; ?></div>
            <?php endif; ?>

            <form method="post">
                <input type="hidden" name="form_type" value="w_to_r">

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Warehouse</label>
                        <select name="warehouse_id2" class="form-control" required>
                            <option value="">Select Warehouse</option>
                            <?php while($w2 = mysqli_fetch_assoc($warehouses2)): ?>
                                <option value="<?= $w2['warehouse_id']; ?>">
                                    <?= $w2['warehouse_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col">
                        <label class="form-label">Retailer</label>
                        <select name="retailer_id" class="form-control" required>
                            <option value="">Select Retailer</option>
                            <?php while($r = mysqli_fetch_assoc($retailers)): ?>
                                <option value="<?= $r['retailer_id']; ?>">
                                    <?= $r['retailer_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cost Per Unit</label>
                    <input type="number" step="0.01" name="cost_per_unit2" class="form-control" required>
                </div>

                <button class="btn btn-success w-100">Save Warehouse → Retailer Route</button>
            </form>
        </div>
    </div>

    <a href="routes.php" class="btn btn-link mb-4">Back to Routes List</a>

</div>
</body>
</html>
