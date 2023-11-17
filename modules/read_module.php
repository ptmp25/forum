<?php
require dirname(__DIR__) . "../modules/module_functions.php";

if (isset($_GET["module_id"])) {
    $module_id = $_GET["module_id"];

    $module = getModuleDetails($db, $module_id);

    // Get total number of questions for the module
    $total_questions = countQuestionsForModule($db, $module_id);

    // Calculate total number of pages
    $total_pages = ceil($total_questions / 5);

    // Get current page number
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

    // Calculate offset for current page
    $offset = ($page - 1) * 5;

    // Get questions for current page
    $questions = getQuestionsForModule($db, $module_id, $offset, 5);
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
    <main>
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
                            <br>
                            <small>
                                Author:
                                <?php echo $question["author"]; ?>
                                Replies:
                                <?php echo $question["num_replies"]; ?>
                            </small>
                        </li>
                    </a>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Pagination links -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <a href="?module_id=<?php echo $module_id; ?>&page=<?php echo $page - 1; ?>" class="page-link">Previous</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <li class="page-item active">
                            <span class="page-link">
                                <?php echo $i; ?>
                                <span class="sr-only">(current)</span>
                            </span>
                        </li>
                    <?php else: ?>
                        <a href="?module_id=<?php echo $module_id; ?>&page=<?php echo $i; ?>" class="page-link">
                            <?php echo $i; ?>
                        </a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?module_id=<?php echo $module_id; ?>&page=<?php echo $page + 1; ?>" class="page-link">Next</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="pagination justify-content-center">
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
                    <form action="../modules/delete_module.php" method="post"
                        onsubmit="return confirm('Are you sure you want to delete this module?');">
                        <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>">
                        <button type="submit" class="btn btn-danger" name="delete_module_btn">Delete Module
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>