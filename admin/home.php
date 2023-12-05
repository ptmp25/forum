<?php
require dirname(__DIR__) . '/modules/module_functions.php';

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    $errors = "You must log in first";
    header('location: ../auth/login.php');
}

// Set the number of results per page
$results_per_page = 5;

// Get the total number of messages
$total_messages = $db->query("SELECT COUNT(*) FROM messages")->fetchColumn();

// Calculate the total number of pages
$total_pages = ceil($total_messages / $results_per_page);

// Get the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = (int) $_GET['page'];
} else {
    $current_page = 1;
}

// Make sure the current page number is within the valid range
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $total_pages) {
    $current_page = $total_pages;
}

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $results_per_page;

// Prepare and execute the SQL query to retrieve data with pagination
$stmt = $db->prepare("SELECT messages.*, users.username AS send_by
                  FROM messages 
                  JOIN users ON messages.user_id = users.user_id
                  ORDER BY messages.timestamp DESC
                  LIMIT :offset, :results_per_page");
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
$stmt->execute();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
</head>

<body>
    <main>
        <div class="page-name">
            <h1>Admin - Home Page</h1>
        </div>
        <div class="text-center">
            <button class="btn btn-primary">
                <a href="../admin/accounts.php">Accounts Control</a>
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email Subject</th>
                    <th>Email Content</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($email = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td>
                            <a href="../user/profile.php?user_id=<?php echo $email['user_id'] ?>">
                                <?php echo $email['send_by']; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $email['message_subject']; ?>
                        </td>
                        <td>
                            <?php
                            $message = $email['message'];
                            if (strlen($message) > 100) {
                                $short_message = substr($message, 0, 100) . '...';
                                echo $short_message . '<strong><a href="../emails/read_email.php?message_id=' . $email['message_id'] . '">See more</a></strong>';
                            } else {
                                echo $message;
                            }
                            ?>
                        </td>
                        <td>
                            <?php echo $email['timestamp']; ?>
                        </td>
                        <td>
                            <form method="post"
                                action="../emails/delete_message.php?message_id=<?php echo $email['message_id']; ?>"
                                onsubmit="return confirm('Are you sure you want to delete this mail?');">
                                <input type="hidden" name="message_id" value=<?php echo $email['message_id']; ?>>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <ul class="pagination justify-content-center">
            <?php if ($total_pages > 1) { ?>
                <?php if ($current_page > 1) { ?>
                    <li><a href="?page=<?php echo $current_page - 1; ?>" class="page-link">Previous</a></li>
                <?php } ?>
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <?php if ($i == $current_page) { ?>
                        <li class="page-item active"><a href="#">
                                <span class="page-link">
                                    <?php echo $i; ?>
                                    <span class="sr-only">(current)</span>
                                </span>
                            </a></li>
                    <?php } else { ?>
                        <li><a class="page-link" href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a></li>
                    <?php } ?>
                <?php } ?>
                <?php if ($current_page < $total_pages) { ?>
                    <li><a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </main>
</body>

</html>