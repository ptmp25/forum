<?php
require dirname(__DIR__) . "../modules/module_functions.php";

if (isset($_GET["module_id"])) {
    $module_id = $_GET["module_id"];

    $module = getModuleDetails($db, $module_id);
    $questions = getQuestionsForModule($db, $module_id);

    if ($module === false || $questions === false) {
        echo "Error fetching module details or questions";
        exit();
    } else {
        // Use $module and $questions as needed
    }
} else {
    echo "Invalid module ID" . isset($_GET["module_id"]);
    exit();
}
include(dirname(__DIR__). "/templates/header.php");

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
                <a href="../questions/read_question.php?question_id=<?php echo $question["question_id"]; ?>">
                    <?php echo $question["title"]; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="../questions/create_question.php?module_id=<?php echo $module['module_id']; ?>"> Create question</a>
    <a href="../index.php">Back to Homepage</a>
    <!-- <a href="../index.php?logout='1'" style="color: red;">logout</a> -->
</body>
</html>