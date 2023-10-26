<?php
session_start();

try {
    // Connect to the database using PDO
    $db = new PDO('mysql:host=localhost;dbname=forum_db', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$module_name ="";
$module_id ="";

$query = "SELECT module_name FROM module WHERE module_id = "

?>