<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Delete function

****************/

    require('connect.php');
    session_start();
    

    if($_POST && !isset($_SESSION["image"])){
        $book_name = $_POST['name'];

        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "DELETE FROM books WHERE book_name = :book_name";
        
        // A PDO::Statement is prepared from the query.
        $statement = $db->prepare($query);
        $statement->bindParam(":book_name", $book_name);

        //  Execute the DELETE.
        //  execute() will check for possible SQL injection and remove if necessary
        if($statement->execute()){
            header("Location: index.php");
            exit;
        }
    }
    elseif($_SESSION['image'] == 'delete'){
        $cover = $_POST['cover'];
        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "UPDATE books SET cover = null WHERE cover LIKE '%". $cover ."%'";
        
        // A PDO::Statement is prepared from the query.
        $statement = $db->prepare($query);

        $statement->execute();

        array_map('unlink', glob("uploads/".$_POST['cover']));

        header("Location: choose_image.php");
    }
    else $message = "❗❗❗ ERROR❗❗❗";


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