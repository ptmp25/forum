<?php
require __DIR__ . '../functions.php';

$user_id = $_GET['user_id']


// Check if form is submitted
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new password and confirm password are same
    if ($new_password != $confirm_password) {
        echo "New password and Confirm password do not match";
        return;
    }

    // Fetch the current password from the database for the logged in user
    $stmt = $db->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->execute([$_SESSION['username']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the entered current password matches with the one in the database
    if (password_verify($current_password, $row['password'])) {
        // Update the password in the database
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->execute([$new_password_hash, $_SESSION['username']]);
        echo "Password changed successfully";
    } else {
        echo "Current password is incorrect";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <form method="post" action="login.php">

        <div class="container">
            <div class="card">
                <div class="card-header">Login</div>
                <?php echo display_error(); ?>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="current_password">Current Password: </label>
                            <input type="password" class="form-control"  name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">New Password: </label>
                            <input type="password" class="form-control"  name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Confirm Password: </label>
                            <input type="password" class="form-control"  name="confirm_password" required>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit"  class="btn btn-primary text-center" name="change_password" value="Change Password">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </form>
</body>

</html>