<?php
require dirname(__DIR__) . "../auth/functions.php";
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}

if (isset($_GET["module_id"])) {
    $module_id = $_GET["module_id"];

    try {
        // Fetch module details
        $module_query = "SELECT * FROM modules WHERE module_id = :module_id";
        $stmt = $db->prepare($module_query);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->execute();

        // Check if the query executed successfully and if there is a valid module
        if ($stmt->rowCount() > 0) {
            $module = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "module not found";
            exit();
        }

        // Fetch questions related to the selected module
        $questions_query = "SELECT * FROM questions WHERE module_id = :module_id";
        $stmt = $db->prepare($questions_query);
        $stmt->bindParam(':module_id', $module_id);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "Invalid module ID" . isset($_GET["module_id"]);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $module["module_name"]; ?></title>
    <!-- <title><?php echo $module_id; ?></title> -->
</head>
<body>
    
    <ul>
        <?php foreach ($questions as $question): ?>
            <li>
                <a href="../questions/question.php?question_id=<?php echo $question["question_id"]; ?>">
                    <?php echo $question["title"]; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../questions/new_question.php?question_is=<?php echo $module['module_id']; ?>">
    <a href="../index.php">Back to Homepage</a>
    <!-- <a href="../index.php?logout='1'" style="color: red;">logout</a> -->
</body>
</html>