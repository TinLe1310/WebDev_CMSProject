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
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if(empty($_POST['content']) || empty($_POST['title'])){
        $message = "Your title and content must have at least 1 character !";
    } 
    elseif($_POST && !empty($_POST['title']) && !empty($_POST['genre']) 
                        && !empty($_POST['author']) && !empty($_POST['content'])) {
                //  Build the parameterized SQL query and bind to the above sanitized values.
                $query = "INSERT INTO books (title, genre,) VALUES (:title, :content)";
        }
    
        $statement = $db->prepare($query);
        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":genre", $genre);
        $statement->bindValue(":author", $author);
        $statement->bindValue(":content", $content);

        //  Execute the INSERT.
        //  execute() will check for possible SQL injection and remove if necessary
        if($statement->execute()){
            header("Location: index.php");
            exit;
        }

        //  Execute the INSERT.
        //  execute() will check for possible SQL injection and remove if necessary
        if($statement->execute()){
            header("Location: index.php");
            exit;
        }

?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <title>My Blogs</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
    <?php if(!empty($message)): ?>
        <h1><?= $message ?></h1>
    <?php endif ?>
</body>
</html>