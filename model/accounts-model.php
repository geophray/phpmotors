<?php
//PHP Motors Accounts Model

//Function to handle site registrations.
function regClient( $clientFirstname, $clientLastname, $clientEmail, $clientPassword ) {
     // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
        VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}

// Function for checking for existing email address in the db.
function emailExists ( $email ) { 
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement
    $sql = 'SELECT clientEmail 
            FROM clients 
            WHERE clientEmail = :email';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Bind the email variable to the placeholder in the sql statement
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    // Run the statement
    $stmt->execute();
    $isMatch = $stmt->fetch(PDO::FETCH_NUM);
    // Close db connection
    $stmt->closeCursor();
    // Check if sql statement returned a match
    if(empty($isMatch)){
        return 0;
    } else {
        return 1;
    }
}
