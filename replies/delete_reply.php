<?php
// Include your database connection code here
require dirname(__DIR__) . '/replies/reply_functions.php';

if (isset($_POST['delete_reply_btn'])) {
    // Get the reply ID and question ID from the POST request
    $reply_id = $_POST['reply_id'];
    $question_id = $_POST['question_id'];
    $user_id = $_POST['user_id'];

    // Check if the user is the owner of the reply or an admin
    if (isOwner($user_id) || isAdmin()) {
        // Call a function to delete the reply (implement this function)
        if (deleteReply($db, $reply_id)) {
            // reply deleted successfully, you can redirect to a success page
            header("Location: ../questions/read_question.php?question_id={$question_id}");
            exit();
        } else {
            echo "Error deleting the reply.";
        }
    } else {
        echo "You are not authorized to delete this reply.";
    }
} else {
    // Handle invalid requests or direct access to this script
    echo "Invalid request.";
}
