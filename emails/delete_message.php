<?php
require '../emails/email_functions.php';
// Get the message ID from the POST data
$messageId = $_POST["message_id"];

// Delete the message from the database
$stmt = $db->prepare("DELETE FROM messages WHERE message_id = :message_id");
$stmt->bindParam(":message_id", $messageId);
$stmt->execute();

// Redirect back to the emails.php page
header("Location: emails.php");
exit();
?>