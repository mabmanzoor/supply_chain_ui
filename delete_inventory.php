<?php
require 'db.php';
require 'auth.php';

$id = $_GET["id"];

$sql = "DELETE FROM Inventory WHERE inventory_id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: inventory.php");
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
?>
