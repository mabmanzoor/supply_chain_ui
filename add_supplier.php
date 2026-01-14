<?php
require 'db.php';
require 'auth.php';   // login check

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form se values uthao
    $name    = $_POST["supplier_name"];
    $city    = $_POST["city"];
    $contact = $_POST["contact_info"];

    // Simple INSERT query
    $sql = "INSERT INTO Supplier (supplier_name, city, contact_info)
            VALUES ('$name', '$city', '$contact')";

    if (mysqli_query($conn, $sql)) {
        // Success message
        $msg = "Supplier added successfully!";

        // Optionally suppliers list par wapis bhejna ho to:
        // header("Location: suppliers.php");
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
    <title>Add Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fb; }
        .card { box-shadow: 0 3px 8px rgba(0,0,0,0.15); margin-top:50px; }
    </style>
</head>
<body>

<div class="container" style="max-width: 600px;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <b>Add New Supplier</b>
        </div>
        <div class="card-body">

            <?php if($msg): ?>
                <div class="alert alert-info"><?= $msg; ?></div>
            <?php endif; ?>

            <!-- Roman Urdu guide -->
            <p class="text-muted">
Fill out the form here; when you press Save, the data will save into the Supplier table            </p>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Supplier Name</label>
                    <input type="text" name="supplier_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contact Info</label>
                    <input type="text" name="contact_info" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary w-100">Save Supplier</button>
                <a href="suppliers.php" class="btn btn-link w-100 mt-2">Back to Suppliers List</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
