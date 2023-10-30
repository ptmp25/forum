<?php
require dirname(__DIR__) . "../replies/reply_functions.php";

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
    <div class="back-btn">
        <a href="../modules/read_module.php?module_id=<?php echo $question['module_id']; ?>">Back to Module</a>
    </div>

    <div class="page-name">
        <h1>
            <?php echo $question["title"]; ?>
        </h1>
        <div class="d-flex try">
            <?php if (isOwner($question['user_id']) || isAdmin()): ?>
                <form method="post" onsubmit="return confirm('Are you sure you want to delete this question?');"
                    action="delete_question.php">
                    <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>">
                    <input type="hidden" name="module_id" value="<?= $question['module_id'] ?>">
                    <input type="hidden" name="user_id" value="<?= $question['user_id'] ?>">
                    <button type="submit" name="delete_question_btn" class="btn">Delete Question</button>
                </form>
                <a href="../questions/edit_question.php?question_id=<?php echo $question["question_id"]; ?>" class = "btn">Edit Question</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="content-box container">
        <p>
            <strong>Posted by:</strong>
            <?php echo $question['post_by']; ?> on
            <?php echo $question['timestamp']; ?>
        </p>
        <div class="card mt-3">
            <div class="card-body">
                <p class="card-text">
                    <?php echo $question["content"]; ?>
                </p>
                <?php if (!empty($question['image_url'])): ?>
                    <img src="<?php echo $question['image_url']; ?>" alt="Question Image" class="img-fluid">
                <?php endif; ?>
            </div>
        </div>

        <h2 class="mt-3">Replies</h2>
        <ul class="list-group">
            <?php foreach ($replies as $reply): ?>
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <p class="mb-1"><em> By:
                                <?php echo $reply['replied_by']; ?> on
                                <?php echo $reply['timestamp']; ?>
                            </em></p>
                    </div>
                    <p class="mb-1">
                        <?php echo $reply['reply_content']; ?>
                    </p>
                    <div class="d-flex try">
                        <?php if (isOwner($reply['user_id']) || isAdmin()): ?>
                            <form method="post" onsubmit="return confirm('Are you sure you want to delete this reply?');"
                                action="../replies/delete_reply.php">
                                <input type="hidden" name="reply_id" value="<?= $reply['reply_id'] ?>">
                                <input type="hidden" name="user_id" value="<?= $reply['user_id'] ?>">
                                <input type="hidden" name="question_id" value="<?= $reply['question_id'] ?>">
                                <button type="submit" class="btn" name="delete_reply_btn">Delete reply</button>
                            </form>
                            <a href="../replies/edit_reply.php?reply_id=<?php echo $reply["reply_id"]; ?>" class="btn">Edit
                                reply</a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Add a reply form -->
        <h2 class="mt-3">Post a Reply</h2>
        <form method="post" action="../replies/create_reply.php">
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <div class="form-group">
                <textarea name="reply_content" rows="4" cols="50" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Post Reply</button>
        </form>
    </div>

</body>

</html>