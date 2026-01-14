<?php
require 'db.php';
require 'auth.php';   // login protection

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data
    $name = $_POST["warehouse_name"];
    $city = $_POST["city"];

    // Insert Query
    $sql = "INSERT INTO Warehouse (warehouse_name, city)
            VALUES ('$name', '$city')";

    if (mysqli_query($conn, $sql)) {
        $msg = "Warehouse added successfully!";
    } else {
        $msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Warehouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f5f7fb;
    }

    .card {
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        margin-top: 50px;
    }
    </style>
</head>

<body>

    <div class="container" style="max-width:600px;">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <b>Add New Warehouse</b>
            </div>

            <div class="card-body">

                <?php if($msg): ?>
                <div class="alert alert-info"><?= $msg ?></div>
                <?php endif; ?>

                <p class="text-muted">
                    Fill in the form below. When you press Save, a new entry will be created in the Warehouse table.
                </p>

                <form method="post">

                    <div class="mb-3">
                        <label class="form-label">Warehouse Name</label>
                        <input type="text" name="warehouse_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Warehouse</button>

                    <a href="warehouses.php" class="btn btn-link w-100 mt-2">Back to Warehouses List</a>

                </form>

            </div>
        </div>
    </div>

</body>

</html>