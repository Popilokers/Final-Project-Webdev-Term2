<?php

require('connect.php');


$user_type = "";

$mode ="";
$query ="";

$statement = "";

$title = "";
$caption = "";
$category = "";

$command = "";

if(isset($_POST['command'])){
    $command = $_POST['command']; //Update or Delete
    
}
else{
    $command = "New Post";
}

if(isset($_GET['post_id'])){

    $mode = "edit";
    echo "post id: " . $_GET['post_id'];
    echo "<br> action: " . $command;
    echo "<br> query: " .
    //defines $id early to use to edit an existing blog
    $id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);

    //query that selects the specific row to be edited from the database
     $statement = $db->prepare("SELECT * FROM posts WHERE post_id = :post_id");  
     $statement->execute(['post_id' => $_GET['post_id']]);

     $row = $statement->fetch(PDO::FETCH_ASSOC);


     $query = "UPDATE posts SET title = :title, caption = :caption, category_id = :category_id WHERE post_id = :post_id"; 
     $post_id = filter_input(INPUT_GET, 'post_id');
     
}
else{
    $mode = "newPost";

    echo "new post";
    $query = "INSERT INTO posts(title, caption, category_id) 
              VALUES (:title, :caption, :category_id)";
    } 

 
if(!empty($_POST['title']) && !empty($_POST['caption']) && !empty($_POST['category_id'])){
        
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);
        $category = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        
        // $image = filter_input(INPUT_GET, 'image'); 

        
        $statement = $db->prepare($query);
        
        $statement->bindValue(':title', $title);
        $statement->bindValue(':caption', $caption);
        $statement->bindValue(':category_id', $category);

        if($command == "update"){
            $statement->bindValue(':post_id', $post_id);
        }
        
         if($command == "delete"){
    
            $query = "DELETE FROM posts WHERE post_id = :post_id";
            $statement = $db->prepare($query);
            $statement->bindValue(':post_id', $post_id);

            //executes query and redirects to home page
            if($statement->execute()){
                header('Location: index.php');
            }
        
        }
        
        if($statement->execute()){
        header('Location: index.php');
    }
    
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <nav>
        <ul>
            <li><a href="index.php">Home Page</a> </li>
            <li>Personal Page</li>
            <li><a href="edit.php">New Post</a></li>
        </ul>
    </nav>
    <form action="#" method="post">
        <fieldset>
            <label>Title</label>
            <br>
            <?php if($mode == "edit"):?>
                <input type="text" name="title" value="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"/>
            <?php else:?>
                <input type="text" name="title"/>
            <?php endif ?>
            <br>
            <label>Caption</label>
            <br>
            <?php if($mode == "edit"):?>
                <input type="text" name="caption" value="<?= htmlspecialchars($row['caption'], ENT_QUOTES) ?>"/>
            <?php else:?>
                <input type="text" name="caption"/>
            <?php endif ?>
            <br>
            <label>Category</label>
            <br>
            <?php if($mode == "edit"):?>
            <input type="number" name="category_id" value="<?=$row['category_id']?>"/>
            <?php else:?>
            <input type="number" name="category_id"/>    
            <?php endif ?>
            <br>
            <label>Image</label>
            <br>
            <input type="file" name="image"/>

            <br>
            <br>

        <?php if($mode == "edit"):?>
            <button type="submit" name="command" value="update">Update Post</button>
            <button type="submit" name="command" value="delete">Delete Post</button>
        <?php else: ?>
        <button type="submit">Upload Post</button>

        <?php endif?>
        </fieldset>
    </form>
</body>
</html>