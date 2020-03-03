<?php
    // If the current user doesn't have a session set, is not logged in, or is not an admin, redirect to home view.
    if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Classification | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/styles.css" media="screen">
</head>

<body>
    <div class="site-wrapper">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>
            <h1>Add New Vehicle Classification</h1>

            <?php
                if (isset($message)) {
                    echo $message;
                }
            ?>

            <form id="signin" class="user-management" action="/phpmotors/vehicles/index.php" method="post">
                <div>
                    <label for="classificationName">Classification Name</label>
                    <input type="text" id="classificationName" name="classificationName" required pattern="[\w\s]*">
                </div>
                <div>
                    <input type="submit" name="submit" id="add-classification" value="Add Classification">
                </div>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="add-new-classification">
            </form>
            
        </main>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; ?>
            <p>Last Updated: <?php 
            date_default_timezone_set('UTC');
            echo date ("d F , Y", getlastmod()); 
            ?></p>
        </footer>
    </div>
</body>

</html>