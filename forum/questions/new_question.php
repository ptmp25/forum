<?php
// Include your database connection code here
require dirname(__DIR__) . '/auth/functions.php';

// Check if the user is logged in
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['user_id'];
    $module_id = $_POST['module_id'];

    // Define the full server path to the directory where you want to store the uploaded images
    $image_dir = '../img/question_img/';

    $image_url = ''; // Initialize the image URL

    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image_url']['name'];
        $image_temp = $_FILES['image_url']['tmp_name'];

        // Generate a unique file name by appending a timestamp
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
            // Get the newly created question's ID
            $question_id = $db->lastInsertId();

            // Redirect to the question page after creating the question
            header("Location: ../questions/question.php?question_id=$question_id");
            exit();
        } else {
            echo "Error creating the question.";
        }
    } else {
        echo "Please fill in both title and content fields.";
    }
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
        <select id="moduleSelect" name="module_id">
            <?php foreach ($modules as $module): ?>
                <option value="<?php echo $module['module_id']; ?>">
                    <?php echo $module['module_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" name="submit" value="Post Question">
    </form>
    <a href="../index.php">Back to Homepage</a>
</body>

</html>