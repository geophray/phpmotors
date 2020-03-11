<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Motors | Home</title>
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
            <h1>Welcome to PHP Motors!</h1>
            <section id="own_a_delo_today">
                <div id="delo_description" class="blue-text absolute-margin">
                    <h2 class="no-margin">DMC Delorean</h2>
                    <p class="no-margin">3 Cup holders</p>
                    <p class="no-margin">Superman doors</p>
                    <p class="no-margin">Fuzzy dice!</p>
                </div>
                <img src="/phpmotors/images/vehicles/delorean.jpg" alt="Rendering of the actual Delorean.">
                <img id="own_today_button" src="/phpmotors/images/site/own_today.png" alt="Own today button.">
            </section>
            <div id="reviews_upgrades">
                <section id="delo_reviews">
                    <h2>DMC Delorian Reviews</h2>
                    <ul>
                        <li>"So fast its almost like traveling in time." (4/5)</li>
                        <li>"Coolest ride on the road." (4/5)</li>
                        <li>"I'm feeling Marty McFly!" (5/5)</li>
                        <li>"The most futuristic ride of our day." (4.5/5)</li>
                        <li>"80's livin and I love it!" (5/5)</li>
                    </ul>
                </section>
                <section id="delo_upgrades">
                    <h2>Delorean Upgrades</h2>
                    <div class="delo-upgrades">
                        <a href="#">
                            <article class="delo-upgrade"><img src="/phpmotors/images/upgrades/flux-cap.png"
                                    alt="OEM flux capacitor.">
                                <h3>Flux Capacitor</h3>
                            </article>
                        </a>
                        <a href="#">
                            <article class="delo-upgrade"><img src="/phpmotors/images/upgrades/flame.jpg"
                                    alt="Picture of flame decals.">
                                <h3>Flame Decals</h3>
                            </article>
                        </a>
                        <a href="#">
                            <article class="delo-upgrade"><img src="/phpmotors/images/upgrades/bumper_sticker.jpg"
                                    alt="Hello World bumper stickers.">
                                <h3>Bumper Stickers</h3>
                            </article>
                        </a>
                        <a href="#">
                            <article class="delo-upgrade"><img src="/phpmotors/images/upgrades/hub-cap.jpg"
                                    alt="Very flashy chrome vanadium hub cap.">
                                <h3>Hub Caps</h3>
                            </article>
                        </a>
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