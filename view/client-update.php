<?php
    // If the current user doesn't have a session set, or is not logged in, redirect to home view.
    if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
        header('Location: /phpmotors/');
        exit;
    }
    // Store client data into new variable
    if(isset($_SESSION['clientData'])) {
        $clientData = $_SESSION['clientData'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Account Update | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/styles.css" media="screen">
</head>

<body>
    <div class="site-wrapper">
        <header>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>
            <h1><?php if(isset($clientData['clientFirstname'])) {echo "$clientData[clientFirstname] $clientData[clientLastname]"; } ?></h1>
            <?php
                if (isset($message)) {
                    echo $message;
                }
            ?>
            <section>
                <h2>Update Account Information</h2>
                <?php
                    if (isset($_SESSION['accountMessage'])) {
                        $accountMessage = $_SESSION['accountMessage'];
                        unset($_SESSION['accountMessage']);
                    }
                    if (isset($accountMessage)) {
                        echo $accountMessage;
                    }
                ?>
                <form id="update-account" class="user-management" method="post" action="/phpmotors/accounts/index.php">
                    <div>
                        <label for="clientFirstname">First Name</label>
                        <input type="text" id="clientFirstname" name="clientFirstname"
                            <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} elseif(isset($clientData['clientFirstname'])) {echo "value='$clientData[clientFirstname]'"; } ?> required>
                    </div>
                    <div>
                        <label for="clientLastname">Last Name</label>
                        <input type="text" id="clientLastname" name="clientLastname"
                            <?php if(isset($clientLastname)){echo "value='$clientLastname'";} elseif(isset($clientData['clientLastname'])) {echo "value='$clientData[clientLastname]'"; } ?> required>
                    </div>
                    <div>
                        <label for="clientEmail">Email</label>
                        <input type="email" id="clientEmail" name="clientEmail"
                            <?php if(isset($clientEmail)){echo "value='$clientEmail'";} elseif(isset($clientData['clientEmail'])) {echo "value='$clientData[clientEmail]'"; } ?> required
                            pattern="[\w\\.\+_-*]+@[\w]+\.[\w]{2,4}">
                    </div>
                    <div>
                        <input type="submit" name="submit" id="process-account-changes" value="Update Account">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="process-account-changes">
                        <input type="hidden" name="clientId" value="<?php if(isset($clientData['clientId'])){ echo $clientData['clientId'];} elseif(isset($clientId)){ echo $clientId; } ?>">
                    </div>
                </form>
            </section>
            <section>
                <h2>Change Password</h2>
                <?php
                    if (isset($_SESSION['passwordMessage'])) {
                        $passwordMessage = $_SESSION['passwordMessage'];
                        unset($_SESSION['passwordMessage']);
                    }
                    if (isset($passwordMessage)) {
                        echo $passwordMessage;
                    }
                ?>
                <form id="update-password" class="user-management" method="post" action="/phpmotors/accounts/index.php">
                    <div>
                        <label for="oldClientPassword">Old Password</label>
                        <input type="password" id="oldClientPassword" name="oldClientPassword" required
                            pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                    </div>
                    <div>
                        <label for="newClientPassword">New Password</label>
                        <input type="password" id="newClientPassword" name="newClientPassword" required
                            pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                        <span class="fine-print">Submitting this form will change the password for your account. New password must be at least 8 characters and contain at least 1 number, 1 capital
                            letter, and 1 special character.</span>
                    </div>
                    <div>
                        <input type="submit" name="submit" id="save-new-password" value="Change Password">
                        <!-- Add the action name - value pair -->
                        <input type="hidden" name="action" value="save-new-password">
                        <input type="hidden" name="clientId" value="<?php if(isset($clientData['clientId'])){ echo $clientData['clientId'];} elseif(isset($clientId)){ echo $clientId; } ?>">
                    </div>
                </form>
            </section>
        </main>
        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/phpmotors/common/footer.php'; ?>
            <p>Last Updated: <?php 
            date_default_timezone_set('UTC');
            echo date ("d F , Y", getlastmod()); 
            ?></p>
        </footer>
    </div>
</body>

</html>