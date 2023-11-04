<?php
// Include your database connection code here
require dirname(__DIR__) . '/modules/module_functions.php';

$module_id = $_GET['module_id'];
?>
<!DOCTYPE html>
<html lang="en">

<body>
    <div class="page-name">
        <h1>
            Delete successful!!!
        </h1>
        <p>
            <em>
                <a href="../modules/read_module.php?module_id=<?php echo $module_id; ?>">Back to module</a>
            </em>
        </p>
    </div>
</body>

</html>