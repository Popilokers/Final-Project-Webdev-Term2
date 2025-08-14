<?php

// resets session values when "log out"
session_start();
if(isset($_SESSION['is_loggedin'])){
    $_SESSION['is_loggedin'] = false;
}
if(isset($_SESSION['account_type'])){
    $_SESSION['account_type'] = "";
}
if(isset($_SESSION['username'])){
    $_SESSION['username'] = "";
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
</head>
<body>
    <form method="Post" action="accountVerify.php">
        <fieldset>
            <label>Username or Email</label>
            <br>
            <input type="text" name="usernameORemail"/>
            <br>
            <br>
            <label>Password</label>
            <br>
            <input type="password" name="password"/>
            <br>
            <br>
            <button type="submit" name="account_type" value="not_guest">Sign In</button>
            <p>OR</p>
            
            <button type="submit" name="account_type" value="guest">Sign In As Guest</button>

        </fieldset>
    </form>
</body> 
</html>