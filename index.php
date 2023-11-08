<?php
require __DIR__ . "../modules/module_functions.php";
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../forum/auth/login.php");
}

$modules = getModules($db);
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
                            echo "not question yet";
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
    </div>
</body>

</html>