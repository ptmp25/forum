<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">From</th>
                <th scope="col">Subject</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require '../emails/email_functions.php';

            try {
                // Query the database for messages
                $stmt = $db->prepare("SELECT messages.*, users.username AS replied_by
                                    FROM messages
                                    JOIN users ON messages.user_id = users.user_id;");
                $stmt->execute();

                // Loop through the results and display them in a table
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["replied_by"] . "</td>";
                    echo "<td>" . $row["message_subject"] . "</td>";
                    echo "<td>" . $row["message"] . "</td>";
                    echo "<td>" . $row["timestamp"] . "</td>";
                    echo "<td>";
                    echo "<form method=\"post\" action=\"delete_message.php\">";
                    echo "<input type=\"hidden\" name=\"message_id\" value=\"" . $row["message_id"] . "\">";
                    echo "<button type=\"submit\">Delete</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            // Close the database connection
            $conn = null;
            ?>
        </tbody>
    </table>
</body>

</html>