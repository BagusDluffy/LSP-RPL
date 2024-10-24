<?php

include "../../auth/auth.php";
checkAuth();
include "../../config/db.php";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare('DELETE from vendor where id = :id');
    $stmt->execute(['id' => $id]);

    $message = 'Data vendor berhasil di hapus';
}

$stmt = $conn->query('SELECT * from vendor');
$vendor = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Manage Vendor</title>
    <style>
        .flex-column {
            height: 100vh;
        }
    </style>
</head>

<body>
    <?php include '../../include/header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <?php include '../../include/sidebar.php'; ?>
            </div>
            <div class="col-10">
                <h2 class="mt-4">Manage Vendor</h2>

                <?php if (isset($message)): ?>
                    <div class="alert alert-success">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Vendor List</h4>
                        <a href="add_vendor.php" class="btn btn-primary float-right">Add Vendor</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Vendor</th>
                                    <th>Kontak</th>
                                    <th>Nama Barang</th>
                                    <th>Nomer Invoice</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($vendor as $vendor): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $vendor['nama']; ?></td>
                                        <td><?php echo $vendor['kontak']; ?></td>
                                        <td><?php echo $vendor['nama_barang']; ?></td>
                                        <td><?php echo $vendor['invoice']; ?></td>
                                        <td>
                                            <a href="edit_vendor.php?id=<?php echo $vendor['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete=<?php echo $vendor['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../include/footer.php'; ?>
</body>

</html>