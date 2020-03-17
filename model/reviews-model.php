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
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews WHERE invId = :invId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviews; 
}

// Get reviews written by a specific client
function getReviewsByClientId($clientId) {
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews WHERE clientId = :clientId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviews; 
}

// Get a specific review
function getReviewById($reviewId) {
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews WHERE reviewId = :reviewId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $review = $stmt->fetch(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $review; 
}

// Update a specific review
function updateReview($reviewId, $reviewText) {
   $db = phpmotorsConnect();
   $sql = 'UPDATE reviews 
            SET reviewText = :reviewText
            WHERE reviewId = :reviewId';
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
   $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
   $stmt->execute();
   $rowsChanged = $stmt->rowCount();
   $stmt->closeCursor();
   return $rowsChanged;
}


// Delete a specific review
function deleteReview($reviewId) {

}