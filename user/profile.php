<?php
require dirname(__DIR__) . "../auth/functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}

$user_id = $_GET['user_id'];

$user = getUserById($user_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php echo $user['user_id'];?>
    <?php echo $user['username'];?>
    <?php echo $user['user_'];?>
</body>
</html>