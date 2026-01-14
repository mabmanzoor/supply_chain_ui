<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Intelligent Supply Chain UI</title>
    <!-- Bootstrap CDN simple styling ke liye -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f5f7fb; }
        .navbar-brand { font-weight: bold; }
        .card { box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        pre { background:#eee; padding:8px; border-radius:4px; }

        
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Supply Chain System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarsExample" aria-controls="navbarsExample" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="suppliers.php">Suppliers</a></li>
                <li class="nav-item"><a class="nav-link" href="warehouses.php">Warehouses</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="inventory.php">Inventory</a></li>
                <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="shipments.php">Shipments</a></li>
                <li class="nav-item"><a class="nav-link" href="routes.php">Routes</a></li>
                <li class="nav-item"><a class="nav-link" href="bottleneck.php">Bottleneck</a></li>
            </ul>

            <ul class="navbar-nav ms-auto">
    <?php if (isset($_SESSION['username'])): ?>
        <li class="nav-item">
            <span class="nav-link disabled">
                Logged in as: <b><?= $_SESSION['username']; ?></b>
            </span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    <?php endif; ?>
</ul>

        </div>
    </div>
</nav>
<div class="container">
