<?php
//PHP Motors Reviews Model

// Insert a review
function insertReview($reviewText, $reviewDate, $invId, $clientId) {
   $db = phpmotorsConnect();
   $sql = 'INSERT INTO reviews (reviewText, reviewDate, invId, clientId)
       VALUES (:reviewText, :reviewDate, :invId, :clientId)';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
   $stmt->bindValue(':reviewDate', $reviewDate, PDO::PARAM_INT);
   $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
   $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
   $stmt->execute();
   $rowsChanged = $stmt->rowCount();
   $stmt->closeCursor();
   return $rowsChanged;
}

// Get reviews for a specific inventory item
function getReviewsByInvId($invId) {

}

// Get reviews written by a specific client
function getReviewsByClientId($clientId) {

}

// Get a specific review
function getReviewById($reviewId) {

}

// Update a specific review
function updateReview($reviewId) {

}


// Delete a specific review
function deleteReview($reviewId) {

}