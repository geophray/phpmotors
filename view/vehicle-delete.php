<?php
    // If the current user doesn't have a session set, is not logged in, or is not an admin, redirect to home view.
    if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }
    // Build the sticky classificationList select field
    $classificationList = '<select name="classificationId" id="classificationId" required>';
    $classificationList .= '<option value="" disabled selected>--Please choose an option--</option>';
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'";
        if(isset($classificationId)) {
            if($classificationId == $classification['classificationId']) {
                $classificationList .= " selected ";
            }
        } elseif(isset($invInfo['classificationId'])){
            if($classification['classificationId'] === $invInfo['classificationId']){
             $classificationList .= ' selected ';
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
    <title>
        <?php 
            if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
            } 
        ?>
     | PHP Motors</title>
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
                    if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                        echo "Delete $invInfo[invMake] $invInfo[invModel]";
                    } 
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
            <p class="error-message">Confirm Vehicle Deletion. This cannot be undone.</p>
            <form id="signin" class="user-management" action="/phpmotors/vehicles/index.php" method="post">
                <div>
                    <label for="invMake">Make</label>
                    <input type="text" <?php if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?> id="invMake" name="invMake" readonly required pattern="^[a-zA-Z\s]*$">
                </div>
                <div>
                    <label for="invModel">Model</label>
                    <input type="text" <?php if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?> id="invModel" name="invModel" readonly required pattern="^[\w\s-]*$">
                </div>
                <div>
                    <label for="invDescription">Description</label>
                    <textarea rows=5 id="invDescription" name="invDescription"
                        required readonly><?php if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; };?></textarea>
                </div>
                <div>
                    <input type="submit" name="submit" id="delete-vehicle" value="Delete Vehicle">
                </div>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="delete-vehicle">
                <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} ?>">
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