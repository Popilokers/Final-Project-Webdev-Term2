<?php
    
   require('connect.php');

   $username = trim(filter_input(INPUT_POST, 'usernameORemail', FILTER_SANITIZE_SPECIAL_CHARS));
   $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS));
   $account_type = $_POST['account_type'];
   
   $query = "SELECT * FROM users ORDER BY user_id DESC";
   $statement = $db->prepare($query);

   if($statement->execute()){
   }
   $strikes = 0;
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Please go back to the previous page to re-enter username and/or password</h1>
    <?php if(empty($username) || empty($password)):?>
        <h1 style="color: red;">ERROR: Username or Password fields are empty</h1>
    <?php else: ?>
        <?php while($row = $statement->fetch()):?>
            <?php if ($username == $row['username'] || $username == $row['email']):?>
            <?php else: ?>
                <h1>ERROR: username or email does not exist is incorrect</h1>
                <?php $strikes++;?>
            <?php endif?>

            <?php if ($password == $row['password']):?>
            <?php else:?>
                <h1>ERROR: password does not exist or is incorrect</h1>
                <?php $strikes++;?>
            <?php endif?>
            
            <?php if($strikes == 0 || $account_type == "guest"):?>
                <?php if($account_type != "guest"):?>
                    <?php $account_type = $row['type']?>
                <?php endif?>
                <?php session_start();
                        $_SESSION['username'] = $username;
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['account_type'] = $account_type;
                        $_SESSION['is_loggedin'] = true;
                ?>
                <?php header('Location: index.php')?>
            <?php endif?>
        <?php endwhile?>
    <?php endif ?>

    <form action="SignIn.php"><button>Go back</button></form>
    
</body>
</html>