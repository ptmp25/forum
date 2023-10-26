<?php
require dirname(__DIR__) . "../questions/question_functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}

if (isset($_GET["question_id"])) {
    $question_id = $_GET["question_id"];

    $question = fetchQuestion($db, $question_id);
    $replies = fetchRepliesForQuestion($db, $question_id);

    if ($question === false) {
        echo "Question not found";
        exit();
    }

    if ($replies === false) {
        echo "Error fetching replies";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $question["title"]; ?>
    </title>
</head>

<body>
    <h1>
        <?php echo $question["title"]; ?>
    </h1>
    <?php if (isOwner($question['user_id']) || isAdmin()): ?>
        <form method="post" onsubmit="return confirm('Are you sure you want to delete this question?');"
            action="delete_question.php">
            <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>">
            <input type="hidden" name="module_id" value="<?= $question['module_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $question['user_id'] ?>">
            <input type="submit" name="delete_question" value="Delete Question">
        </form>
        <a href="../questions/edit_question.php?question_id=<?php echo $question["question_id"]; ?>">
            Edit Question
        </a>
    <?php endif; ?>

    <p>
        <?php echo $question["content"]; ?>
    </p>

    <?php if (!empty($question['image_url'])): ?>
        <img src="<?php echo $question['image_url']; ?>" alt="Question Image" width="400">
    <?php endif; ?>

    <a href="../index.php">Back to Homepage</a>
    <a href="../modules/read_module.php?module_id=<?php echo $question['module_id']; ?>">Back to Module</a>

    <h2>Replies</h2>
    <ul>
        <?php foreach ($replies as $reply): ?>
            <li>
                <p>Replied by:
                    <?php echo $reply['replied_by']; ?>
                </p>
                <p>
                    <?php echo $reply['reply_content']; ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Add a reply form -->
    <h2>Post a Reply</h2>
    <form method="post" action="../replies/create_reply.php">
        <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
        <textarea name="reply_content" rows="4" cols="50" required></textarea><br>
        <input type="submit" name="submit" value="Post Reply">
    </form>
</body>

</html>