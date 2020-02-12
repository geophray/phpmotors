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
$classificationList = "";