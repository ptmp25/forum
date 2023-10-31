<?php
require '../auth/functions.php';
if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    $errors = "You must log in first";
    header('location: ../auth/login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ../auth/login.php");
}
include(dirname(__DIR__) . "/templates/header.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registration system PHP and MySQL - Create user</title>
</head>

<body>
    <div class="header text-center">
        <h2>Admin - create user</h2>
    </div>
    <div class="card container" style="margin: 10px auto;">

        <form method="post" action="create_user.php">
            <div class="card-body">

                <?php echo display_error(); ?>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="role">User type</label>
                    <select name="role" id="role" class="form-control">
                        <option value=""></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password_1" class="form-control">
                </div>
                <div class="form-group">
                    <label>Confirm password</label>
                    <input type="password" name="password_2" class="form-control">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary" name="register_btn">Create user</button>
                </div>
        </form>
    </div>
</body>

</html>