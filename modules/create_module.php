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
    <title>Create New Module</title>
</head>

<body>
    <main>
        <div class="page-name">
            <h1>Create New Module</h1>
        </div>

        <div class="content-box container">
            <form method="post" action="">
                <div class="form-group">
                    <label for="module_name">Module name:</label>
                    <input type="text" name="module_name" class="form-control" required><br>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" rows="4" cols="50"></textarea><br>
                </div>

                <input type="submit" name="new_module_btn" value="Create Module" class="btn btn-primary text-center">
            </form>
        </div>
    </main>
</body>

</html>