    <?php

    include '../../config/db.php';

    $id = $_GET['id'] ?? '';

    if (!$id) {
        echo 'id tidak ditemukan!';
    }

    $stmt = $conn->prepare('SELECT * FROM inventory WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $inventory = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$inventory) {
        echo 'Storage tidak ditemukan!';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $barang = $_POST['jenis_barang'];
        $kuantitas = $_POST['kuantitas'];
        $harga = $_POST['harga'];

        $stmt = $conn->prepare("UPDATE inventory SET jenis_barang = :jenis_barang, kuantitas = :kuantitas, harga = :harga WHERE id = :id");
        $stmt->execute([
            'jenis_barang' => $barang,
            'kuantitas' => $kuantitas,
            'harga' => $harga,
            'id' => $id
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
                        <?php include '../../include/sidebar.php' ?>
                    </div>
                    <div class="col-10 mt-1">
                        <div class="card ms-3">
                            <div class="card-header text-center">
                                <h2>Edit Inventory</h2>
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
                                        <label for="jenis_barang">Jenis Barang</label>
                                        <input type="text" name="jenis_barang" class="form-control" id="jenis_barang" value="<?= htmlspecialchars($inventory['jenis_barang']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kuantitas">Kuantitas Stock</label>
                                        <input type="text" name="kuantitas" class="form-control" id="kuantitas" value="<?= htmlspecialchars($inventory['kuantitas']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" name="harga" class="form-control" id="harga" value="<?= htmlspecialchars($inventory['harga']) ?>" required>
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
        <?php include '../../include/footer.php'?>
    </body>
    </html>