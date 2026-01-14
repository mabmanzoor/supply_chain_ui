<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<h3>Suppliers</h3>
<p class="text-muted">Add New Suppliers Here</p>
<a href="add_supplier.php" class="btn btn-success mb-3">Add New Supplier</a>

<?php
$sql = "SELECT * FROM Supplier";
$result = mysqli_query($conn, $sql);
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Supplier Name</th>
            <th>City</th>
            <th>Contact Info</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['supplier_id']; ?></td>
            <td><?= $row['supplier_name']; ?></td>
            <td><?= $row['city']; ?></td>
            <td><?= $row['contact_info']; ?></td>

            <td>
                <a href="delete.php?table=Supplier&id=<?= $row['supplier_id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this supplier?');">
                    Delete
                </a>
            </td>

        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>