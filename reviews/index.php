<?php
//This is the reviews controller

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors main model 
require_once '../model/main-model.php';
// Get the PHP Motors accounts model 
require_once '../model/accounts-model.php';
// Get the custom functions library
require_once '../library/functions.php';
// Get the PHP Motors reviews model
require_once '../model/reviews-model.php';

// Get the array of classifications
$classifications = getClassifications();

// Build the navigation menu
$navList = buildNavMenu($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
}

switch ($action){
    case 'add-review': // Saves a new review to the database
        // include 'view/template.php';
        break;

    case 'edit-review': // Delivers view to edit a review
        // include 'view/template.php';
        break;

    case 'update-review': // Updates an existing review in the database
        // include 'view/template.php';
        break;
        
    case 'delete-review': // Handle the review deletion
        // include 'view/template.php';
        break;
        
    case 'review-deleted': // Delivers review deletion view to confirm deletion of a review
        // include 'view/template.php';
        break;

    default: // Return authenticated users to admin view, and unauthenticated users to home view.
        header('Location: /phpmotors/accounts/');
        break;
    }
?>