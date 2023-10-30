<?php
require dirname(__DIR__) . "../auth/functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: $APPURL/auth/login.php");
}

$user_id = $_GET['user_id'];

$user = getUserById($user_id);
require "../templates/header.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="<?php echo $user['profile_picture']; ?>" class="card-img-top" alt="Profile Image">
                        <h5 class="card-title"><?php echo $user['username']; ?></h5>
                        <p class="card-text">Email: <em><?php echo $user['email']; ?></em></p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">About Me</h5>
                        <p class="card-text"><?php echo $user['about']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
    
</body>
</html>