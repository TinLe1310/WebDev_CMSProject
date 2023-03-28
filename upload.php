<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Upload function

****************/

    require('connect.php');

    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $genre = filter_input(INPUT_POST, 'genre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);

    // Prepare query to get genre_id from genre_name in Genres table
    $genre_query = "SELECT genre_id FROM genres WHERE genre_name = :genre";
    $genre_statement = $db->prepare($genre_query);
    $genre_statement->bindValue(":genre", $genre);
    $genre_statement->execute();
    $genre_id = $genre_statement->fetch();
    
    // Prepare query to get author_id from pen_name in Authors table
    $author_query = "SELECT author_id FROM authors WHERE pen_name = :author";
    $author_statement = $db->prepare($author_query);
    $author_statement->bindValue(":author", $author);
    $author_statement->execute();
    $author_id = $author_statement -> fetch();

    
    
    if($_POST){
        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "INSERT INTO books (book_name, genre_id, author_id, book_description, rating) VALUES (:title, :genre, :author, :content, :rating)";  
        
        // A PDO::Statement is prepared from the query.
        $statement = $db->prepare($query);

        //  Bind values to the parameters
        $statement->bindValue(":title", $title);
        $statement->bindValue(":genre", $genre_id['genre_id']);
        $statement->bindValue(":author", $author_id['author_id']);
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