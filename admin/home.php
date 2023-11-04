<?php
require dirname(__DIR__) . '/modules/module_functions.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    $errors = "You must log in first";
    header('location: ../auth/login.php');
}
// Prepare and execute the SQL query to retrieve data
$stmt = $db->prepare("SELECT messages.*, users.username AS send_by
                  FROM messages 
                  JOIN users ON messages.user_id = users.user_id");
$stmt->execute();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <div class="page-name">
        <h1>Admin - Home Page</h1>
    </div>
    <div class="text-center">
        <button class="btn btn-primary">
            <a href="../admin/accounts.php">Accounts Control</a>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email Subject</th>
                <th>Email Content</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($email = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td>
                        <?php echo $email['send_by']; ?>
                    </td>
                    <td>
                        <?php echo $email['message_subject']; ?>
                    </td>
                    <td>
                        <?php
                        $message = $email['message'];
                        if (strlen($message) > 100) {
                            $short_message = substr($message, 0, 100) . '...';
                            echo $short_message . '<a href="../emails/read_email.php?message_id=' . $email['message_id'] . '">See more</a>';
                        } else {
                            echo $message;
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo $email['timestamp']; ?>
                    </td>
                    <td>
                        <form method="post"
                            action="../emails/delete_message.php?message_id=<?php echo $email['message_id']; ?>">
                            <input type="hidden" name="message_id" value=<?php echo $email['message_id']; ?>>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>