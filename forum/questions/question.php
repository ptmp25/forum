<?php
require dirname(__DIR__) . "../auth/functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}

$question = []; // Initialize the $question array

if (isset($_GET["question_id"])) {
    $question_id = $_GET["question_id"];

    try {
        // Fetch question details
        $question_query = "SELECT * FROM questions WHERE question_id = :question_id";
        $stmt = $db->prepare($question_query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $question = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Question not found";
            exit();
        }

        // Fetch the replies related to the question
        $replies_query = "SELECT replies.reply_content AS reply_content, users.username AS replied_by
                        FROM replies 
                        JOIN users ON replies.user_id = users.user_id
                        WHERE replies.question_id = :question_id";
        $stmt = $db->prepare($replies_query);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->execute();
        $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid question ID: " . isset($_GET["question_id"]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $question["title"]; ?></title>
</head>

<body>
    <h1><?php echo $question["title"]; ?></h1>
    <p><?php echo $question["content"]; ?></p>

    <?php if (!empty($question['image_url'])): ?>
        <img src="<?php echo $question['image_url']; ?>" alt="Question Image" width="400">
    <?php endif; ?>

    <a href="../questions/new_question.php?module_id=<?php echo $module['module_id']; ?>"></a>
    <a href="../index.php">Back to Homepage</a>

    <h2>Replies</h2>
    <ul>
        <?php foreach ($replies as $reply): ?>
            <li>
                <p>Replied by: <?php echo $reply['replied_by']; ?></p>
                <p><?php echo $reply['reply_content']; ?></p>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Add a reply form -->
    <h2>Post a Reply</h2>
    <form method="post" action="../replies/new_reply.php">
        <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
        <textarea name="reply_content" rows="4" cols="50" required></textarea><br>
        <input type="submit" name="submit" value="Post Reply">
    </form>
</body>
</html>
