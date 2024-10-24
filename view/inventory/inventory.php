<?php
include '../../auth/auth.php';
checkAuth();
include '../../config/db.php';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM inventory WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $message = 'Data Inventory berhasil di hapus';
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$stmt = $conn->prepare('SELECT inventory.id, inventory.nama_barang, inventory.jenis_barang, inventory.kuantitas, inventory.lokasi_gudang, inventory.barcode, inventory.harga, vendor.nama as vendor_nama FROM inventory
    JOIN vendor on inventory.vendor_id = vendor.id
    WHERE (inventory.nama_barang LIKE :search
    OR inventory.barcode LIKE :search
    OR inventory.jenis_barang LIKE :search
    OR inventory.lokasi_gudang LIKE :search
    OR inventory.kuantitas LIKE :search
    OR vendor.nama LIKE :search)');

$stmt->execute(['search' => '%' . $search . '%']);

$inventories = $stmt->fetchAll();
include '../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Manage Inventory</title>
    <style>
        .flex-column {
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <?php include '../../include/sidebar.php' ?>
            </div>
            <div class="col-10">
                <h1 class="mt-4">Manage Inventory</h1>

                <?php if ('kuantitas' == 0): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo 'Ada barang yang kehabisan stock' ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($message)): ?>
                    <div class="alert alert-success text-center">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <form action="inventory.php" method="GET" class="form-inline mb-3 justify-content-end">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control rounded-end-0" placeholder="Cari Nama Barang" value="<?php echo htmlspecialchars($search); ?>">
                        <div class="input-group-append btn-group">
                            <button type="submit" class="btn btn-primary rounded-0">Cari</button>
                            <a href="inventory.php" class="btn btn-secondary rounded-start-0">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Inventory List</h4>
                        <a href="add_inventory.php" class="btn btn-primary float-right">Add Inventory</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Kuantitas Stock</th>
                                    <th>Lokasi Gudang</th>
                                    <th>Harga</th>
                                    <th>Barcode</th>
                                    <th>Vendor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($inventories) > 0): ?>
                                    <?php
                                    $i = 1;

                                    foreach ($inventories as $inventory):
                                        $no_stock = ($inventory['kuantitas'] == 0);
                                    ?>
                                        <tr class="<?php echo $no_stock ? 'table-danger' : '' ?>">
                                            <td><?php echo $i++ ?></td>
                                            <td><?php echo htmlspecialchars($inventory['nama_barang']); ?></td>
                                            <td><?php echo htmlspecialchars($inventory['jenis_barang']); ?></td>
                                            <td><?php echo htmlspecialchars($inventory['kuantitas']); ?></td>
                                            <td><?php echo htmlspecialchars($inventory['lokasi_gudang']); ?></td>
                                            <td>Rp. <?php echo number_format($inventory['harga'], 0, ',', '.'); ?></td>
                                            <td><?php echo htmlspecialchars($inventory['barcode']); ?></td>
                                            <td><?php echo htmlspecialchars($inventory['vendor_nama']); ?></td>
                                            <td>
                                                <a href="edit_inventory.php?id=<?php echo htmlspecialchars($inventory['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="?delete=<?php echo htmlspecialchars($inventory['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No inventory items found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../include/footer.php' ?>
</body>

</html>