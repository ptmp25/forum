<?php
require dirname(__DIR__) . "/questions/question_functions.php";

function addReply($db, $question_id, $user_id, $reply_content){    
    try {
        // Insert the reply into the database
        $insert_reply_query = "INSERT INTO replies (question_id, user_id, reply_content) VALUES (:question_id, :user_id, :reply_content)";
        $stmt = $db->prepare($insert_reply_query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->bindParam(':user_id', $user_id); // Replace with your actual session variable
        $stmt->bindParam(':reply_content', $reply_content);

        if ($stmt->execute()) {
            header("Location: ../questions/read_question.php?question_id=$question_id") >
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

function deleteReply($db, $reply_id)
{
    try {
        // Delete the reply from the 'replies' table
        $query = "DELETE FROM replies WHERE reply_id = :reply_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':reply_id', $reply_id);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

function fetchReply($db, $reply_id)
{
    try {
        $reply_query = "SELECT * FROM replies WHERE reply_id = :reply_id";
        $stmt = $db->prepare($reply_query);
        $stmt->bindParam(':reply_id', $reply_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false; // Question not found
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function saveEditedReply($db){
    $reply_id = $_POST['reply_id'];
    $editedContent = $_POST['reply_content'];
    $question_id = $_POST['question_id'];
    // echo "check";
    if ($editedContent) {
        $query = "UPDATE replies SET reply_content = :editedContent WHERE reply_id = :reply_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':editedContent', $editedContent);
        // Assuming you have a $reply_id variable
        $stmt->bindParam(':reply_id', $reply_id); 

        if ($stmt->execute()) {
            header("Location: ../questions/read_question.php?question_id=$question_id");
            exit();
        } else {
            echo "Error.";
        }
    }

}

function countRepliesForQuestion($db, $question_id)
{
    try {
        $query = "SELECT COUNT(*) FROM replies WHERE question_id = :question_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>