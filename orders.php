<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<h3>Customer Orders</h3>
<p class="text-muted">Retailer orders list.</p>
<a href="add_order.php" class="btn btn-success mb-3">Add New Order</a>

<?php
$sql = "
SELECT 
    co.order_id,
    r.retailer_name,
    p.product_name,
    co.quantity,
    co.order_date,
    co.deadline_date,
    co.status
FROM CustomerOrder co
JOIN Retailer r ON r.retailer_id = co.retailer_id
JOIN Product p ON p.product_id = co.product_id
ORDER BY co.order_id;
";
$result = mysqli_query($conn, $sql);
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Order ID</th>
            <th>Retailer</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Order Date</th>
            <th>Deadline</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['order_id']; ?></td>
            <td><?= $row['retailer_name']; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['order_date']; ?></td>
            <td><?= $row['deadline_date']; ?></td>
            <td><?= $row['status']; ?></td>
            <td>
                <a href="delete.php?table=CustomerOrder&id=<?= $row['order_id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this order?');">
                    Delete
                </a>
            </td>

        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>