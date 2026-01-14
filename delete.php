<?php
require 'db.php';
require 'auth.php';

if (!isset($_GET['table']) || !isset($_GET['id'])) {
    die("Invalid delete request!");
}

$table = $_GET["table"];
$id    = (int) $_GET["id"];   // safety

// Allowed tables + unka primary key + redirect page
$map = [
    "Supplier"      => ["pk" => "supplier_id",     "redirect" => "suppliers.php"],
    "Warehouse"     => ["pk" => "warehouse_id",    "redirect" => "warehouses.php"],
    "Product"       => ["pk" => "product_id",      "redirect" => "products.php"],
    "Retailer"      => ["pk" => "retailer_id",     "redirect" => "retailers.php"],
    "Inventory"     => ["pk" => "inventory_id",    "redirect" => "inventory.php"],
    "CustomerOrder" => ["pk" => "order_id",        "redirect" => "orders.php"],
    "Shipment"      => ["pk" => "shipment_id",     "redirect" => "shipments.php"],
    "Route"         => ["pk" => "route_id",        "redirect" => "routes.php"],  // ✅ yeh zaroor ho
];


if (!isset($map[$table])) {
    die("Delete not allowed for this table.");
}

$pk       = $map[$table]["pk"];
$redirect = $map[$table]["redirect"];

$sql = "DELETE FROM $table WHERE $pk = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: $redirect");
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
