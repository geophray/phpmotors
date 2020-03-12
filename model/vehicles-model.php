<?php
//PHP Motors Vehicles Model


//Function to handle insertion of new vehicle classifications.
function regClassification( $classificationName ) {
     // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO carclassification (classificationName)
        VALUES (:classificationName)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next line replaces the placeholder in the SQL
    // statement with the actual value in the variable
    // and tells the database the type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

//Function to handle insertion of new vehicles.
function regVehicle( $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId ) {
    // Create a connection object using the phpmotors connection function
   $db = phpmotorsConnect();
   // The SQL statement
   $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
       VALUES (:invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';
   // Create the prepared statement using the phpmotors connection
   $stmt = $db->prepare($sql);
   // The next line replaces the placeholder in the SQL
   // statement with the actual value in the variable
   // and tells the database the type of data it is
   $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
   $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
   $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
   $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
   $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
   $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
   $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
   $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
   $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
   // Insert the data
   $stmt->execute();
   // Ask how many rows changed as a result of our insert
   $rowsChanged = $stmt->rowCount();
   // Close the database interaction
   $stmt->closeCursor();
   // Return the indication of success (rows changed)
   return $rowsChanged;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
}

// Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

//Function to handle updating of vehicles.
function updateVehicle( $invId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId ) {
    // Create a connection object using the phpmotors connection function
   $db = phpmotorsConnect();
   // The SQL statement
   $sql = 'UPDATE inventory 
            SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId
            WHERE invId = :invId';
   // Create the prepared statement using the phpmotors connection
   $stmt = $db->prepare($sql);
   // The next line replaces the placeholder in the SQL
   // statement with the actual value in the variable
   // and tells the database the type of data it is
   $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
   $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
   $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
   $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
   $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
   $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
   $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
   $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
   $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
   $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
   // Update the data
   $stmt->execute();
   // Ask how many rows changed as a result of our update
   $rowsChanged = $stmt->rowCount();
   // Close the database interaction
   $stmt->closeCursor();
   // Return the indication of success (rows changed)
   return $rowsChanged;
}

//Function to handle deletion of vehicles.
function deleteVehicle( $invId ) {
    // Create a connection object using the phpmotors connection function
   $db = phpmotorsConnect();
   // The SQL statement
   $sql = 'DELETE FROM inventory WHERE invId = :invId';
   // Create the prepared statement using the phpmotors connection
   $stmt = $db->prepare($sql);
   // The next line replaces the placeholder in the SQL
   // statement with the actual value in the variable
   // and tells the database the type of data it is
   $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
   // Delete the data
   $stmt->execute();
   // Ask how many rows changed as a result of our deletion
   $rowsChanged = $stmt->rowCount();
   // Close the database interaction
   $stmt->closeCursor();
   // Return the indication of success (rows changed)
   return $rowsChanged;
}

// Function to get a list of vehicles by classification
function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName = :classificationName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
}

// Function to get a vehicle by invId
function getVehicleById($invId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE classificationId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicle = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicle;
}