<?php

include '../../config/db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo 'id tidak ditemukan!';
}

$stmt = $conn->prepare('SELECT * FROM storage WHERE id = :id');
$stmt->execute(['id' => $id]);
$storage = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$storage) {
    echo 'Storage tidak ditemukan!';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gudang = $_POST['nama_gudang'];
    $lokasi = $_POST['lokasi'];

    $stmt = $conn->prepare("UPDATE storage SET nama_gudang = :nama_gudang, lokasi = :lokasi WHERE id = :id");
    $stmt->execute([
        'nama_gudang' => $gudang,
        'lokasi' => $lokasi,
        'id' => $id
    ]);

    $stmt = $conn->prepare("UPDATE inventory SET lokasi_gudang = :lokasi_gudang WHERE storage_id = :storage_id");
    $stmt->execute([
        'lokasi_gudang' => $lokasi,
        'storage_id' => $id
    ]);

    $message = "Data storage berhasil diperbarui!";
}
include '../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Edit Data Storage</title>
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
                            <h2>Edit Storage</h2>
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
                                        <input type="text" name="nama_gudang" class="form-control" id="nama_gudang" value="<?= htmlspecialchars($storage['nama_gudang']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lokasi">Lokasi Gudang</label>
                                        <input type="text" name="lokasi" class="form-control" id="lokasi" value="<?= htmlspecialchars($storage['lokasi']) ?>" required>
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