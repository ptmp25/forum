<?php
require 'email_functions.php';

$user_id = $_SESSION['user']['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create email</title>
</head>

<body>
    <main>
        <div class="page-name">
            <h1>
                Send email
            </h1>
        </div>
        <div class="content-box container">
            <form action="" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <div class="form-group">
                    <label for="email_subject">Subject</label>
                    <input type="text" class="form-control" id="message_subject" name="message_subject"
                        placeholder="Enter email subject" required>
                </div>
                <div class="form-group">
                    <label for="email_body">Message</label>
                    <textarea class="form-control" id="email_body" name="message" rows="5"
                        placeholder="Enter email message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="send_email_btn">Send</button>
            </form>
        </div>
    </main>
</body>

</html>