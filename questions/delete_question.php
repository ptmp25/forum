<?php
// Include your database connection code here
require dirname(__DIR__) . '/questions/question_functions.php';

if (isset($_POST["delete_question_btn"])) {
    // Get the question ID and module ID from the POST request
    $question_id = $_POST['question_id'];
    $module_id = $_POST['module_id'];
    $user_id = $_POST['user_id'];

    // Check if the user is the owner of the question or an admin
    if (isOwner($user_id) || isAdmin()) {
        // Call a function to delete the question (implement this function)
        if (deleteQuestion($db, $question_id)) {
            // Question deleted successfully, you can redirect to a success page
            header("Location: ../questions/delete_succeed.php?module_id={$module_id}");
            exit();
        } else {
            echo "Error deleting the question.";
        }
    } else {
        echo "You are not authorized to delete this question.";
    }
} else {
    // Handle invalid requests or direct access to this script
    echo "Invalid request.";
}
