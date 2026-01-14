<?php
require 'db.php';
require 'auth.php';
require 'header.php';
?>

<h3>Route Cost (Supplier → Warehouse → Retailer)</h3>
<p class="text-muted">
Here we can see all the possible routes along with their total transportation cost.
</p>

<a href="add_route.php" class="btn btn-success mb-3">Add New Route</a>

<!-- =============================
     PART A — Route Cost Analysis
     ============================= -->

<?php
$sql_cost = "
SELECT
    s.supplier_name,
    w.warehouse_name,
    r.retailer_name,
    rt1.cost_per_unit AS supplier_to_warehouse_cost,
    rt2.cost_per_unit AS warehouse_to_retailer_cost,
    (rt1.cost_per_unit + rt2.cost_per_unit) AS total_route_cost
FROM Supplier s
JOIN Route rt1 
    ON rt1.from_node_type='supplier' 
   AND rt1.from_node_id=s.supplier_id
JOIN Warehouse w 
    ON w.warehouse_id=rt1.to_node_id
JOIN Route rt2 
    ON rt2.from_node_type='warehouse' 
   AND rt2.from_node_id=w.warehouse_id
JOIN Retailer r 
    ON r.retailer_id=rt2.to_node_id
ORDER BY total_route_cost ASC;
";

$result_cost = mysqli_query($conn, $sql_cost);

// Debug agar query fail ho
if (!$result_cost) {
    echo "<div class='alert alert-danger'>Cost Query Error: " . mysqli_error($conn) . "</div>";
}
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Supplier</th>
            <th>Warehouse</th>
            <th>Retailer</th>
            <th>Supplier → Warehouse Cost</th>
            <th>Warehouse → Retailer Cost</th>
            <th>Total Route Cost</th>
        </tr>
    </thead>

    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result_cost)): ?>
        <tr>
            <td><?= $row['supplier_name']; ?></td>
            <td><?= $row['warehouse_name']; ?></td>
            <td><?= $row['retailer_name']; ?></td>
            <td><?= $row['supplier_to_warehouse_cost']; ?></td>
            <td><?= $row['warehouse_to_retailer_cost']; ?></td>
            <td><b><?= $row['total_route_cost']; ?></b></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<hr>

<!-- =============================
     PART B — Raw Route Table
     ============================= -->

<h3>Raw Route Records</h3>
<p class="text-muted">These are the actual routes saved in the system.</p>

<?php
$sql_routes = "
SELECT 
    route_id,
    from_node_type,
    from_node_id,
    to_node_id,
    cost_per_unit
FROM Route
ORDER BY route_id DESC;
";

$result_routes = mysqli_query($conn, $sql_routes);

// Debug agar koi SQL error ho
if (!$result_routes) {
    echo "<div class='alert alert-danger'>Route Query Error: " . mysqli_error($conn) . "</div>";
}
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Route ID</th>
            <th>From Type</th>
            <th>From ID</th>
            <th>To ID</th>
            <th>Cost/Unit</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
<?php while ($row = mysqli_fetch_assoc($result_routes)): ?>
    <tr>
        <td><?= $row['route_id']; ?></td>
        <td><?= $row['from_node_type']; ?></td>
        <td><?= $row['from_node_id']; ?></td>
        <td><?= $row['to_node_id']; ?></td>
        <td><?= $row['cost_per_unit']; ?></td>
        <td>
            <a href="delete.php?table=Route&id=<?= $row['route_id']; ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Delete this route?');">
                Delete
            </a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>
</table>

<?php require 'footer.php'; ?>
