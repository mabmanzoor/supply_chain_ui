<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<h3>Warehouses</h3>
<p class="text-muted">Warehouses basic information.</p>
<a href="add_warehouse.php" class="btn btn-success mb-3">Add New Warehouse</a>


<?php
$sql = "SELECT * FROM Warehouse";
$result = mysqli_query($conn, $sql);
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Warehouse Name</th>
            <th>City</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['warehouse_id']; ?></td>
            <td><?= $row['warehouse_name']; ?></td>
            <td><?= $row['city']; ?></td>
            <td>
                <a href="delete.php?table=Warehouse&id=<?= $row['warehouse_id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this warehouse?');">
                    Delete
                </a>
            </td>

        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>