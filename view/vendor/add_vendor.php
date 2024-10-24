<?php

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $kontak = $_POST['kontak'];
    $barang = $_POST['nama_barang'];
    $invoice = $_POST['invoice'];

    $stmt = $conn->prepare('INSERT INTO vendor (nama, kontak, nama_barang, invoice) VALUES (:nama, :kontak, :nama_barang, :invoice)');
    $stmt->execute([
        'nama' => $nama,
        'kontak' => $kontak,
        'nama_barang' => $barang,
        'invoice' => $invoice
    ]);

    $message = 'Data vendor berhasil ditambahkan';
}
include '../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Add Data Vendor</title>
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
                    <?php include '../../include/sidebar.php'; ?>
                </div>
                <div class="col-10 mt-1">
                    <div class="card ms-3">
                        <div class="card-header text-center">
                            <h2>Add Vendor</h2>

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
                                        <input type="text" name="nama" class="form-control" id="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kontak">Kontak Vendor</label>
                                        <input type="text" name="kontak" class="form-control" id="kontak" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_barang">Nama barang</label>
                                        <input type="text" name="nama_barang" class="form-control" id="nama_barang" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="invoice">Invoice</label>
                                        <input type="text" name="invoice" class="form-control" id="invoice" required>
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