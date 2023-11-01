<?php
require '../emails/email_functions.php';

$email_id = $_GET('email_id');

try {
    // Query the database for messages
    $stmt = $db->prepare("SELECT messages.*, users.username AS replied_by
                        FROM messages
                        JOIN users ON messages.user_id = users.user_id
                        WHERE messages.message_id = :message_id;");
    $stmt->execute();
    $email = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $email['message_subject'];?></title>
</head>
<body>
    
</body>
</html>