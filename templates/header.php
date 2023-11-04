<?php
$APPURL = "http://localhost:80/forum";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Forum</title>
    <!-- link bootstrap framework  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $APPURL; ?>/css/style.css">
</head>

<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="<?php echo $APPURL; ?>/index.php">Greenwich Forum</a>
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $APPURL; ?>/index.php">Home</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $APPURL; ?>/emails/create_email.php">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="<?php echo $APPURL; ?>/user/profile.php?user_id=<?php echo $_SESSION['user']['user_id'] ?>">My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $APPURL; ?>/index.php?logout='1">Logout</a>
                    </li>
                    <?php
                    if ($_SESSION['user']['role'] == 'admin') {
                        echo "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"$APPURL/admin/home.php\">Admin Panel</a>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <!-- Your forum content here -->
    </main>
</body>

</html>