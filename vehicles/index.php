<?php
//This is the vehicles controller

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors main model 
require_once '../model/main-model.php';
// Get the PHP Motors accounts model 
require_once '../model/accounts-model.php';
// Get the PHP Motors main model 
require_once '../model/vehicles-model.php';
// Get the PHP Motors reviews model
require_once '../model/reviews-model.php';
// Get the custom functions library
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

// Build the navigation menu
$navList = buildNavMenu($classifications);

// Control structure for delivering views
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
}

switch ($action){
    case 'new-vehicle':  // Display add-vehicle view
        include '../view/add-vehicle.php';
        break;
    case 'new-classification': // Display add-classification view
        include '../view/add-classification.php';
        break;
    case 'add-new-vehicle':  // Add new vehicle to the database
        // Filter and store the data
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT , FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);

        // Validate the stored data
        $classificationId = validateClassificationId($classificationId);
        $invMake = validateStringRegex($invMake);
        $invModel = validateInvModel($invModel);
        $invImage = validateFilePath($invImage);
        $invThumbnail = validateFilePath($invThumbnail);
        $invPrice = validateInvPrice($invPrice);
        $invStock = validateInt($invStock);
        $invColor = validateStringRegex($invColor);

        // Check for missing input
        if(empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = "<p class='error-message'>Please provide information for all empty form fields.</p>";
            // Return visitor to add-vehicle form to complete all fields.
            include '../view/add-vehicle.php';
            exit;
        }

        // Insert the data to the database
        $regOutcome = regVehicle( $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId );

        // Check and report the result
        if ($regOutcome === 1) {
            $message = "<p class='success-message'>The $invMake $invModel was added successfully!</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p class='error-message'>Registration of $invMake $invModel failed.  Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }

        break;
    case 'add-new-classification': // Add new classification to the database
        // Filter and store the data
        $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        
        // Check classification Name
        $checkClassificationName = checkClassificationName($classificationName);
        
        // Check for missing input
        if(empty($checkClassificationName)) {
            $message = "<p class='error-message'>Please provide information for all empty form fields.</p>";
            // Return visitor to form to add a classification.
            include '../view/add-classification.php';
            exit;
        }

        // Insert the data to the database
        $regOutcome = regClassification($classificationName);

        // Check and report the result
            // should return visitor to vehicle management view
        if ($regOutcome === 1) {
            header('Location: ../vehicles/index.php');
            exit;
        } else {
            $message = "<p class='error-message'>Registration of classification $classificationName failed. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }

        break;
    case 'getInventoryItems': // Get vehicles by classificationID - used for starting update & delete process
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;
    case 'mod': // Load the vehicle update view
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);  
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;
    case 'update-vehicle': // Process the update vehicle form from vehicle-update.php view
        // Filter and store the data
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT , FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);

        // Validate the stored data
        $classificationId = validateClassificationId($classificationId);
        $invMake = validateStringRegex($invMake);
        $invModel = validateInvModel($invModel);
        $invImage = validateFilePath($invImage);
        $invThumbnail = validateFilePath($invThumbnail);
        $invPrice = validateInvPrice($invPrice);
        $invStock = validateInt($invStock);
        $invColor = validateStringRegex($invColor);

        // Check for missing input
        if(empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = "<p class='error-message'>Please provide information for all empty form fields.</p>";
            // Return visitor to add-vehicle form to complete all fields.
            include '../view/add-vehicle.php';
            exit;
        }

        // Insert the data to the database
        $updateResult = updateVehicle( $invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId );

        // Check and report the result
        if ($updateResult === 1) {
            $message = "<p class='success-message'>The $invMake $invModel was updated successfully!</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='error-message'>Update of $invMake $invModel failed.  Please try again.</p>";
            include '../view/vehicle-update.php';
            exit;
        }

        break; 
    case 'del': // Load the vehicle deletion view.
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);  
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;
    case 'delete-vehicle': // Process deletion of vehicle.
        // Filter and store the data
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);

        // Insert the data to the database
        $deleteResult = deleteVehicle( $invId );

        // Check and report the result
        if ($deleteResult === 1) {
            $message = "<p class='success-message'>$invMake $invModel was deleted successfully!</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='error-message'>$invMake $invModel could not be deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
    case 'classification': // Loads all vehicles of a selected classification
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
            $message = "<p class='error-message'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;
    case 'vehicle': // Loads details of an individual vehicle in the vehicles view
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $vehicle = getInvItemInfo($invId);
        if(!$vehicle) {
            $message = "<p class='error-message'>Sorry mate... vehicle $invId could not be found.</p>";
            include '../view/vehicle-detail.php';
            exit;
        } else {
            $vehicleDisplay = buildVehicleDisplay($vehicle);
            include '../view/vehicle-detail.php';
        }
        break;
    default: // Load the vehicle management view
        $classificationList = buildClassificationList($classifications);

        include '../view/vehicle-man.php';
    }
?>