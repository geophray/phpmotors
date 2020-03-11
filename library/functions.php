<?php

// Build a navigation bar using the $classifications array
function buildNavMenu($classifications) {
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/index.php?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

// ****************************************************
// Functions for validating user data
// ****************************************************

// Function for server side validation of email addresses submitted via forms.
function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

// Function for servier side valitation of passwords submitted via forms.
 function checkPassword($clientPassword){
    // Check the password for a minimum of 8 characters,
    // at least one 1 capital letter, at least 1 number and
    // at least 1 special character
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

// ****************************************************
// Functions for validating vehicle/classification data
// ****************************************************

// Function for server side validation of classificationName.
function checkClassificationName($classificationName) {
    $pattern = '/^[a-zA-Z\s]+$/';
    return preg_match($pattern, $classificationName);
}

// Function for server side validation of classificationId.
function validateClassificationId($classificationId) {
    $valClassificationId = filter_var($classificationId, FILTER_VALIDATE_INT);
    return $valClassificationId;
}

// Function for validating strings with the following regex pattern: /^[a-zA-Z\s]*$/
// Returns input string if pattern matches, 0 if not.
function validateStringRegex($stringInput) {
    $pattern = '/^[a-zA-Z\s]+$/';
    $result = preg_match($pattern, $stringInput);
    if($result) {
        return $stringInput;
    } else {
        return null;
    }
}

// Function for validating invModel with the following regex pattern: /^[\w\s]*$/
// Returns input string if pattern matches, 0 if not.
function validateInvModel($invModel) {
    $pattern = '/^[\w\s-]+$/';
    $result = preg_match($pattern, $invModel);
    if($result) {
        return $invModel;
    } else {
        return null;
    }
}

// Function for validating image url path against regex pattern: /^(https:\/\/|http:\/\/|\/){1}.*(\.[A-Za-z]{3,4})$/i
function validateFilePath($pathInput) {
    $pattern = '/^(https:\/\/|http:\/\/|\/){1}.+(\.[A-Za-z]{3,4})$/i';
    $result = preg_match($pattern, $pathInput);
    if($result === 1) {
        return $pathInput;
    } else {
        return null;
    }
}

// Function for validating inventory price against regex pattern: /^([0-9]*)\.?[0-9]{2,2}?$/
    function validateInvPrice($invPrice) {
        $pattern = '/^([0-9]+)\.?[0-9]{2,2}?$/';
        $result = preg_match($pattern, $invPrice);
        if($result) {
            return $invPrice;
        } else {
            return null;
        }
    }

// Function for server side validation of classificationId.
function validateInvStock($invStock) {
    $valInvStock = filter_var($invStock, FILTER_VALIDATE_INT);
    return $valInvStock;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
     $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
}

// Function to build a display of vehicles in a classification within and unordered list
function buildVehiclesDisplay($vehicles){
    $dv = '<ul id="inv-display">';
    foreach ($vehicles as $vehicle) {
     $dv .= '<li>';
     $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
     $dv .= '<hr>';
     $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
     $dv .= "<span>$vehicle[invPrice]</span>";
     $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}