<?php
require dirname(__DIR__) . "../replies/reply_functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}

if (isset($_GET["question_id"])) {
    $question_id = $_GET["question_id"];

    $question = fetchQuestion($db, $question_id);

    if ($question === false) {
        echo "Question not found";
        exit();
    }

    // Pagination
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $replies_per_page = 5;
    $replies_count = countRepliesForQuestion($db, $question_id);
    $total_pages = ceil($replies_count / $replies_per_page);
    $offset = ($page - 1) * $replies_per_page;

    $replies = fetchRepliesForQuestion($db, $question_id, $offset, $replies_per_page);

    if ($replies === false) {
        echo "Error fetching replies";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php echo $question["title"]; ?>
    </title>
</head>

<body>
    <!-- <div class="back-btn">
        <a href="../modules/read_module.php?module_id=<?php echo $question['module_id']; ?>">Back to Module</a>
    </div> -->
    <main>
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
                        <button type="submit" name="delete_question_btn" class="btn btn-danger">Delete Question</button>
                    </form>
                    <a href="../questions/edit_question.php?question_id=<?php echo $question["question_id"]; ?>"
                        class="btn btn-primary">Edit Question</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="content-box container">
            <p>
                <strong>Module name:</strong>
                <em>
                    <a href="../modules/read_module.php?module_id=<?php echo $question['module_id']; ?>">
                        <?php echo $question["module"]; ?>
                </em>
                </a>
            </p>
            <p>
                <strong>Posted by:</strong>
                <em>
                    <a href="../user/profile.php?user_id=<?php echo $question['user_id']; ?>">
                        <?php echo $question['post_by']; ?>

                    </a></em> on
                <?php echo $question['timestamp']; ?>
            </p>
            <div class="card mt-3">
                <div class="card-body">
                    <p class="card-text">
                        <strong>Question:</strong>
                        <?php echo $question["content"]; ?>
                    </p>
                    <?php if (!empty($question['image_url'])): ?>
                        <div class="image-container">

                            <?php
                            $images = explode(",", $question["image_url"]);
                            foreach ($images as $image): ?>
                                <img src="<?php echo $image; ?>" alt="Question Image" class="img-fluid">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <h2 class="mt-3">Replies</h2>
            <ul class="list-group">
                <?php foreach ($replies as $reply): ?>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <p class="mb-1"><em> By:
                                    <a href="../user/profile.php?user_id=<?php echo $reply['user_id']; ?>">
                                        <?php echo $reply['replied_by']; ?>
                                    </a> on
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
                                    <button type="submit" class="btn btn-danger" name="delete_reply_btn">Delete reply</button>
                                </form>
                                <a href="../replies/edit_reply.php?reply_id=<?php echo $reply["reply_id"]; ?>"
                                    class="btn btn-primary">Edit reply</a>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Pagination links -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination justify-content-center">
                    <ul class="pagination">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?question_id=<?php echo $question_id; ?>&page=<?php echo $page - 1; ?>">Previous</a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?question_id=<?php echo $question_id; ?>&page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?question_id=<?php echo $question_id; ?>&page=<?php echo $page + 1; ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

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
    </main>

</body>

</html>