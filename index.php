<?php
require __DIR__ . "../modules/module_functions.php";
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../forum/auth/login.php");
}

$modulesPerPage = 5; // Change this to the desired number of modules per page

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $modulesPerPage;

$modules = getModules($db);
$totalModules = count($modules);
$totalPages = $totalModules > 0 ? ceil($totalModules / $modulesPerPage) : 0;

$modules = array_slice($modules, $offset, $modulesPerPage);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <div class="content">

        <!-- logged in user information -->
        <div class="profile_info">
            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="page-name">
                        <strong>
                            Welcome,
                            <?php echo $_SESSION['user']['username']; ?>
                        </strong>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary">
                    <a href="questions/create_question.php?module_id=">Create New Question</a>
                </button>
            </div>
        <?php endif ?>
        <div class="list">
            <?php foreach ($modules as $module): ?>
                <a href="modules/read_module.php?module_id=<?php echo $module['module_id']; ?>">
                    <li>
                        <?php if (isAdmin()): ?>
                            <form action="modules/delete_module.php" method="post" style="float: right;display: inline-block; "
                                onsubmit="return confirm('Are you sure you want to delete this module?');">
                                <input type="hidden" name="module_id" value="<?php echo $module['module_id']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_module_btn">Delete Module
                                </button>
                            </form>
                        <?php endif; ?>
                        <?php
                        echo $module['module_name'] . "<br>";
                        $module_id = $module['module_id'];
                        // count number of questions with same module ID
                        $stmt = $db->prepare("SELECT COUNT(*) FROM questions WHERE module_id = :module_id");
                        $stmt->bindParam(':module_id', $module_id);
                        $stmt->execute();
                        $num_questions = $stmt->fetchColumn();

                        // count number of replies with same module ID
                        $stmt = $db->prepare("SELECT COUNT(*) FROM replies WHERE question_id IN (SELECT question_id FROM questions WHERE module_id = :module_id)");
                        $stmt->bindParam(':module_id', $module_id);
                        $stmt->execute();
                        $num_replies = $stmt->fetchColumn();
                        echo "<em>(";
                        if ($num_questions > 0) {
                            echo $num_questions . " question" . ($num_questions > 1 ? "s" : "");
                        }
                        if ($num_questions > 0 && $num_replies > 0) {
                            echo ", ";
                        }
                        if ($num_replies > 0) {
                            echo $num_replies . " repl" . ($num_replies > 1 ? "ies" : "y");
                        }
                        if ($num_questions == 0 && $num_replies == 0) {
                            echo "no question yet";
                        }
                        echo ")</em>";
                        ?>

                    </li>
                </a>
            <?php endforeach; ?>
        </div>
        <?php if (isAdmin()) {
            echo "<div class=\" text-center\"><button class=\" btn btn-primary\"><a href='modules/create_module.php'>Create New Module</a><br></button></div>";
        } ?>

        <div class="pagination justify-content-center">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <li class="page-item active">
                            <span class="page-link">
                                <?php echo $i; ?>
                                <span class="sr-only">(current)</span>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>
</body>

</html>