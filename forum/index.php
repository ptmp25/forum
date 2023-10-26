<?php
require __DIR__ . "../auth/functions.php";
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../forum/auth/login.php");
}

$query = "SELECT module_id, module_name FROM modules";
$stmt = $db->prepare($query);
$stmt->execute();
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h2>Home Page</h2>
    </div>
    <div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <!-- logged in user information -->
        <div class="profile_info">
            <img src="images/user_profile.png">

            <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <strong>
                        <?php echo $_SESSION['user']['username']; ?>
                    </strong>

                    <small>
                        <i style="color: #888;">(
                            <?php echo ucfirst($_SESSION['user']['role']); ?>)
                        </i>
                        <br>
                        <a href="index.php?logout='1'" style="color: red;">logout</a>
                    </small>
                    <?php 
                    if (isAdmin()){
                        echo "<a href='modules/new_module.php'>Create New Module</a><br>";
                    }
                    ?>
                    <a href="questions/new_question.php">Create New Question</a><br>
                <?php endif ?>
            </div>
        </div>

        <?php foreach ($modules as $module): ?>
            <li>
                <a href="modules/module.php?module_id=<?php echo $module['module_id']; ?>">
                    <?php echo $module['module_name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </div>
</body>

</html>