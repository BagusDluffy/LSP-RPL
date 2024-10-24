<?php

include "../../auth/auth.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (login($email, $password)) {
        header("location: ../dashboard/dashboard.php");
        exit();
    } else {
        $error = "Email atau password anda salah";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Asset/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h2 class="py-2">Login Admin</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script scr="../../Asset/js/bootstrap.bundle.min.js"></script>
</body>
</html>