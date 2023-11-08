<?php
require dirname(__DIR__) . "../auth/functions.php";

include(dirname(__DIR__) . "/templates/header.php");
// Get the user's ID from the session
$user_id = $_GET['user_id'];
if (!($_SESSION['user']['user_id'] == $user_id) && !isAdmin()) {
    $_SESSION['msg'] = "You are not authorized to access this page";
    header("Location: $APPURL/index.php");
}

// Get the user's current profile information from the database
$stmt = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch();

function updateProfilePicture($file)
{
    global $errors, $user;

    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = "../img/profile_img/"; // Directory where uploaded files will be stored
        $targetFile = $targetDirectory . basename($file['name']); // Full path to the uploaded file

        $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Check if the file is an image
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            array_push($errors, "File is not an image.");
            return null;
        }

        // Check file size (adjust max file size as needed)
        if ($file['size'] > 5000000) {
            array_push($errors, "File is too large. Maximum size allowed is 5MB.");
            return null;
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile; // Return the file path
        } else {
            array_push($errors, "Failed to upload file.");
            return null;
        }
    } else {
        // Return the default profile picture path
        return $user['profile_picture'];
    }
}

// Check if the form has been submitted
if (isset($_POST['edit_profile_btn'])) {
    // Get the form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $about = $_POST['about'];
    $profile_picture = updateProfilePicture($_FILES['profile_picture']);
    $user_id = $_GET['user_id'];

    // Validate the form data
    $errors = [];

    if (empty($username)) {
        $errors[] = 'Name is required';
    }

    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email is invalid';
    }

    // If there are no errors, update the user's profile information in the database
    if (empty($errors)) {
        $stmt = $db->prepare('UPDATE users 
                            SET username = :username, email = :email, profile_picture = :profile_picture, about = :about 
                            WHERE user_id = :user_id');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':profile_picture', $profile_picture, PDO::PARAM_STR);
        $stmt->bindParam(':about', $about);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        // Redirect to the profile page
        header('Location: profile.php?user_id=' . $user_id);
        exit();
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile</title>
</head>

<body>
    <div class="register container">
        <div class="card">
            <div class="card-header">
                <h2>Edit Profile</h2>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="card-body">
                    <!-- show error message  -->
                    <em>
                        <?php echo display_error(); ?>
                    </em>
                    <em>
                        <?php echo display_success(); ?>
                    </em>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username"
                            value="<?php echo $user['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>">
                    </div>
                    <!-- <div class="form-group">
                        <label for="password_1">Password</label>
                        <input type="password" class="form-control" name="password_1">
                    </div>
                    <div class="form-group">
                        <label for="password_2">Confirm password</label>
                        <input type="password" class="form-control" name="password_2">
                    </div> -->
                    <?php if (isAdmin()): ?>
                        <label for="role">User type</label>
                        <select name="role" id="role" class="form-control">
                            <option value=""></option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="about">About</label>
                        <textarea type="password" class="form-control"
                            name="about"><?php echo $user['about']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Current Profile Image:</label>
                        <img src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
                    </div>
                    <div class="form-group">
                        <label>Profile Picture:</label>
                        <input type="file" class="file-form-control" name="profile_picture" accept="image/*"
                            value="<?php echo $user['profile_picture']; ?>">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary register_btn" name="edit_profile_btn">Save</button>
                    </div>
            </form>
        </div>
    </div>
</body>

</html>