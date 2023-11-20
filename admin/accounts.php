<?php
require dirname(__DIR__) . "/modules/module_functions.php";

if (!isAdmin()) {
    $_SESSION["msg"] = "You must log in first";
    $errors = "You must log in first";
    header("location: ../auth/login.php");
}

// Set the number of results per page
$results_per_page = 5;

// Get the total number of users
$query = "SELECT COUNT(*) as total FROM users";
$stmt = $db->prepare($query);
$stmt->execute();
$total_results = $stmt->fetch(PDO::FETCH_ASSOC)["total"];

// Calculate the total number of pages
$total_pages = ceil($total_results / $results_per_page);

// Get the current page number
$current_page = isset($_GET["page"]) ? $_GET["page"] : 1;

// Calculate the offset
$offset = ($current_page - 1) * $results_per_page;

// Get the users for the current page
$query = "SELECT * FROM users LIMIT :offset, :results_per_page";
$stmt = $db->prepare($query);
$stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt->bindParam(":results_per_page", $results_per_page, PDO::PARAM_INT);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
</head>

<body>
    <main>
        <div class="text-center">
            <button class="btn btn-primary">
                <a href="../admin/create_user.php">Create User</a>
            </button>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>
                            <a href="../user/profile.php?user_id=<?php echo $user["user_id"]; ?>">
                                <?= $user["username"] ?>
                            </a>
                        </td>
                        <td>
                            <?= $user["email"] ?>
                        </td>
                        <td>
                            <?= $user["role"] ?>
                        </td>
                        <td>
                            <form method="post" action="../auth/delete_user.php?user_id=<?php echo $user["user_id"]; ?>">
                                <input type="hidden" name="user_id" value=<?php echo $user["user_id"]; ?>>
                                <button type="submit" class="btn btn-danger" name="delete_user_btn">Delete</button>
                                <a class="btn btn-primary"
                                    href="../user/edit_profile.php?user_id=<?php echo $user['user_id']; ?>">Edit
                                    profile</a>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination justify-content-center">
            <ul class="pagination">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php if ($i == $current_page): ?>
                        <li class="page-item active">
                            <span class="page-link">
                                <?php echo $i; ?>
                                <span class="sr-only">(current)</span>
                            </span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </main>

</html>