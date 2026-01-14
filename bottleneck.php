<?php
require 'db.php';
require 'auth.php';
require 'header.php';
?>

<h3>Bottleneck Warehouse (Highest Shipment Load)</h3>
<p class="text-muted">
Here you can see which warehouse is handling the highest number of shipments.
This helps identify potential bottlenecks in your supply chain.
</p>

<?php
$sql = "
SELECT 
    w.warehouse_name,
    COUNT(*) AS shipment_count
FROM Shipment s
JOIN Warehouse w 
    ON s.from_warehouse_id = w.warehouse_id
GROUP BY w.warehouse_id
ORDER BY shipment_count DESC;
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<div class='alert alert-danger'>SQL Error: " . mysqli_error($conn) . "</div>";
    require 'footer.php';
    exit;
}

// fetch results to detect max
$data = [];
$max = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    if ($row['shipment_count'] > $max) {
        $max = $row['shipment_count'];
    }
}
?>

<?php if (count($data) == 0): ?>
    <div class="alert alert-info">No shipments found in the system.</div>
<?php else: ?>

<table class="table table-striped table-bordered mt-3">
    <thead class="table-dark">
        <tr>
            <th>Warehouse</th>
            <th>Total Shipments</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($data as $row): ?>
            <tr class="<?= ($row['shipment_count'] == $max) ? 'table-danger' : '' ?>">
                <td><?= $row['warehouse_name']; ?></td>
                <td><?= $row['shipment_count']; ?></td>
                <td>
                    <?php if ($row['shipment_count'] == $max): ?>
                        <span class="badge bg-danger">Bottleneck</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Normal</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php require 'footer.php'; ?>
