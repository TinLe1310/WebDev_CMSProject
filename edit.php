<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Edit function

****************/

    require('connect.php');

    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $title = $_POST['title'];
    $genre = filter_input(INPUT_POST, 'genre', FILTER_VALIDATE_INT);
    $author = filter_input(INPUT_POST, 'author', FILTER_VALIDATE_INT);
    $content = $_POST['content'];
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_FLOAT);

    if($_POST){
        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "UPDATE books SET book_name = :title, genre_id = :genre, author_id = :author, book_description = :content, rating = :rating WHERE book_id = $id";
        
        // A PDO::Statement is prepared from the query.
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":genre", $genre);
        $statement->bindValue(":author", $author);
        $statement->bindValue(":content", $content);
        $statement->bindValue(":rating", $rating);

        //  Execute the UPDATE.
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