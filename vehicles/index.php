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
$classificationList = '<select name="" id ="">';
$classificationList .= '<option value="">--Please choose an option--</option>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='" . $classification['classificationID'] . "'>" . $classification['classificationName'] . "</option>";
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
        $classificationID = filter_input(INPUT_POST, 'classificationID');
        $invMake = filter_input(INPUT_POST, 'invMake');
        $invModel = filter_input(INPUT_POST, 'invModel');
        $invDescription = filter_input(INPUT_POST, 'invDescription');
        $invImage = filter_input(INPUT_POST, 'invImage');
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
        $invPrice = filter_input(INPUT_POST, 'invPrice');
        $invStock = filter_input(INPUT_POST, 'invStock');
        $invColor = filter_input(INPUT_POST, 'invColor');

        // Check for missing input
        if(empty($classificationID) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = "<p>Please provide information for all empty form fields.</p>";
            // Return visitor to add-vehicle form to complete all fields.
            include '../view/add-vehicle.php';
            exit;
        }

        // Insert the data to the database

        // Check and report the result

        break;
    case 'add-new-classification': // Add new classification to the database
        // Filter and store the data
        $classificationName = filter_input(INPUT_POST, 'new');

        // Check for missing input
        if(empty($classificationName)) {
            $message = "<p>Please provide information for all empty form fields.</p>";
            // Return visitor to form to add a classification.
            include '../view/add-classification.php';
            exit;
        }

        // Insert the data to the database

        // Check and report the result
            // should return visitor to vehicle management view

        break;
    default:
        include '../view/home.php';
    }
?>