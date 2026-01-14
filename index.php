<?php
require 'db.php';
require 'auth.php';   // pehle auth, phir header
require 'header.php';
?>


<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">Project Overview</div>
            <div class="card-body">
                <p>
                    This UI is the front-end demo of the ‘Intelligent Supply Chain Decision System.’ From here, we can
                    view suppliers, warehouses, retailers, inventory, orders, shipments, and routes.
                </p>
                <ul>
                    <li>Suppliers, Warehouses, Retailers listing</li>
                    <li>Inventory status & shortage highlight</li>
                    <li>Customer Orders & Shipments view</li>
                    <li>Route cost calculation (Supplier → Warehouse → Retailer)</li>
                    <li>Bottleneck warehouse analysis</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">How to Use</div>
            <div class="card-body">
                <p>Open the pages from the top menu:</p>
                <ul>
                    <li><b>Suppliers</b> → suppliers list</li>
                    <li><b>Inventory</b> → stock & shortage</li>
                    <li><b>Routes</b> → route cost calculation</li>
                    <li><b>Bottleneck</b> → The most busy warehouse</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>