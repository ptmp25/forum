<?php 

    require '../auth/functions.php';

    if (!isAdmin()) {
        $_SESSION['msg'] = "You must log in first";
        header("Location: ../auth/login.php");
    }

if (isset($_POST["submit"])) {
    $module_name = $_POST["module_name"];
    $description = $_POST["description"];
    $user_id = $_SESSION["user"]['user_id']; // Retrieve user ID from the session

    if ($module_name) {
        // Insert the new topic into the 'modules' table
        $query = "INSERT INTO modules (module_name, description, user_id) VALUES (:module_name, :description, :user_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':module_name', $module_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            header("Location: ../index.php"); // Redirect to the homepage after creating the topic
            exit();
        } else {
            echo "Error creating the modules.";
        }
    } else {
        echo "Please fill in module name fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Topic</title>
</head>
<body>
    <h1>Create New Topic</h1>
    
    <form method="post" action="">
        <label for="module_name">Module name:</label>
        <input type="text" name="module_name" required><br>
        
        <label for="description">description:</label>
        <textarea name="description" rows="4" cols="50"></textarea><br>
        
        <input type="submit" name="submit" value="Create Topic">
    </form>
    
    <a href="../index.php">Back to Homepage</a>
</body>
</html>
