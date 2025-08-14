<?php

session_start();

//redirects user to log in page is not logged in
if(!isset($_SESSION['is_loggedin']) || $_SESSION['is_loggedin'] == false){
    header('Location: SignIn.php');
}

require_once('connect.php');



$sort = isset($_POST['sort']) ? $_POST['sort'] : "ORDER BY uploaded_at DESC";




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    
        <!-- logs out the user -->
        <form method="post" action="SignIn.php" style="text-align: right;">
            <button onclick=logout()>log out</button>
        </form>

        <!-- accessible pages -->
        <nav>
            <ul>
                <li><a href="index.php">Home Page</a> </li>

                <!-- checks for authority -->
                <?php if($_SESSION['account_type'] == "admin"):?>
                    <li><a href="edit.php">New Post</a></li>
                <?php endif?>
            </ul>
            
        </nav>
        <?php if($_SESSION['account_type'] == "admin"):?>
            <form action="index.php" method="post">
                <select name="sort">
                    <option value="ORDER BY title ASC">A-Z ascending</option>
                    <option  value="ORDER BY title DESC">A-Z descending</option>
                    <option  value="ORDER BY uploaded_at ASC">Date ascending</option>
                    <option  value="ORDER BY uploaded_at DESC">Date descending</option>
                </select>
                <button type="submit">sort</button>
            </form>
        <?php endif?>
        
        <?php
        $query = "SELECT * FROM posts " . $sort;
        $statement = $db->prepare($query);
        if($statement->execute()){
}
        ?>
        <div id="post_list">
            <?php while($row = $statement->fetch()):?>
                <div class="post" style="border: black solid 2px; padding: 5px">

                    <!-- linked to focused post -->
                    <h2><a href="post.php?id=<?=$row['post_id']?>"><?=$row['title']?></a></h2>

                    <!-- checks for authority -->
                    <?php if($_SESSION['account_type'] == "admin"):?>
                        <p><a href="edit.php?post_id=<?=$row['post_id']?>">edit</a></p>
                    <?php endif ?>
                    <p><?=$row['caption']?></p>
                    <img src="<?=$row['image']?>" alt="image is supposed to be here" height="500" />
                </div>
            <?php endwhile ?> 
        </div>
</body>
</html>