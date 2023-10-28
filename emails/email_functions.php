<?php
require '../auth/functions.php';

if (!isLoggedIn()) {
    header("Location: ../auth/login.php");
}

if (isset($_POST["send_email_btn"])) {
    sendEmail();
}

function sendEmail()
{
    global $db;

    // $email = $_POST["email"];
    $user_id = $_POST["user_id"];
    $message_subject = $_POST["message_subject"];
    $message = $_POST["message"];

    $query = "INSERT INTO messages (user_id, message_subject, message) 
    VALUES (:user_id, :message_subject, :message)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':message_subject', $message_subject);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
    header("Location: ../emails/succeed.php");
}