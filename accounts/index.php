<?php
//This is the accounts controller

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

// Get the array of classifications
$classifications = getClassifications();

// Build the navigation menu
$navList = buildNavMenu($classifications);
    
$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
if ($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
}

switch ($action){
    case 'registration': // Loads the registration.php view
        include '../view/registration.php';
        break;
    case 'register': // Processes the registration from the form in the registration.php view
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

        // Validate email on server side
        $clientEmail = checkEmail($clientEmail);

        // Validate password on server side
        $checkPassword = checkPassword($clientPassword);

        // Check if email exists in clients database table
        $accountExists = emailExists($clientEmail);
        if ( $accountExists ) {
            $_SESSION['message'] = '<p class="error-message">There is already an account under the email ' . $clientEmail . '. Would you like to log in instead? </p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)){
            $message = "<p class='error-message'>Please provide information for all empty form fields.</p>";
            include '../view/registration.php';
            exit; 
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Insert the data to the database.
        $regOutcome = regClient( $clientFirstname, $clientLastname, $clientEmail, $hashedPassword );

        // Check and report the result.
        if ($regOutcome === 1) {
            setcookie("firstname", $clientFirstname, strtotime("+ 1 year"), "/");
            $_SESSION['message'] = "<p class='success-message'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p class='error-message'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }

        break;
    case 'sign-in': // Processes the login from the form in the login.php view
        // Filter and store the data
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        
        // Validate email on server side
        $clientEmail = checkEmail($clientEmail);
        
        // Validate password on server side
        $checkPassword = checkPassword($clientPassword);

        // Check for missing data
        if(empty($clientEmail) || empty($checkPassword)){
            $_SESSION['message'] = "<p class='error-message'>Please provide information for all empty form fields.</p>";
            include '../view/login.php';
            exit; 
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if(!$hashCheck) {
        $_SESSION['message'] = "<p class='error-message'>Please check your password and try again.</p>";
        include '../view/login.php';
        exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Reset the firstname cookie
        setcookie("firstname", $clientData['clientFirstname'], 1, "/");
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view
        include '../view/admin.php';
        exit;

        break;
    case 'login': // Loads the login.php view
        include '../view/login.php';
        break;
    case 'logout': // Log out of current session
        session_destroy();
        include '../index.php';
        break;
    case 'update-account-info': // Loads the client-update.php view
        include '../view/client-update.php';
        exit;
        break;
    case 'process-account-changes': // Process account changes
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        // Validate email on server side
        $clientEmail = checkEmail($clientEmail);

        if ($clientEmail !== $_SESSION['clientData']['clientEmail']) {
            // Check if email exists in clients database table
            $accountExists = emailExists($clientEmail);
            if ( $accountExists ) {
                $accountMessage = '<p class="error-message">There is already another account using the email ' . $clientEmail . '.</p>';
                include '../view/client-update.php';
                exit;
            }
        }

        // Check for missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)){
            $accountMessage = "<p class='error-message'>All form fields are required.</p>";
            include '../view/client-update.php';
            exit; 
        }

        // Insert the data to the database.
        $updateResult = updateClient( $clientFirstname, $clientLastname, $clientEmail, $clientId );

        // Check and report the result.
        if ($updateResult === 1) {
            setcookie("firstname", $clientFirstname, strtotime("+ 1 year"), "/");
            $_SESSION['message'] = "<p class='success-message'>Account information updated successfully.</p>";
            // Update clientData in the session.
            $clientData = getClientById($clientId);
            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
            header('Location: /phpmotors/accounts/');
            exit;
        } else {
            $accountMessage = "<p class='error-message'>Account update failed. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }

        break;
    case 'save-new-password': // Update client password
        // Filter and store the data
        $oldClientPassword = filter_input(INPUT_POST, 'oldClientPassword', FILTER_SANITIZE_STRING);
        $newClientPassword = filter_input(INPUT_POST, 'newClientPassword', FILTER_SANITIZE_STRING);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        // Validate password on server side
        $checkNewPassword = checkPassword($newClientPassword);

        // Check for missing data
        if(empty($clientId) || empty($oldClientPassword) || empty($checkNewPassword)){
            $message = "<p class='error-message'>Please enter a valid password.</p>";
            include '../view/client-update.php';
            exit; 
        }

        // A valid password exists, proceed with the update process
        // Query the client data based on the clientId
        $clientData = getClientById($clientId);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($oldClientPassword, $clientData['clientPassword']);
        
        // If the hashes don't match on old password create an error
        // and return to the client update view
        if(!$hashCheck) {
            $passwordMessage = "<p class='error-message'>Update failed. Please check your old password and try again.</p>";
            include '../view/client-update.php';
            exit;
        }

        // Hash the checked new password
        $hashedPassword = password_hash($newClientPassword, PASSWORD_DEFAULT);

        // Insert the data to the database.
        $passwordUpdateResult = updatePassword( $clientId, $hashedPassword );

        // Check and report the result.
        if ($passwordUpdateResult === 1) {
            setcookie("firstname", $clientFirstname, strtotime("+ 1 year"), "/");
            $_SESSION['message'] = "<p class='success-message'>Password updated successfully.</p>";
            header('Location: /phpmotors/accounts/');
            exit;
        } else {
            $passwordMessage = "<p class='error-message'>Password update failed. Please try again.</p>";
            include '../view/client-update.php';
            exit;
        }
        break;
    default: // Load the admin view
        include '../view/admin.php';
        break;
    }
?>