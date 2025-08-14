<?php
require('connect.php');

$titleError = "none";
$contentError = "none";
$categoryError = "none";
$imageError = "none";

$mode = "";
$command = $_POST['command'] ?? "New Post";
$title = "";
$caption = "";
$category = "";
$post_id = "";
$query = "";
$row = [];

// determines if user is making a new post or editing an existing post
if (isset($_GET['post_id'])) {
    $mode = "edit";
    $post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);
    
    $statement = $db->prepare("SELECT * FROM posts WHERE post_id = :post_id");  
    $statement->execute(['post_id' => $post_id]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    $query = "UPDATE posts SET title = :title, caption = :caption, category_id = :category_id WHERE post_id = :post_id"; 
} else {
    // new post
    $query = "INSERT INTO posts(title, caption, category_id, image) 
              VALUES (:title, :caption, :category_id, :image)";
}

// POST REQUEST HANDLING
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $caption = filter_input(INPUT_POST, 'caption', FILTER_SANITIZE_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);

    // DELETE
    if ($command === "delete") {
        $query = "DELETE FROM posts WHERE post_id = :post_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':post_id', $post_id);
        if ($statement->execute()) {
            header('Location: index.php');
            exit;
        }
    }

    // UPDATE
    elseif ($command === "update") {
        if (!empty($title) && !empty($caption) && !empty($category)) {
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title);
            $statement->bindValue(':caption', $caption);
            $statement->bindValue(':category_id', $category);
            $statement->bindValue(':post_id', $post_id);
            if ($statement->execute()) {
                header('Location: index.php');
                exit;
            }
        } else {
            $titleError = $contentError = $categoryError = "block";
        }
    }

    // NEW POST
    else {
        if (!empty($title) && !empty($caption) && !empty($category) && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
            $newdir = "uploads" . DIRECTORY_SEPARATOR . basename($image['name']);
            $allowedEXT = ['image/jpeg', 'image/png', 'image/gif'];

            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($file_info, $image['tmp_name']);
            finfo_close($file_info);

            if (!in_array($mimeType, $allowedEXT)) {
                $imageError = "Unsupported image format";
            } elseif (move_uploaded_file($image['tmp_name'], $newdir)) {
                $statement = $db->prepare($query);
                $statement->bindValue(':title', $title);
                $statement->bindValue(':caption', $caption);
                $statement->bindValue(':category_id', $category);
                $statement->bindValue(':image', $newdir);
                if ($statement->execute()) {
                    header('Location: index.php');
                    exit;
                }
            }
        } else {
            $titleError = $contentError = $categoryError = $imageError = "block";
        }
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
    <form action="#" method="post"  enctype="multipart/form-data">
        <fieldset>
            
            <label>Title</label>
            <br>
            <!-- sets the values of the post when editing -->
            <?php if($mode == "edit"):?>
                <input type="text" name="title" value="<?= htmlspecialchars($row['title'], ENT_QUOTES) ?>"/>
            <!-- shows form fields when new post-->
            <?php else:?>
                <input type="text" name="title"/>
            <?php endif ?>
                <p style="display: <?=$titleError?>;  color: red;">Error: Please fill out title field</p>
            <br>
            <label>Caption</label>
            <br>
            <?php if($mode == "edit"):?>
                <input type="text" name="caption" value="<?= htmlspecialchars($row['caption'], ENT_QUOTES) ?>"/>
            <?php else:?>
                <input type="text" name="caption"/>
            <?php endif ?>
                <p style="display: <?=$contentError?>; color: red;">Error: Please fill out caption field</p>
            <br>
            <label>Category</label>
            <br>
            <?php if($mode == "edit"):?>
                <input type="number" name="category_id" value="<?=$row['category_id']?>"/>
            <?php else:?>
                <input type="number" name="category_id"/>    
            <?php endif ?>
                <p style="display: <?=$categoryError?>;  color: red;">Error: Please fill out category field</p>
            <br>
            <label>Upload image (png, jpg, jpeg)</label>
            <br>
            <?php if($mode == "edit"):?>
                <h3>Sorry you cannot change the image after posting</h3>
                <br>
                <img src="<?=$row['image']?>" width="800" />
            <?php else:?>
                <p>Note: you cannot change your image after posting</p>
                <input type="file" name="image"/>
            <?php endif ?>
                <p style="display: <?=$imageError?>;  color: red;">Error: Please fill out image field</p>
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