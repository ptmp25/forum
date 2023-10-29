<?php require __DIR__ . '../functions.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <form method="post" action="register.php" enctype="multipart/form-data">
        <!-- show error message  -->
        <?php echo display_error(); ?>
        <?php echo display_success(); ?>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h2>Register</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="register.php" enctype="multipart/form-data">
                        <!-- show error message  -->
                        <?php echo display_error(); ?>
                        <?php echo display_success(); ?>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                        </div>
                        <div class="form-group">
                            <label for="password_1">Password</label>
                            <input type="password" class="form-control" name="password_1">
                        </div>
                        <div class="form-group">
                            <label for="password_2">Confirm password</label>
                            <input type="password" class="form-control" name="password_2">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="register_btn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</body>

</html>