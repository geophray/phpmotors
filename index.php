<?php
//This is the main controller

// Create or access a Session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the custom functions library
require_once 'library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

// Build the navigation menu
$navList = buildNavMenu($classifications);

// Check to see if firstname cookie exists (to be able to display welcome message)
if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}
    
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
}

switch ($action){
    case 'template':
        include 'view/template.php';
        break;
    default:
        include 'view/home.php';
    }
?>