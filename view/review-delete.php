<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Review? | PHP Motors</title>
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
            <h1>Delete <?php echo $invItem['invMake'] . ' ' . $invItem['invModel'] ?> Review?</h1>
            <p>Reviewed on <?php echo formatReviewDate($review['reviewDate']) ?></p>
            <?php 
                if (isset($_SESSION['reviewMessage'])) {
                    echo $_SESSION['reviewMessage'];
                }
                unset($_SESSION['reviewMessage']);
            ?>
            <p class="error-message">Deletes cannot be undone. Are you sure you want to delete this review?</p>
            <form id="review-update" class="user-management" action="/phpmotors/reviews/index.php" method="post">
                    <div>
                        <label for="reviewText">Review Text</label>
                        <textarea id="reviewText" name="reviewText" readonly><?php echo $review['reviewText'] ?></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submit" id="delete" value="Confirm Deletion">
                    </div>
                    <!-- Add the name - value pairs -->
                    <input type="hidden" name="action" value="review-deleted">
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