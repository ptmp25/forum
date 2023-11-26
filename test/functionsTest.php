<?php 

// Include the necessary files
require_once '../auth/functions.php';

// Test case 1: Register with valid inputs
$_POST['username'] = 'john_doe';
$_POST['email'] = 'john@example.com';
$_POST['password_1'] = 'password123';
$_POST['password_2'] = 'password123';
$_POST['about'] = 'About John Doe';
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_OK,
    'size' => 1000000
];
$_POST['role'] = 'user';

register();

// Assert that the user is successfully registered
$user = getUserByUsername('john_doe');
assert($user !== null, 'User is not registered successfully');

// Test case 2: Register with missing username
$_POST['username'] = '';
$_POST['email'] = 'john@example.com';
$_POST['password_1'] = 'password123';
$_POST['password_2'] = 'password123';
$_POST['about'] = 'About John Doe';
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_OK,
    'size' => 1000000
];
$_POST['role'] = 'user';

register();

// Assert that the error message "Username is required" is displayed
assert(getErrorMessage() === 'Username is required', 'Error message is incorrect');

// Test case 3: Register with existing username
$_POST['username'] = 'john_doe';
$_POST['email'] = 'john@example.com';
$_POST['password_1'] = 'password123';
$_POST['password_2'] = 'password123';
$_POST['about'] = 'About John Doe';
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_OK,
    'size' => 1000000
];
$_POST['role'] = 'user';

register();

// Assert that the error message "Username already exists" is displayed
assert(getErrorMessage() === 'Username already exists', 'Error message is incorrect');

// Test case 4: Register with invalid password length
$_POST['username'] = 'john_doe';
$_POST['email'] = 'john@example.com';
$_POST['password_1'] = 'pass';
$_POST['password_2'] = 'pass';
$_POST['about'] = 'About John Doe';
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_OK,
    'size' => 1000000
];
$_POST['role'] = 'user';

register();

// Assert that the error message "Password must be between 6 and 25 characters long" is displayed
assert(getErrorMessage() === 'Password must be between 6 and 25 characters long', 'Error message is incorrect');

// Test case 5: Upload profile picture with valid image
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_OK,
    'size' => 1000000
];

$uploadedFilePath = uploadProfilePicture($_FILES['profile_picture']);

// Assert that the uploaded file path is not null
assert($uploadedFilePath !== null, 'Uploaded file path is null');

// Test case 6: Upload profile picture with non-image file
$_FILES['profile_picture'] = [
    'name' => 'document.pdf',
    'type' => 'application/pdf',
    'tmp_name' => '/tmp/document.pdf',
    'error' => UPLOAD_ERR_OK,
    'size' => 2000000
];

$uploadedFilePath = uploadProfilePicture($_FILES['profile_picture']);

// Assert that the error message "File is not an image." is displayed
assert(getErrorMessage() === 'File is not an image.', 'Error message is incorrect');

// Test case 7: Upload profile picture with large file size
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_OK,
    'size' => 6000000
];

$uploadedFilePath = uploadProfilePicture($_FILES['profile_picture']);

// Assert that the error message "File is too large. Maximum size allowed is 5MB." is displayed
assert(getErrorMessage() === 'File is too large. Maximum size allowed is 5MB.', 'Error message is incorrect');

// Test case 8: Upload profile picture with upload failure
$_FILES['profile_picture'] = [
    'name' => 'profile_picture.jpg',
    'type' => 'image/jpeg',
    'tmp_name' => '/tmp/profile_picture.jpg',
    'error' => UPLOAD_ERR_CANT_WRITE,
    'size' => 1000000
];

$uploadedFilePath = uploadProfilePicture($_FILES['profile_picture']);

// Assert that the error message "Failed to upload file." is displayed
assert(getErrorMessage() === 'Failed to upload file.', 'Error message is incorrect');

// Test case 9: Upload profile picture with no file
$_FILES['profile_picture'] = null;

$uploadedFilePath = uploadProfilePicture($_FILES['profile_picture']);

// Assert that the default profile picture path is returned
assert($uploadedFilePath === '/path/to/default/profile_picture.jpg', 'Default profile picture path is incorrect');

// Test case 10: Login with valid credentials
$_POST['username'] = 'john_doe';
$_POST['password'] = 'password123';

login();

// Assert that the user is successfully logged in
assert(isLoggedIn(), 'User is not logged in successfully');

// Test case 11: Login with missing username
$_POST['username'] = '';
$_POST['password'] = 'password123';

login();

// Assert that the error message "Username is required" is displayed
assert(getErrorMessage() === 'Username is required', 'Error message is incorrect');

// Test case 12: Login with missing password
$_POST['username'] = 'john_doe';
$_POST['password'] = '';

login();

// Assert that the error message "Password is required" is displayed
assert(getErrorMessage() === 'Password is required', 'Error message is incorrect');

// Test case 13: Login with wrong username/password combination
$_POST['username'] = 'john_doe';
$_POST['password'] = 'wrong_password';

login();

// Assert that the error message "Wrong username/password combination" is displayed
assert(getErrorMessage() === 'Wrong username/password combination', 'Error message is incorrect');

// Test case 14: Login with non-existing username
$_POST['username'] = 'non_existing_user';
$_POST['password'] = 'password123';

login();

// Assert that the error message "User not found" is displayed
assert(getErrorMessage() === 'User not found', 'Error message is incorrect');
