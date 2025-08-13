<?php

require('connect.php');


$query = "SELECT * FROM posts ORDER BY updated_at DESC";
$statement = $db->prepare($query);

if($statement->execute()){
    //i have no clue why but this needs to be in an if statement for the code to work
    // $statement->execute(); does not work 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home Page</a> </li>
            <li>Personal Page</li>
            <li><a href="edit.php">New Post</a></li>
        </ul>
    </nav>
    <div id="post_list">
        <?php while($row = $statement->fetch()):?>
            <div class="post" style="border: black solid 2px; padding: 5px">
                <h2><a href=""><?=$row['title']?></a></h2>
                <p><a href="edit.php?post_id=<?=$row['post_id']?>">edit</a></p>
                <p><?=$row['caption']?></p>
                <img src="" alt="image is supposed to be here"/>
            </div>
        <?php endwhile ?> 
    </div>
</body>
</html>