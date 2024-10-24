<?php
include '../../auth/auth.php';
checkAuth();
include '../../config/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$nama_barang = $_POST['nama_barang'] ?? '';
$vendor_options = [];
$storage_units = [];

$stmt = $conn->query("SELECT id, nama_gudang FROM storage");
$storage_units = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_inventory'])) {
        $vendor_id = $_POST['vendor_id'];

        $stmt = $conn->prepare("SELECT nama_gudang FROM storage WHERE id = :storage_id");
        $stmt->execute(['storage_id' => $_POST['storage_id']]);
        $storage_unit = $stmt->fetch();

        if ($storage_unit) {
            $stmt = $conn->prepare("INSERT INTO inventory (vendor_id, nama_barang, jenis_barang, kuantitas, storage_id, lokasi_gudang, harga, barcode)
                                    VALUES (:vendor_id, :nama_barang, :jenis_barang, :kuantitas, :storage_id, :lokasi_gudang, :harga, :barcode)");
            $stmt->execute([
                'vendor_id' => $vendor_id,
                'nama_barang' => $_POST['nama_barang'],
                'jenis_barang' => $_POST['jenis_barang'],
                'kuantitas' => $_POST['kuantitas'],
                'storage_id' => $_POST['storage_id'],
                'lokasi_gudang' => $storage_unit['nama_gudang'],
                'harga' => $_POST['harga'],
                'barcode' => $_POST['barcode'],
            ]);

            $message = "Inventory berhasil ditambahkan!";
        } else {
            $message = "Storage unit tidak ditemukan!";
        }
    }

    if (!empty($nama_barang)) {
        $stmt = $conn->prepare("SELECT id AS vendor_id, nama FROM vendor WHERE nama_barang = :nama_barang");
        $stmt->execute(['nama_barang' => $nama_barang]);
        $vendor_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

include '../../include/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Add Inventory</title>
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
                        <div class="card-header text-center mt-1">
                            <h2>Add Inventory</h2>

                            <?php if (isset($message)): ?>
                                <div class="alert alert-success">
                                    <?php echo $message; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <select name="nama_barang" id="nama_barang" class="form-control" onchange="this.form.submit()">
                                        <option value="">Pilih Nama Barang</option>
                                        <?php
                                        // Mengambil daftar nama barang dari vendor
                                        foreach ($conn->query("SELECT DISTINCT nama_barang FROM vendor") as $barang) {
                                            $selected = ($barang['nama_barang'] == $nama_barang) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($barang['nama_barang']) . "' $selected>" . htmlspecialchars($barang['nama_barang']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php if ($vendor_options): ?>
                                    <div class="form-group">
                                        <label for="vendor_id">Vendor</label>
                                        <select name="vendor_id" id="vendor_id" class="form-control">
                                            <?php
                                            foreach ($vendor_options as $option) {
                                                echo "<option value='" . htmlspecialchars($option['vendor_id']) . "'>" . htmlspecialchars($option['nama']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <div class="form-group">
                                    <label for="jenis_barang">Jenis Barang</label>
                                    <input type="text" name="jenis_barang" id="jenis_barang" class="form-control" required value="<?= htmlspecialchars($_POST['jenis_barang'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="kuantitas">Kuantitas Stock</label>
                                    <input type="text" name="kuantitas" id="kuantitas" class="form-control" required value="<?= htmlspecialchars($_POST['kuantitas'] ?? '') ?>">
                                </div>

                                <div class="form-group">
                                    <label for="storage_id">Lokasi Gudang</label>
                                    <select name="storage_id" class="form-control" required>
                                        <?php foreach ($storage_units as $storage_unit): ?>
                                            <option value="<?php echo $storage_unit['id']; ?>" <?php echo (isset($_POST['storage_id']) && $_POST['storage_id'] == $storage_unit['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($storage_unit['nama_gudang']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" name="harga" id="harga" class="form-control" required value="<?= htmlspecialchars($_POST['harga'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control" required value="<?= htmlspecialchars($_POST['barcode'] ?? '') ?>">
                                </div>

                                <button type="submit" name="submit_inventory" class="btn btn-primary mt-3 mb-4 col-12">Add Inventory</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../include/footer.php' ?>
</body>

</html>