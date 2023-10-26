<?php
session_start();

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

// Call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

function register()
{
    global $db, $errors, $username, $email, $success;

    $username = e($_POST['username']);
    $email = e($_POST['email']);
    $password_1 = e($_POST['password_1']);
    $password_2 = e($_POST['password_2']);
    // $profile_picture = getProfilePicturePath(); // Comment this line out

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
        $password = password_hash($password_1, PASSWORD_DEFAULT); // Use password_hash for secure password hashing

        if (isset($_POST['role'])) {
            $role = e($_POST['role']);
        } else {
            $role = 'user';
        }

        // Handle profile picture upload
        if (isset($_FILES['profile_picture'])) {
            $file = $_FILES['profile_picture'];

            // Validate the file type (image)
            $fileType = exif_imagetype($file['tmp_name']);
            if ($fileType === false) {
                array_push($errors, "Invalid file type. Please upload an image.");
            } else {
                // Define the directory to save the uploaded files
                $uploadDirectory = '../img/profile_img/';

                // Create the directory if it doesn't exist
                if (!file_exists($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true);
                }

                // Generate a unique filename for the uploaded image
                $fileName = uniqid('profile_pic_') . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);

                // Move the uploaded file to the destination directory
                $destination = $uploadDirectory . $fileName;
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    // File upload was successful, and $destination contains the path to the saved image.
                    // You can store $destination in your database or perform other actions.
                    $profile_picture = $destination;
                } else {
                    // File upload failed
                    array_push($errors, "Failed to upload the profile picture.");
                }
            }
        }

        if (count($errors) == 0) {
            $query = "INSERT INTO users (username, email, role, password, profile_picture) VALUES(:username, :email, :role, :password, :profile_picture)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':profile_picture', $profile_picture);
            $stmt->execute();

            $_SESSION['success'] = "New user successfully created!!";
            $success = "You have registered as $username. Now you can <a href='login.php'>Login</a>";
            // header('Location: ../index.php');
        }
    }
}

function getUserById($id)
{
    global $db;
    $query = "SELECT * FROM users WHERE id = :id";
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
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

if (isset($_GET['logout'])) {
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
                    header('Location: ../home.php');
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
    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}