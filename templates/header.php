<?php
define("APPURL", "http://localhost:80/forum-1");
define("ROOTPATH", dirname(__DIR__));
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Forum</title>
    <!-- link bootstrap framework  -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href=""> -->
</head>

<body>
    <header class="bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">Forum Website</a>
            <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Members</a>
                    </li>
                    <li class="nav-item">
                        <!-- <a class="nav-link" href="<?php echo dirname(__DIR__);?>/emails/create_email.php">Contact us</a> -->
                        <a class="nav-link" href="<?php echo APPURL;?>/emails/create_email.php">Contact us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <!-- Your forum content here -->
    </main>
</body>

</html>