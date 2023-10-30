<?php
// Include your database connection code here
require dirname(__DIR__) . '/modules/module_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_question_btn'])) {
    processNewQuestion($db);
}

function processNewQuestion($db)
{
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['user_id'];
    $module_id = $_POST['module_id'];

    $image_url = ''; // Initialize the image URL

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $image_dir = '../img/question_img/';
        $image_name = $_FILES['image_url']['name'];
        $image_temp = $_FILES['image_url']['tmp_name'];

        $timestamp = time();
        $image_name = $timestamp . '_' . $image_name;

        $image_url = $image_dir . $image_name;

        if (move_uploaded_file($image_temp, $image_url)) {
            // Image uploaded successfully
        } else {
            echo "Error: Failed to move the uploaded image.";
            exit();
        }
    }

    if ($title && $content) {
        // Insert the new question into the 'questions' table
        $query = "INSERT INTO questions (title, content, user_id, module_id, image_url) 
                  VALUES (:title, :content, :user_id, :module_id, :image_url)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->bindParam(':image_url', $image_url);

        if ($stmt->execute()) {
            $question_id = $db->lastInsertId();
            header("Location: ../questions/read_question.php?question_id=$question_id");
            exit();
        } else {
            echo "Error creating the question.";
        }
    } else {
        echo "Please fill in both title and content fields.";
    }

}

function fetchQuestion($db, $question_id)
{
    try {
        $question_query = "SELECT questions.*, users.username AS post_by FROM questions JOIN users ON questions.user_id = users.user_id WHERE questions.question_id =:question_id;";
        $stmt = $db->prepare($question_query);
        $stmt->bindParam(':question_id', $question_id);
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

function fetchRepliesForQuestion($db, $question_id)
{
    try {
        $replies_query = "SELECT replies.*, users.username AS replied_by
                  FROM replies 
                  JOIN users ON replies.user_id = users.user_id
                  WHERE replies.question_id = :question_id";
        $stmt = $db->prepare($replies_query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function isOwner($user_id)
{
    if ($_SESSION['user']['user_id'] == $user_id) {
        return true;
    } else {
        return false;
    }
}


function deleteQuestion($db, $question_id)
{
    try {
        // Delete the question from the 'questions' table
        $query = "DELETE FROM questions WHERE question_id = :question_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':question_id', $question_id);
        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

function saveEditedQuestion($db)
{
    $question_id = $_POST['question_id'];
    $editedTitle = $_POST['title'];
    $editedContent = $_POST['content'];
    $module_id = $_POST['module_id'];

    // $image_url = ''; // Initialize the image URL

    // if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
    //     $image_dir = '../img/question_img/';
    //     $image_name = $_FILES['image_url']['name'];
    //     $image_temp = $_FILES['image_url']['tmp_name'];

    //     $timestamp = time();
    //     $image_name = $timestamp . '_' . $image_name;

    //     $image_url = $image_dir . $image_name;

    //     if (move_uploaded_file($image_temp, $image_url)) {
    //         // Image uploaded successfully
    //     } else {
    //         echo "Error: Failed to move the uploaded image.";
    //         exit();
    //     }
    // }

    if ($editedTitle && $editedContent) {
        // Update the question in the 'questions' table
        $query = "UPDATE questions SET title = :editedTitle, content = :editedContent, module_id = :module_id WHERE question_id = :question_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->bindParam(':editedTitle', $editedTitle);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->bindParam(':editedContent', $editedContent);

        if ($stmt->execute()) {
            header("Location: ../questions/read_question.php?question_id=$question_id");
            exit();
        } else {
            echo "Error.";
        }
    } else {
        echo "Please fill in both title and content fields.";
    }
}
