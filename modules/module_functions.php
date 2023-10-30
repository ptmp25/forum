<?php
require dirname(__DIR__) . "../auth/functions.php";
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}
include(dirname(__DIR__) . "/templates/header.php");

function getModules($db)
{
    $query = "SELECT * FROM modules";
    $stmt = $db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getModuleDetails($db, $module_id)
{
    try {
        // Fetch module details
        $module_query = "SELECT * FROM modules WHERE module_id = :module_id";
        $stmt = $db->prepare($module_query);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->execute();

        // Check if the query executed successfully and if there is a valid module
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false; // Module not found
        }
    } catch (PDOException $e) {
        return false; // Error occurred
    }
}

function getQuestionsForModule($db, $module_id)
{
    try {
        // Fetch questions related to the selected module
        $questions_query = "SELECT * FROM questions WHERE module_id = :module_id";
        $stmt = $db->prepare($questions_query);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false; // Error occurred
    }
}


if (isset($_POST["new_module_btn"])) {
    createNewModule();
}

function createNewModule()
{
    global $db;

    $module_name = $_POST["module_name"];
    $description = $_POST["description"];
    $user_id = $_SESSION["user"]['user_id']; // Retrieve user ID from the session

    if ($module_name) {
        // Insert the new module into the 'modules' table
        $query = "INSERT INTO modules (module_name, description, user_id) VALUES (:module_name, :description, :user_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':module_name', $module_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            header("Location: ../index.php"); // Redirect to the homepage after creating the module
            exit();
        } else {
            echo "Error creating the module.";
        }
    } else {
        echo "Please fill in module name field.";
    }
}

if (isset($_POST["edit_module_btn"])) {
    editModule();
}

function editModule(){
    global $db;

    $module_id = $_POST["module_id"];
    $module_name = $_POST["module_name"];
    $description = $_POST["description"];

    if ($module_name) {
        // Update the module in the 'modules' table
        $query = "UPDATE modules SET module_name = :module_name, description = :description WHERE module_id = :module_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':module_name', $module_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':module_id', $module_id);

        if ($stmt->execute()) {
            header("Location: ../modules/read_module.php?module_id=" .  $module_id); // Redirect to the homepage after creating the module
            exit();
        } else {
            echo "Error editing the module.";
        }
    } else {
        echo "Please fill in module name field.";
    }
}