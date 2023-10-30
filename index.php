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
                        <?php echo $module['module_name']; ?>
                    </li>
                </a>
            <?php endforeach; ?>
        </div>
        <?php if (isAdmin()) {
            echo "<div class=\"text-center\"><button class=\"btn btn-primary\"><a href='modules/create_module.php'>Create New Module</a><br></button></div>";
        } ?>
    </div>
</body>

</html>