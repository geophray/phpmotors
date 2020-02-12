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

        </nav>
        <main>
            <h1>This is my .PHP form processing page.</h1>
            <div class="delo-upgrades">
                <section>
                    <h2>GET</h2>
                    <div class="blue-text">
                        <?php
                            if(isset($_GET['clientEmail'])) {
                                echo 'Username: ' . htmlspecialchars($_GET["clientEmail"]) . '<br>';
                                echo 'Password: ' . htmlspecialchars($_GET["clientPassword"]);
                            }
                        ?>
                    </div>
                    <div class="array">
                        <h3>$_GET Value</h3>
                        <?php
                                print_r($_GET);
                        ?>
                    </div>
                </section>
                <section>
                    <h2>POST</h2>
                    <div class="blue-text">
                        <?php
                            if(isset($_POST['clientEmail'])) {
                                echo 'Username: ' . htmlspecialchars($_POST["clientEmail"]) . '<br>';
                                echo 'Password ' . htmlspecialchars($_POST["clientPassword"]);
                            }
                        ?>
                    </div>
                    <div class="array">
                        <h3>$_POST Value</h3>
                        <?php
                                print_r($_POST);
                        ?>
                    </div>
                </section>
            </div>
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