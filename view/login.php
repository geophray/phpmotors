<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign In | PHP Motors</title>
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
            <h1>Sign In to PHP Motors!</h1>

            <?php
                if (isset($message)) {
                    echo $message;
                }
            ?>

            <form id="signin" class="user-management" action="/phpmotors/view/index.php" method="post">
                <div>
                    <label for="clientEmail">Email</label>
                    <input type="email" id="clientEmail" name="clientEmail" required aria-required="true">
                </div>
                <div>
                    <label for="clientPassword">Password</label>
                    <input type="password" id="clientPassword" name="clientPassword" required aria-required="true">
                </div>
                <div>
                    <input type="submit" name="submit" id="sign-in" value="Sign In">
                </div>
                <span>Don't have an account? <a href='/phpmotors/accounts/index.php?action=registration' title='Create a new account.'>Register Here</a>.</span>
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