<?php
// Include your database connection code here
require dirname(__DIR__) . '/questions/question_functions.php';

// Initialize the module_id variable to an empty string
$module_id = "";

if ($_GET['module_id']) {
    $module_id = $_GET['module_id'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Create New Question</title>
</head>

<body>
    <h1>New Question</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for="content">Content:</label>
        <textarea name="content" rows="4" required></textarea><br>
        <label for="image_url">Upload Image:</label>
        <input type="file" name="image_url" accept="image/*"><br>
        <?php
        $query = "SELECT module_id, module_name FROM modules";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label for="module">Module: </label>
        <select id="moduleSelect" name="module_id" value="">
            <?php foreach ($modules as $module): ?>
                <option value="<?php echo $module['module_id']; ?>" <?php
                   //set the default value if create question for module page 
                   if ($module_id && $module['module_id'] == $module_id) {
                       echo "selected='selected'";
                   }
                   ?>>
                    <?php echo $module['module_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" name="post_question_btn" value="Post Question">
    </form>
    <a href="../index.php">Back to Homepage</a>
</body>

</html>