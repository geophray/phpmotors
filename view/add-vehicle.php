<?php
$classificationList = '<select name="classificationId" id="classificationId" required>';
$classificationList .= '<option value="" disabled selected>--Please choose an option--</option>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if(isset($classificationId)) {
        if($classificationId == $classification['classificationId']) {
            $classificationList .= " selected ";
        }
    }
    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>';
?>
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
                    <input type="text" <?php if(isset($invMake)){echo "value='$invMake'";}  ?> id="invMake" name="invMake" required pattern="^[a-zA-Z\s]*$">
                </div>
                <div>
                    <label for="invModel">Model</label>
                    <input type="text" <?php if(isset($invModel)){echo "value='$invModel'";}  ?> id="invModel" name="invModel" required pattern="^[\w\s-]*$">
                </div>
                <div>
                    <label for="invDescription">Description</label>
                    <textarea rows=5 id="invDescription" name="invDescription" required><?php if(isset($invDescription)) { echo $invDescription;};?></textarea>
                </div>
                <div>
                    <label for="invImage">Image Path</label>
                    <input type="text" <?php if(isset($invImage)){echo "value='$invImage'";} else { echo "value='/phpmotors/images/no-image.png'";};?> id="invImage" name="invImage" required pattern="^(https:\/\/|http:\/\/|\/){1}.*(\.[A-Za-z]{3,4})$">
                </div>
                <div>
                    <label for="invThumbnail">Thumbnail Path</label>
                    <input type="text" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} else { echo "value='/phpmotors/images/no-image.png'";};?> id="invThumbnail" name="invThumbnail" required pattern="^(https:\/\/|http:\/\/|\/){1}.*(\.[A-Za-z]{3,4})$">
                </div>
                <div>
                    <label for="invPrice">Price</label>
                    <input type="text" <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?> id="invPrice" name="invPrice" required pattern="^([0-9]*)\.?[0-9]{2,2}?$">
                </div>
                <div>
                    <label for="invStock"># In Stock</label>
                    <input type="number" <?php if(isset($invStock)){echo "value='$invStock'";}  ?> id="invStock" name="invStock" required>
                </div>
                <div>
                    <label for="invColor">Color</label>
                    <input type="text" <?php if(isset($invColor)){echo "value='$invColor'";}  ?> id="invColor" name="invColor" required pattern="^[a-zA-Z\s]*$">
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