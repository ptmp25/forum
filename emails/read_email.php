<?php
require dirname(__DIR__) . '/modules/module_functions.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    $errors = "You must log in first";
    header('location: ../auth/login.php');
}

$message_id = $_GET['message_id'];

$stmt = $db->prepare("SELECT messages.*, users.username AS send_by
                            FROM messages
                            JOIN users ON messages.user_id = users.user_id
                            WHERE messages.message_id = :message_id;");
$stmt->bindParam(':message_id', $message_id, PDO::PARAM_INT);
$stmt->execute();
$email = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$email) {
    die("Message not found");
}

if (isset($_POST['delete'])) {
    $stmt = $db->prepare("DELETE FROM messages WHERE message_id = :message_id");
    $stmt->bindParam(':message_id', $message_id, PDO::PARAM_INT);
    $stmt->execute();
    header('location: ../inbox.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $email['message_subject']; ?>
    </title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <main>
        <div class="container email">
            <h1>
                <?php echo $email['message_subject']; ?>
            </h1>
            <p>From:
                <?php echo $email['send_by']; ?>
            </p>
            <p>Date:
                <?php echo $email['timestamp']; ?>
            </p>
            <div class="message-body">
                <p>
                    <?php echo $email['message']; ?>
                </p>
            </div>
            <form method="post" action="../emails/delete_message.php?message_id=<?php echo $email['message_id']; ?>">
                <input type="hidden" name="message_id" value=<?php echo $email['message_id']; ?>>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
    </main>
</body>

</html>