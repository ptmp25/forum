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
    <div class="page-name">
        <strong>New Question</strong>
    </div>
    <div class=" content-box container">
        <form method="post" enctype="multipart/form-data" class="form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" rows="4" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="image_url">Upload Image:</label>
                <input type="file" name="image_url" accept="image/*" class="form-control-file">
            </div>
            <?php
            $query = "SELECT module_id, module_name FROM modules";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <div class="form-group">
                <label for="module">Module: </label>
                <select id="moduleSelect" name="module_id" value="" class="form-control">
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
            </div>
            <input type="submit" name="post_question_btn" value="Post Question" class="btn btn-primary">
        </form>
    </div>
</body>

</html>