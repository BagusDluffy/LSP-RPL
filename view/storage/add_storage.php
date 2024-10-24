<?php

include "../../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gudang = $_POST['nama_gudang'];
    $lokasi = $_POST['lokasi'];

    $stmt = $conn->prepare('INSERT INTO storage (nama_gudang, lokasi) VALUES (:nama_gudang, :lokasi)');
    $stmt->execute([
        'nama_gudang' => $gudang,
        'lokasi' => $lokasi
    ]);

    $message = 'Data storage berhasil ditambahkan';
}
include '../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Add Data Storage</title>
    <style>
            .flex-column{
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 d-flex">
                <div class="col-2">
                    <?php include "../../include/sidebar.php" ?>
                </div>
                <div class="col-10 ms-3">
                    <div class="card mt-1">
                        <div class="card-header text-center">
                            <h2>Add Storage</h2>

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
                                        <label for="nama_gudang">Nama Gudang</label>
                                        <input type="text" name="nama_gudang" class="form-control" id="nama_gudang" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control" id="lokasi" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary col-12 mt-3 mb-4">Submit</button>
                                    <!-- <a href="storage.php" class="btn btn-secondary">Back</a> -->
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