<?php
require dirname(__DIR__) . "../modules/module_functions.php";
if (!isAdmin()) {
    $_SESSION['msg'] = "You must be an admin to view this page";
    logout();
    header("Location: ../auth/login.php");
}
if (isset($_GET["module_id"])) {
    $module_id = $_GET["module_id"];
    $total_questions = countQuestionsForModule($db, $module_id);

    // Calculate total number of pages
    $total_pages = ceil($total_questions / 5);

    // Get current page number
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

    // Calculate offset for current page
    $offset = ($page - 1) * 5;
    $module = getModuleDetails($db, $module_id);
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $module["module_name"]; ?>
    </title>
    <!-- <title><?php echo $module_id; ?></title> -->
</head>

<body>
    <main>
        <div class="page-name">
            <h1>
                Edit Module
            </h1>
        </div>
        <div class="content-box container">
            <form method="post" action="">
                <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>">
                <div class="form-group">
                    <label for="module_name">Module name:</label>
                    <input type="text" name="module_name" class="form-control"
                        value="<?php echo $module["module_name"]; ?>" required><br>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" class="form-control" rows="4"
                        cols="50"><?php echo $module["description"]; ?></textarea><br>
                </div>

                <input type="submit" name="edit_module_btn" value="Save" class="btn btn-primary text-center">
            </form>
        </div>
        <hr>

        <div class="list">
            <ul>
                <?php foreach ($questions as $question): ?>
                    <a href="../questions/read_question.php?question_id=<?php echo $question["question_id"]; ?>">
                        <li>
                            <?php echo $question["title"]; ?>
                            <div class="d-flex try">
                                <form method="post"
                                    onsubmit="return confirm('Are you sure you want to delete this question?');"
                                    action="../questions/delete_question.php">
                                    <input type="hidden" name="question_id" value="<?= $question['question_id'] ?>">
                                    <input type="hidden" name="module_id" value="<?= $question['module_id'] ?>">
                                    <input type="hidden" name="user_id" value="<?= $question['user_id'] ?>">
                                    <button type="submit" name="delete_question_btn" class="btn btn-danger">Delete
                                        Question</button>
                                </form>
                                <a href="../questions/edit_question.php?question_id=<?php echo $question["question_id"]; ?>"
                                    class="btn btn-primary">Edit Question</a>
                            </div>
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
    </main>
</body>

</html>