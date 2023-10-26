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
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo $question['title']; ?>" required><br>
        <label for="content">Content:</label>
        <textarea name="content" rows="4" required><?php echo $question['content']; ?></textarea><br>
        <label for="image_url">Upload Image:</label>
        <input type="file" name="image_url" accept="image/*" ?><br>
        <?php
        $query = "SELECT module_id, module_name FROM modules";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="module">Module: </label>
        <select id="moduleSelect" name="module_id" value="">
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
        <br>
        <input type="submit" name="edit_question_btn" value="Post Question">
    </form>
    <a href="../modules/read_module.php?module_id=<?php echo $question['module_id']; ?>">Back to Module</a>
</body>

</html>