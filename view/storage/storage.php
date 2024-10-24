<?php 

include "../../auth/auth.php";
checkAuth();
include "../../config/db.php";

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM storage WHERE id = :id");
    $stmt->execute(['id' => $id]);

    $message = 'Data storage berhasil di hapus';
}

$stmt = $conn->query('SELECT * from storage');
$storage = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Manage Storage</title>
    <style>
        .flex-column {
            height: 100vh;
        }
    </style>
</head>
<body>
    <?php include '../../include/header.php';?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <?php include '../../include/sidebar.php';?>
            </div>

            <div class="col-10">
                <h2 class="mt-4">Manage Storage</h2>

                <?php if (isset($message)): ?>
                    <div class="alert alert-success">
                        <?php echo $message; ?>
                    </div>  
                <?php endif; ?>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Storage List</h4>
                        <a href="add_storage.php" class="btn btn-primary float-right">Add Storage</a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Storage</th>
                                    <th>lokasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                foreach ($storage as $storage): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $storage['nama_gudang']; ?></td>
                                        <td><?php echo $storage['lokasi']; ?></td>
                                        <td>
                                            <a href="edit_storage.php?id=<?php echo $storage['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?delete=<?php echo $storage['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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

    <?php include '../../include/footer.php';?>
</body>
</html>