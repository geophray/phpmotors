<?php
//This is the vehicles controller

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors main model 
require_once '../model/main-model.php';
// Get the PHP Motors main model 
require_once '../model/vehicles-model.php';

// Get the array of classifications
$classifications = getClassifications();
// var_dump($classifications);
//     exit;

// Build a navigation bar using the $classifications array
$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
 $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

// Build the dynamic drop-down select list of classifications from the database.
$classificationList = '<select name="classificationId" id="classificationId">';
$classificationList .= '<option value="" disabled selected>--Please choose an option--</option>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='" . $classification['classificationId'] . "'>" . $classification['classificationName'] . "</option>";
}
$classificationList .= '</select>';

// Control structure for delivering views
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action');
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
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_INT);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);

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
        
        // Check for missing input
        if(empty($classificationName)) {
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
    default:
        include '../view/vehicle-man.php';
    }
?>