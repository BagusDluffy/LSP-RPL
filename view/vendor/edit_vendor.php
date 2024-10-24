<?php

include '../../config/db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo 'id tidak ditemukan!';
}

$stmt = $conn->prepare('SELECT * FROM vendor WHERE id = :id');
$stmt->execute(['id' => $id]);
$vendor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vendor) {
    echo 'Vendor tidak ditemukan!';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $barang = $_POST['nama_barang'];
    $invoice = $_POST['invoice'];

    $stmt = $conn->prepare("UPDATE vendor SET nama = :nama, kontak = :kontak, nama_barang = :nama_barang, invoice = :invoice WHERE id = :id");
    $stmt->execute([
        'nama' => $nama,
        'kontak' => $kontak,
        'nama_barang' => $barang,
        'invoice' => $invoice,
        'id' => $id,
    ]);

    $stmt = $conn->prepare("UPDATE inventory SET nama_barang = :nama_barang WHERE vendor_id = :vendor_id");
    $stmt->execute([
        'nama_barang' => $barang,
        'vendor_id' => $id,
    ]);

    $message = "Vendor dan nama barang berhasil diperbarui!";
}
include '../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Edit Data Vendor</title>
    <style>
        .flex-column {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex">
                <div class="col-2">
                    <?php include '../../include/sidebar.php' ?>
                </div>
                <div class="col-10 mt-1">
                    <div class="card ms-3">
                        <div class="card-header text-center">
                            <h2>Edit Vendor</h2>
                            <?php if (isset($message)): ?>
                                <div class="alert alert-success">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body col-12 d-flex justify-content-center">
                            <div class="col-10">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="nama" value="<?= htmlspecialchars($vendor['nama']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kontak">Kontak Vendor</label>
                                        <input type="text" name="kontak" class="form-control" id="kontak" value="<?= htmlspecialchars($vendor['kontak']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_barang">Nama barang</label>
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" value="<?= htmlspecialchars($vendor['nama_barang']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="invoice">Invoice</label>
                                        <input type="text" name="invoice" class="form-control" id="invoice" value="<?= htmlspecialchars($vendor['invoice']) ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary col-12 mt-3 mb-4">Submit</button>
                                    <!-- <a href="vendor.php" class="btn btn-secondary">Back</a> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../include/footer.php' ?>
</body>

</html>