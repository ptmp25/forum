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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="content">
        <!-- notification message -->
        <!-- <?php if (isset($_SESSION['success'])): ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?> -->

        <!-- logged in user information -->
        <div class="profile_info">
            <img src="images/user_profile.png">

            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="user/profile.php?user_id=<?php echo $_SESSION['user']['user_id'];?>">
                        <strong>
                            <?php echo $_SESSION['user']['username']; ?>
                        </strong>
                    </a>

                    <small>
                        <i style="color: #888;">(
                            <?php echo ucfirst($_SESSION['user']['role']); ?>)
                        </i>
                        <br>
                        <a href="index.php?logout='1'" style="color: red;">logout</a>
                    </small>
                    <?php 
                    if (isAdmin()){
                        echo "<a href='modules/create_module.php'>Create New Module</a><br>";
                    }
                    ?>
                    <a href="questions/create_question.php?module_id=">Create New Question</a><br>
                <?php endif ?>
            </div>
        </div>

        <?php foreach ($modules as $module): ?>
            <li>
                <a href="modules/read_module.php?module_id=<?php echo $module['module_id']; ?>">
                    <?php echo $module['module_name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </div>
</body>

</html>