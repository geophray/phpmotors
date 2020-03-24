<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Review Update | PHP Motors</title>
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
            <h1><?php echo $review['invMake'] . ' ' . $review['invModel'] ?> Review</h1>
            <p>Reviewed on <?php echo formatReviewDate($review['reviewDate']) ?></p>
            <?php 
                if (isset($_SESSION['reviewMessage'])) {
                    echo $_SESSION['reviewMessage'];
                }
                unset($_SESSION['reviewMessage']);
            ?>
            <form id="review-update" class="user-management" action="/phpmotors/reviews/index.php" method="post">
                    <div>
                        <label for="reviewText">Review Text</label>
                        <textarea rows=5 id="reviewText" name="reviewText" required><?php echo $review['reviewText'] ?></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submit" id="update-review" value="Update">
                    </div>
                    <!-- Add the name - value pairs -->
                    <input type="hidden" name="action" value="update-review">
                    <input type="hidden" name="reviewId" value="<?php echo $reviewId ?>">
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