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

// Function for server side validation of integers.
function validateInt($int) {
    $valInt = filter_var($int, FILTER_VALIDATE_INT);
    return $valInt;
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
     $dv .= '<li class="grow">';
     $dv .= "<a href='/phpmotors/vehicles/?action=vehicle&invId=$vehicle[invId]'>";
     $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
     $dv .= '<div class="vehicle-details">';
     $dv .= "<h2>$vehicle[invMake] $vehicle[invModel]</h2>";
     $dv .= '<span class="vehicle-price">' . formatCurrencyUSD($vehicle['invPrice']) . '</span>';
     $dv .= '</div>';
     $dv .= '</a>';
     $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

// Function to build a display for a single vehicle to be displayed on the vehicle-details view.
function buildVehicleDisplay($vehicle){
    $dv = "<h1>$vehicle[invMake] $vehicle[invModel]</h1>";
    $dv .= "<img class='vehicle-full-size' src='$vehicle[invImage]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
    $dv .= '<h2 class="vehicle-price">Price: ' . formatCurrencyUSD($vehicle['invPrice']) . '</h2>';
    $dv .= "<section id='vehicle-details'>";
    $dv .= "<h2>$vehicle[invMake] $vehicle[invModel] Details</h2>";
    $dv .= "<h3>Description</h3><p id='vehicle-description'>$vehicle[invDescription]</p>";
    $dv .= "<h3>Colors Available</h3><p id='vehicle-color'>$vehicle[invColor]</p>";
    $dv .= "<h3>QTY in Stock</h3><p id='vehicle-qty-in-stock'>$vehicle[invStock]</p>";
    $dv .= "</section>";
    return $dv;
}

// Funciton for formatting prices to US currency
function formatCurrencyUSD($price) {
    $formattedCurrency = number_format($price, 0, '.', ',');
    $formattedCurrency = '$' . $formattedCurrency;
    return $formattedCurrency;
}

// Function for generating a users screen name when leaving reviews
function generateScreenName($clientFirstname, $clientLastname) {
    $firstInitial = strtoupper(substr($clientFirstname, 0, 1));
    $lastName = ucfirst($clientLastname);
    return $firstInitial . $lastName;
}

// Function for generating existing reviews on the vehicle-detail view
function buildInventoryReviewsList($invReviews) {
    $reviews = "<div class='all-reviews'>";
    foreach ($invReviews as $singleReview) {
        $reviews .= '<div class="single-review rounded-corners">';
        $screenName = generateScreenName($singleReview['clientFirstname'], $singleReview['clientLastname']);
        $reviewDate = formatReviewDate($singleReview['reviewDate']); 
        $reviews .= "<h3>$screenName <span class='review-meta'>wrote on $reviewDate:</span></h3>";
        $reviews .= "<p>$singleReview[reviewText]</p>";
        if(isset($_SESSION['clientData']) && $_SESSION['clientData']['clientId'] === $singleReview['clientId']) {
            $reviews .= "<span class='review-buttons'>";
            $reviews .= "<a class='grow modify' href='/phpmotors/reviews?action=edit-review&reviewId=$singleReview[reviewId]' title='Click to edit'>Edit</a>";
            $reviews .= "<a class='grow delete' href='/phpmotors/reviews?action=delete-review&reviewId=$singleReview[reviewId]' title='Click to delete'>Delete</a>";
            $reviews .= "</span>";
        }
        $reviews .= '</div>';
       }
    $reviews .= "</div>";
    return $reviews;
}

// Function for generating existing reviews on the user admin view
function buildClientReviewsList($clientReviews) {
    $reviews = "<table>";
    foreach ($clientReviews as $singleReview) {
        $reviews .= '<tr class="single-review">';
        $reviewDate =  formatReviewDate($singleReview['reviewDate']);         
        $reviews .= "<td><a href='/phpmotors/vehicles/?action=vehicle&invId=$singleReview[invId]'><span class='label'>$singleReview[invMake] $singleReview[invModel]</span></a> (Reviewed on $reviewDate)</td>"; 
        $reviews .= "<td><a class='grow modify' href='/phpmotors/reviews?action=edit-review&reviewId=$singleReview[reviewId]' title='Click to edit'>Edit</a></td>"; 
        $reviews .= "<td><a class='grow delete' href='/phpmotors/reviews?action=delete-review&reviewId=$singleReview[reviewId]' title='Click to delete'>Delete</a></td>";
        $reviews .= "</tr>";
       }
    $reviews .= "</table>";
    return $reviews;
}

// Function to format dates for reviews
function formatReviewDate($dateString) {
    return date ("d F, Y", strtotime($dateString));
}