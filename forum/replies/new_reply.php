<?php
require dirname(__DIR__) . "../auth/functions.php";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $question_id = $_POST["question_id"];
    $reply_content = $_POST["reply_content"];
    $user_id = $_SESSION["user"]['user_id'];

    try {
        // Insert the reply into the database
        $insert_reply_query = "INSERT INTO replies (question_id, user_id, reply_content) VALUES (:question_id, :user_id, :reply_content)";
        $stmt = $db->prepare($insert_reply_query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->bindParam(':user_id', $user_id); // Replace with your actual session variable
        $stmt->bindParam(':reply_content', $reply_content);

        if ($stmt->execute()) {
            header("Location: ../questions/question.php?question_id=$question_id")>
            exit();
        } else {
            echo "Error: Failed to insert reply.";
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1452) {
            echo "Error: The user ID in your session is not valid.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>