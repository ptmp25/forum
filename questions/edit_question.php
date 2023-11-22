<?php
// Include your database connection code here
require dirname(__DIR__) . '/questions/question_functions.php';

$question_id = $_GET['question_id'];
$question = fetchQuestion($db, $question_id);
if (!$question) {
    echo "Question not found.";
}
$user_id = $question['user_id'];
$module_id = $question['module_id'];

// Check if the user is the owner of the question or an admin
if (isOwner($user_id) || isAdmin()) {

} else {
    echo "You are not authorized to edit this question.";
}

if (isset($_POST['edit_question_btn'])) {
    saveEditedQuestion($db);
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
    <main>
        <div class="page-name">
            <strong>Edit Question</strong>
        </div>
        <div class=" content-box container">
            <form method="post" enctype="multipart/form-data" class="form">
                <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" value="<?php echo $question['title']; ?>" class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea name="content" rows="4" class="form-control"
                        required><?php echo $question['content']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Current image:</label>
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
                <div class="form-group">
                    <label for="image_url">Upload Image: <em>(only accept 3 image)</em></label>
                    <input type="file" name="image_url[]" accept="image/*" class="form-control-file" multiple>
                </div>
                <input type="hidden" name="image" value="<?php echo $question["image_url"] ?>">
                <div class="form-group">
                    <label for="module">Module: </label>
                    <select id="moduleSelect" name="module_id" value="" class="form-control">
                        <?php
                        $modules = getModules($db);
                        foreach ($modules as $module): ?>
                            <option value="<?php echo $module['module_id']; ?>" <?php
                               //set the default value if create question for module page 
                               if ($question['module_id'] == $module['module_id']) {
                                   echo "selected='selected'";
                               }
                               ?>>
                                <?php echo $module['module_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <input type="submit" name="edit_question_btn" value="Post Question" class="btn btn-primary">
            </form>
    </main>
</body>

</html>