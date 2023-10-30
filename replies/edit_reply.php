<?php
// Include your database connection code here
require dirname(__DIR__) . '/replies/reply_functions.php';

$reply_id = $_GET['reply_id'];
$reply = fetchReply($db, $reply_id);
if (!$reply) {
    echo "Reply not found.";
}
$user_id = $reply['user_id'];
$question_id = $reply['question_id'];

// Check if the user is the owner of the question or an admin
if (isOwner($user_id) || isAdmin()) {

} else {
    echo "You are not authorized to edit this question.";
}

if (isset($_POST['edit_question_btn'])) {
    saveEditedReply($db);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
</head>

<body>
    <div class="page-name">
        <h1>
            Edit Reply
        </h1>
    </div>
    <div class="content-box container">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="question_id" value="<?= $question_id ?>">
            <input type="hidden" name="reply_id" value="<?php echo $reply_id; ?>">
            <div class="form-group">
                <label for="reply_content">Reply Content:</label>
                <textarea name="reply_content" rows="4" class="form-control-file" required><?php echo $reply['reply_content']; ?></textarea>
            </div>
            <input type="submit" name="edit_question_btn" class="btn btn-primary" value="Save Edit">
        </form>
    </div>

</body>

</html>