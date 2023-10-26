<?php 

    require '../modules/module_functions.php';

    if (!isAdmin()) {
        $_SESSION['msg'] = "You must log in first";
        header("Location: ../auth/login.php");
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
        
        <input type="submit" name="new_module_btn" value="Create Module">
    </form>
    
    <a href="../index.php">Back to Homepage</a>
</body>
</html>
