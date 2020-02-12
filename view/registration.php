<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Motors Template</title>
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
            <h1>Create an account with PHP Motors!</h1>

            <?php
                if (isset($message)) {
                    echo $message;
                }
            ?>

            <form id="signin" class="user-management" method="post" action="/phpmotors/accounts/index.php">
                <div>
                    <label for="clientFirstname">First Name</label>
                    <input type="text" id="clientFirstname" name="clientFirstname">
                </div>
                <div>
                    <label for="clientLastname">Last Name</label>
                    <input type="text" id="clientLastname" name="clientLastname" required aria-required="true">
                </div>
                <div>
                    <label for="clientEmail">Email</label>
                    <input type="email" id="clientEmail" name="clientEmail" required aria-required="true">
                </div>
                <div>
                    <label for="clientPassword">Password</label>
                    <input type="password" id="clientPassword" name="clientPassword" required aria-required="true">
                </div>
                <div>
                    <input type="submit" name="submit" id="sign-in" value="Create My Account">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="register">
                </div>
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