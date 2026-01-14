<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<h3>Inventory Status</h3>
<a href="add_inventory.php" class="btn btn-success mb-3">Add Inventory</a>

<p class="text-muted">
    Stock based on Warehouse + Product.
    Where the quantity is below the threshold, that row will be highlighted in red (shortage).
</p>

<?php
$sql = "
SELECT
    i.inventory_id,
    w.warehouse_name,
    p.product_name,
    i.quantity,
    i.reorder_threshold
FROM Inventory i
JOIN Warehouse w ON w.warehouse_id = i.warehouse_id
JOIN Product p ON p.product_id = i.product_id
ORDER BY w.warehouse_name, p.product_name
";
$result = mysqli_query($conn, $sql);
?>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Inventory ID</th>
            <th>Warehouse</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Reorder Threshold</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): 
        $isShort = $row['quantity'] < $row['reorder_threshold'];
    ?>
        <tr class="<?= $isShort ? 'table-danger' : '' ?>">
            <td><?= $row['inventory_id']; ?></td>
            <td><?= $row['warehouse_name']; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['reorder_threshold']; ?></td>
            <td>
                <?= $isShort ? 'Shortage (Restock Required)' : 'OK'; ?>
            </td>
            <td>
                <a href="delete.php?table=Inventory&id=<?= $row['inventory_id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this inventory record?');">
                    Delete
                </a>
            </td>


        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>