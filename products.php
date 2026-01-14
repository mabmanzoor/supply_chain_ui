<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<h3>Products</h3>
<p class="text-muted">Available products in System.</p>
<a href="add_product.php" class="btn btn-success mb-3">Add New Product</a>


<?php
$sql = "SELECT * FROM Product";
$result = mysqli_query($conn, $sql);
?>

<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Unit Price</th>
            <th>Action</th>

        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['product_id']; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td><?= $row['unit_price']; ?></td>
            <td>
                <a href="delete.php?table=Product&id=<?= $row['product_id']; ?>" class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this product?');">
                    Delete
                </a>
            </td>

        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>