<?php
/*******w******** 
    
    Name: Tin Le
    Date: 01/23/2023
    Description: Assignment 3 - Insert php to modify the database

****************/

    require('connect.php');

    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_FLOAT);

    if($_POST){
        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "INSERT INTO books (title, genre, author, content, rating) VALUES (:title, :genre, :author, :content, :rating)";  
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":genre", $genre);
        $statement->bindValue(":author", $author);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":rating", $rating);

        //  Execute the INSERT.
        //  execute() will check for possible SQL injection and remove if necessary
        if($statement->execute()){
            header("Location: index.php");
            exit;
        }
    }
    else $message = " ❗❗❗ ERROR❗❗❗";


?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Error</title>
</head>
<body>
    <?php if(!empty($message)): ?>
        <h1><?= $message ?></h1>
    <?php endif ?>
</body>
</html>