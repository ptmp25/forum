<?php
require dirname(__DIR__) . "../questions/question_functions.php";

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: $APPURL/auth/login.php");
}

$user_id = $_GET['user_id'];

$user = getUserById($user_id);
$questions = fetchQuestionByUserId($db, $user_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <img src="<?php echo $user['profile_picture']; ?>" class="card-img-top" alt="Profile Image">
                    <h5 class="card-title">
                        <?php echo $user['username']; 
                        // if (!($_SESSION['user']['user_id'] == $user_id) && !isAdmin())
                        //     {echo "<em><a href=\"edit_profile.php?user_id=" . $user['user_id'] . ">Edit profile</a></em>";}
                        // ?>
                        <em><a href="edit_profile.php?user_id=<?php echo $user['user_id']; ?>">Edit profile</a></em>
                    </h5>
                    <p class="card-text">
                        <em>(<?php echo $user['role']; ?>)</em>
                    </p>
                    <p class="card-text">
                        Email: <em><?php echo $user['email']; ?></em>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">About Me</h5>
                    <p class="card-text">
                        <?php echo $user['about']; ?>
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Questions - <?php echo countQuestionsByUserId($db, $user_id);?></h5>
                    <div class="list">
                        <ul>
                            <?php
                            if ($questions)
                                foreach ($questions as $question): ?>
                                    <a
                                        href="../questions/read_question.php?question_id=<?php echo $question["question_id"]; ?>">
                                        <li>
                                            <?php echo $question["title"]; ?>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

</body>

</html>