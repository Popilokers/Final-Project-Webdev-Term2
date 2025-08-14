<?php
require('connect.php');
$statement = $db->prepare("SELECT * FROM posts WHERE post_id = :post_id");
$statement->execute(['post_id' => $_GET['id']]);
$row = $statement->fetch(PDO::FETCH_ASSOC);

$title = $row['title'];
$caption = $row['caption'];
$category = $row['category_id'];

$query = "SELECT * FROM posts LIMIT 1";
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
    <title>Document</title>
</head>
<body>
    <p>Title: <?=$title?></p>
    <p>Caption: <?=$caption?></p>
    <img src="<?= $row['image']?>" height="550"/>
</body>
</html>