<?php

include '../../auth/auth.php';
checkAuth();
include '../../config/db.php';

$stmt = $conn->query("SELECT COUNT(*) AS total_vendor FROM vendor");
$total_vendor = $stmt->fetchColumn();

$stmt = $conn->query("SELECT COUNT(*) AS total_inventory FROM inventory");
$total_inventory = $stmt->fetchColumn();

$stmt = $conn->query("SELECT COUNT(*) AS total_storage_unit FROM storage");
$total_storage_unit = $stmt->fetchColumn();
include '../../include/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Dashboard</title>
    <style>
        .flex-column {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <?php include '../../include/sidebar.php'; ?>
            </div>
            <div class="col-md-9">
                <h1 class="mt-4">Dashboard</h1>
                <p>Welcome to the admin panel!</p>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header">Total Vendors</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $total_vendor; ?></h5>
                                <a href="../vendor/vendor.php" class="btn btn-light">Manage Vendors</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Total Inventory Items</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $total_inventory; ?></h5>
                                <a href="../inventory/inventory.php" class="btn btn-light">Manage Inventory</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Total Storage Units</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $total_storage_unit; ?></h5>
                                <a href="../storage/storage.php" class="btn btn-light">Manage Storage Units</a>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <?php include '../../include/footer.php'; ?>
</body>

</html>