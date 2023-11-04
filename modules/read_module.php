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
        <p>
            <?php echo $module["description"]; ?>
        </p>
    </div>

    <div class="list">
        <ul>
            <?php foreach ($questions as $question): ?>
                <a href="../questions/read_question.php?question_id=<?php echo $question["question_id"]; ?>">
                    <li style="width: 75%;">
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
            <div class="text-center">
                <form action="../modules/delete_module.php" method="post" onsubmit="return confirm('Are you sure you want to delete this question?');">
                <input type="hidden" name="module_id" value="<?php echo $module['module_id'];?>">
                <button type="submit" class="btn btn-danger" name ="delete_module_btn">Delete Module
                </button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>