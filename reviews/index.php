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
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH | FILTER_FLAG_STRIP_BACKTICK | FILTER_FLAG_ENCODE_AMP);

        $clientId = validateInt($clientId);
        $invId = validateInt($invId);

        if(empty($clientId) || empty($invId) || empty($reviewText)) {
            $_SESSION['reviewMessage'] = "<p class='error-message'>There was an error submitting your review. Please try again.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicle&invId=$invId");
            exit;
        }

        $reviewDate = time();

        $addReview = insertReview($reviewText, $reviewDate, $invId, $clientId);

        if ($addReview === 1) {
            $_SESSION['reviewMessage'] = "<p class='success-message'>Thank you for submitting a review! It is displayed below.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicle&invId=$invId");
            exit;
        }
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