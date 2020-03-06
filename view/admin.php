<?php 
    if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
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
    <title>Admin View | PHP Motors</title>
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
            <h1>
                <?php 
                    echo $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'];
                ?>
            </h1>
            <?php
                if (isset($_SESSION['message'])) {
                    $message = $_SESSION['message'];
                }
                if (isset($message)) {
                    echo $message;
                }
                unset($_SESSION['message']);
            ?>
            <p>You are logged in.</p>
            <!-- <ul>
                <li><span class="label">First Name:</span> <?php echo $_SESSION['clientData']['clientFirstname'] ?></li>
                <li><span class="label">Last Name:</span> <?php echo $_SESSION['clientData']['clientLastname'] ?></li>
                <li><span class="label">Email:</span> <?php echo $_SESSION['clientData']['clientEmail'] ?></li>
                <li><span class="label">Client Level:</span> <?php echo $_SESSION['clientData']['clientLevel'] ?></li>
            </ul> -->
            <p><a href='/phpmotors/accounts/index.php?action=update-account-info'>Update Account Information</a></p>
            <?php
                if($_SESSION['clientData']['clientLevel'] > 1) {
                    echo "
                        <h2>Manage Inventory</h2>
                        <p>Use the following link to manage current inventory and vehicle classifications.</p>
                        <p>
                            <a href='/phpmotors/vehicles/'>Vehicle Management</a>
                        </p>";
                }
            ?>
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