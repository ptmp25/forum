<?php
require dirname(__DIR__) . "/replies/reply_functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
$question_id = $_POST["question_id"];
$reply_content = trimm($_POST["reply_content"]);
$user_id = $_SESSION["user"]['user_id'];
}
if ($reply_content)
    addReply($db, $question_id, $user_id, $reply_content);