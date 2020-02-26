<a href="/phpmotors/index.php" title="Go to the PHP Motors home page."><img src="/phpmotors/images/site/logo.png" alt="PHP Motors Logo"></a>
<?php 
        if(isset($cookieFirstname)) {
                echo "<span>Welcome $cookieFirstname!</span>";
        } 
?>
<span><a href='/phpmotors/accounts/index.php?action=login' title='Access your PHP Motors account.'>My Account</a></span>