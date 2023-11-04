<?php
require __DIR__ . '../functions.php';

$user_id = $_GET['user_id'];
    
    // Prepare the SQL statement
    $stmt = $db->prepare("DELETE FROM users WHERE user_id = :user_id");
    
    // Bind the parameter to the prepared statement
    $stmt->bindParam(':user_id', $user_id);
    
    // Check if any rows were affected
    if ($stmt->execute()) {
        header("Location: ../admin/accounts.php");
    } else {
        echo "No user found with that ID.";
    }