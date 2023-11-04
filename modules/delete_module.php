<?php
require '../modules/module_functions.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header("Location: ../auth/login.php");
}
if (isset($_POST["delete_module_btn"])) {
    $module_id = $_POST["module_id"];

    deleteModule($module_id);
}
?>