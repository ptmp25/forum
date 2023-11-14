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
function countQuestionsForModule($db, $module_id)
{
    $stmt = $db->prepare("SELECT COUNT(*) AS question_count FROM questions WHERE module_id = :module_id");
    $stmt->bindParam(':module_id', $module_id);
    $stmt->execute();
    return $stmt->fetchColumn();
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

function getQuestionsForModule($db, $module_id, $offset, $limit)
{
    $questions_query = "SELECT q.*, u.username AS author, COUNT(r.question_id) AS num_replies FROM questions q 
                            LEFT JOIN users u ON q.user_id = u.user_id 
                            LEFT JOIN replies r ON q.question_id = r.question_id 
                            WHERE q.module_id = :module_id 
                            GROUP BY q.question_id
                            LIMIT :offset, :limit";
    $stmt = $db->prepare($questions_query);
    $stmt->bindParam(':module_id', $module_id);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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


function deleteModule($module_id){
    global $db;

    // $module_id = $_POST["module_id"];

    // Delete the module from the 'modules' table
    $query = "DELETE FROM modules WHERE module_id = :module_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':module_id', $module_id);

    if ($stmt->execute()) {
        // Delete the questions related to the module from the 'questions' table
        $query = "DELETE FROM questions WHERE module_id = :module_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->execute();

        header("Location: ../index.php"); // Redirect to the homepage after deleting the module
        exit();
    } else {
        echo "Error deleting the module.";
    }
}
