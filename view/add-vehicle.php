<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Vehicle | PHP Motors</title>
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
            <h1>Add New Vehicle</h1>

            <?php
                if (isset($message)) {
                    echo $message;
                }
            ?>
            <p>*Note all Fields are Required</p>
            <form id="signin" class="user-management" action="/phpmotors/vehicles/index.php" method="post">
                <div>
                    <label for="classificationId">Classification</label>
                    <?php echo $classificationList; ?>
                </div>
                <div>
                    <label for="invMake">Make</label>
                    <input type="text" id="invMake" name="invMake">
                </div>
                <div>
                    <label for="invModel">Model</label>
                    <input type="text" id="invModel" name="invModel">
                </div>
                <div>
                    <label for="invDescription">Description</label>
                    <textarea rows=5 id="invDescription" name="invDescription"></textarea>
                </div>
                <div>
                    <label for="invImage">Image Path</label>
                    <input type="text" id="invImage" name="invImage" value="/phpmotors/images/no-image.png">
                </div>
                <div>
                    <label for="invThumbnail">Thumbnail Path</label>
                    <input type="text" id="invThumbnail" name="invThumbnail" value="/phpmotors/images/no-image.png">
                </div>
                <div>
                    <label for="invPrice">Price</label>
                    <input type="number" id="invPrice" name="invPrice">
                </div>
                <div>
                    <label for="invStock"># In Stock</label>
                    <input type="number" id="invStock" name="invStock">
                </div>
                <div>
                    <label for="invColor">Color</label>
                    <input type="text" id="invColor" name="invColor">
                </div>
                <div>
                    <input type="submit" name="submit" id="add-vehicle" value="Add Vehicle">
                </div>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="add-new-vehicle">
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