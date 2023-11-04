<?php
require dirname(__DIR__) . '/modules/module_functions.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    $errors = "You must log in first";
    header('location: ../auth/login.php');
}


// Check if the username already exists in the database
$query = "SELECT * FROM users";
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
</head>

<body>
    <div class="text-center">
        <button class="btn btn-primary">
            <a href="../admin/create_user.php">Create User</a>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <a href="../user/profile.php?user_id=<?php echo $user['user_id']; ?>">
                            <?= $user['username'] ?>
                        </a>
                    </td>
                    <td>
                        <?= $user['email'] ?>
                    </td>
                    <td>
                        <?= $user['role'] ?>
                    </td>
                    <td>
                        <form method="post" action="../auth/delete_user.php?user_id=<?php echo $user['user_id']; ?>">
                            <input type="hidden" name="user_id" value=<?php echo $user['user_id']; ?>>
                            <button type="submit" class="btn btn-danger" name="delete_user_btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</html>