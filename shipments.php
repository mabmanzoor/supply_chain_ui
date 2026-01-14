<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<h3>Shipments</h3>
<p class="text-muted">The record of shipments against orders.</p>
<a href="add_shipment.php" class="btn btn-success mb-3">Add New Shipment</a>

<?php
$sql = "
SELECT
    s.shipment_id,
    co.order_id,
    w.warehouse_name,
    r.retailer_name,
    p.product_name,
    s.quantity,
    s.transport_cost_per_unit,
    (s.quantity * s.transport_cost_per_unit) AS total_transport_cost,
    s.shipment_date
FROM Shipment s
JOIN CustomerOrder co ON co.order_id = s.order_id
JOIN Warehouse w ON w.warehouse_id = s.from_warehouse_id
JOIN Retailer r ON r.retailer_id = s.to_retailer_id
JOIN Product p ON p.product_id = s.product_id
ORDER BY s.shipment_id;
";
$result = mysqli_query($conn, $sql);
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Shipment ID</th>
            <th>Order ID</th>
            <th>From Warehouse</th>
            <th>To Retailer</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Cost/Unit</th>
            <th>Total Cost</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['shipment_id']; ?></td>
            <td><?= $row['order_id']; ?></td>
            <td><?= $row['warehouse_name']; ?></td>
            <td><?= $row['retailer_name']; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['transport_cost_per_unit']; ?></td>
            <td><?= $row['total_transport_cost']; ?></td>
            <td><?= $row['shipment_date']; ?></td>
            <td>
                <a href="delete.php?table=Shipment&id=<?= $row['shipment_id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this shipment?');">
                    Delete
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>


<?php include 'footer.php'; ?>