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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $module["module_name"]; ?>
    </title>
    <!-- <title><?php echo $module_id; ?></title> -->
</head>

<body>
    <div class="page-name">
        <h1>
            <?php echo $module["module_name"]; ?>
        </h1>
    </div>

    <div class="list">
        <ul>
            <?php foreach ($questions as $question): ?>
                <a href="../questions/read_question.php?question_id=<?php echo $question["question_id"]; ?>">
                    <li>
                        <?php echo $question["title"]; ?>
                    </li>
                </a>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="d-flex try">
        <div class="text-center">
            <button class="btn btn-primary">
                <a href="../questions/create_question.php?module_id=<?php echo $module['module_id']; ?>">Create New
                    Question</a>
            </button>
        </div>
        <?php if (isAdmin()): ?>
            <div class="text-center">
                <button class="btn btn-primary">
                    <a href="../modules/edit_module.php?module_id=<?php echo $module['module_id']; ?>">Edit Module</a>
                </button>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>