<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Delete function

****************/

    require('connect.php');

    //  Sanitize user input to escape HTML entities and filter out dangerous characters.
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if($_POST){
        //  Build the parameterized SQL query and bind to the above sanitized values.
        $query = "DELETE FROM books WHERE book_id = $id";
        
        // A PDO::Statement is prepared from the query.
        $statement = $db->prepare($query);

        //  Execute the DELETE.
        //  execute() will check for possible SQL injection and remove if necessary
        if($statement->execute()){
            header("Location: index.php");
            exit;
        }
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