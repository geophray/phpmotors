<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $vehicle['invMake'] . ' ' . $vehicle['invModel']; ?> | PHP Motors</title>
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
        <main id="vehicle-details-wrapper">
            <?php 
                if (isset($_SESSION['message'])) {
                    $message = $_SESSION['message'];
                }
                if (isset($message)) {
                    echo $message;
                }
                unset($_SESSION['message']);
                
                if(isset($vehicleDisplay)){
                    echo $vehicleDisplay;
                } 
            ?>
            <section id="inventory_reviews">
                <h2>Customer Reviews</h2>
                <?php
                    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        $screenName = generateScreenName($_SESSION['clientData']);
                ?>
                <h3>Review the <?php echo $vehicle['invMake'] . " " . $vehicle['invModel'] ?></h3>
                <?php 
                    if (isset($_SESSION['reviewMessage'])) {
                        echo $_SESSION['reviewMessage'];
                    }
                    unset($_SESSION['reviewMessage']);
                ?>
                <form id="review" class="user-management" action="/phpmotors/reviews/index.php" method="post">
                    <div>
                        <label for="screenName">Screen Name</label>
                        <input type="text" <?php echo "value='$screenName'"  ?> id="screenName" name="screenName" readonly>
                    </div>
                    <div>
                        <label for="reviewText">Description</label>
                        <textarea rows=5 id="reviewText" name="reviewText" required></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submit" id="save-review" value="Submit Review">
                    </div>
                    <!-- Add the name - value pairs -->
                    <input type="hidden" name="action" value="add-review">
                    <input type="hidden" name="invId" value="<?php echo $invId ?>">
                    <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId'] ?>">
                </form>
                <?php
                    } else {
                        echo "<p>You must <a href='/phpmotors/accounts/?action=login'>login</a> to write a review.</p>";
                    }
                    $invReviews = getReviewsByInvId($invId);
                    if($invReviews) {
                        $reviews = buildInventoryReviewsList($invReviews);
                        echo $reviews;
                    } else {
                        echo "<p class='italicized-message'>Be the first to write a review.</p>";
                    }
                ?>
            </section>
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