<?php

session_start();
$APPURL = "http://localhost/forum/";
try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=forum_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Variable declaration
$username = "";
$email = "";
$errors = array();
$success = "";
$succeed = "";

// Call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

function register()
{
    global $db, $errors, $username, $email, $success, $succeed;

    $username = e($_POST['username']);
    $email = e($_POST['email']);
    $password_1 = e($_POST['password_1']);
    $password_2 = e($_POST['password_2']);
    if (isset($_POST['about'])) {
        $role = e($_POST['about']);
    }
    if (isset($_FILES['profile_picture'])) {
        $profile_picture = uploadProfilePicture($_FILES['profile_picture']); // Handle file upload
    } else {
        $profile_picture = "../img/profile_img/default_profile_img.png";
    }

    if (isset($_POST['role'])) {
        $role = e($_POST['role']);
    }

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    // Check the password length
    if (strlen($password_1) < 6 || strlen($password_1) > 25) {
        array_push($errors, "Password must be between 6 and 25 characters long");
    }

    // Check if the username already exists in the database
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Username already exists, display an error message
        array_push($errors, "Username already exists");
    }

    // Check if the Email already exists in the database
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Email already exists, display an error message
        array_push($errors, "Email already exists");
    }


    if (count($errors) == 0) {
        $password = password_hash($password_1, PASSWORD_DEFAULT);

        if (isset($_POST['role'])) {
            $role = e($_POST['role']);
        } else {
            $role = 'user';
        }

        if (count($errors) == 0) {
            $query = "INSERT INTO users (username, email, role, password, profile_picture, about) 
                    VALUES(:username, :email, :role, :password, :profile_picture, :about)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':profile_picture', $profile_picture);
            $stmt->bindParam(':about', $about);
            $stmt->execute();

            $_SESSION['success'] = "New user successfully created!!";
            $success = "You have registered as $username. Now you can <a href='login.php'>Login</a>";
            $succeed = "Created <em> $username </em> successful.";
            // header('Location: ../index.php');
        }
    }
}

function uploadProfilePicture($file)
{
    global $errors;

    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $targetDirectory = "/img/profile_img/"; // Directory where uploaded files will be stored
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
        return "../img/profile_img/default_profile_img.png";
    }
}

function getUserById($id)
{
    global $db;
    $query = "SELECT * FROM users WHERE user_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function e($val)
{
    // Use htmlspecialchars for escaping user input when displaying it on the page
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

function display_success()
{
    global $success;
    if ($success) {
        echo '<div class="success">';
        echo $success . '<br>';
        echo '</div>';
    }
    $success = "";
}

function display_succeed()
{
    global $succeed;
    if ($succeed) {
        echo '<div class="success">';
        echo $succeed . '<br>';
        echo '</div>';
    }
    $success = "";
}
function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn()
{
    return (isset($_SESSION['user'])) ;
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: ../auth/login.php");
}

function logout()
{
    session_destroy();
    unset($_SESSION['user']);
    header("Location: ../auth/login.php");
}

// Call the login() function if login_btn is clicked
if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN USER
function login()
{
    global $db, $username, $errors;
    $errors = array();
    // Grab form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // Make sure the form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // Attempt login if no errors on the form
    if (count($errors) == 0) {
        // Hash the password using PHP's password_hash function before comparing
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // User found and password matches
                $_SESSION['user'] = $user;
                $_SESSION['success'] = "You are now logged in";

                if ($user['user_type'] == 'admin') {
                    header('Location: ../admin/home.php');
                } else {
                    header('Location: ../index.php');
                }
            } else {
                array_push($errors, "Wrong username/password combination");
            }
        } else {
            array_push($errors, "User not found");
        }
    }
}

function isAdmin()
{
    return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
}

function isOwner($user_id)
{
    return ($_SESSION['user']['user_id'] == $user_id);
}