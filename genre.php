<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Genre Page

****************/
require('connect.php');

$message = "";

// Prepare query to get genre_name from genre_id in Genres table
$genre_query = "SELECT * FROM genres ORDER BY genre_id ASC";
$genre_statement = $db->prepare($genre_query);
$genre_statement->execute();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Validate genre value
    if(!empty($_POST["genre"])){

        // Prepare a select statement with chosen value
        $query = "SELECT book_id, book_name, book_description, date_uploaded, rating, cover, genre_name, pen_name
                  FROM books b JOIN genres g ON g.genre_id = b.genre_id
                               JOIN authors a ON a.author_id = b.author_id 
                  WHERE g.genre_name = :genre
                  ORDER BY rating DESC LIMIT 5";
    
        if($statement = $db->prepare($query)){
            // Set parameters
            $genre = $_POST["genre"];

            // Bind variables to the prepared statement as parameters
            $statement->bindParam(":genre", $genre);
            
            // Attempt to execute the prepared statement
            $statement->execute();
            
            $number_of_item = $statement->rowCount();
        }
    }                                 
}
else{
    $message = ".";
}

$image_array = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="genre.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Main Page</title>
</head>
<body>
    <div class="main_page">

        <div class="header">
            <img src="images/logo.png" alt="logo">
            
            <div class="navContainer">
                <nav class="navMenu">
                    <a href="index.php" class="navigation">Home</a>
                    <a href="genre.php" class="navigation">Genre</a>
                    <a href="author.php" class="navigation">Author</a>
                    <a href="#" class="navigation">Library</a>
                    <a href="#" class="navigation">About</a>
                    <a href="sign_up.php" class="navigation">Register Now</a>
                </nav>

                <div class="welcome">
                    <h1><i class="fa-solid fa-bars-staggered"></i>  Genre Categories <i class="fa-solid fa-bars-staggered"></i></h1>
                </div>	
            </div>
            
            <div class="admin">                  
                <a href="admin_book.php"><i class="fa-solid fa-circle-user"></i></a>                    
            </div>
            <a href="logout.php" class="logout">Logout</a>
        </div>    

        
        <section class="main">
            <h2>Searching books based on genres</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form">   
                <div class="post_input">       
                    <div class="input-container">
                        <input type="text" name="genre" required="" list="title_browser">
                        <label>Select your Desired Genre</label>
                        <datalist id="title_browser">
                            <?php while($genre = $genre_statement->fetch()): ?>
                                <option value="<?= $genre['genre_name'] ?>"></option>
                            <?php endwhile ?>
                        </datalist>
                    </div>
                        
                    <div><input type="submit" id="button" value="Choose Book"></div>
                </div>
            </form> 

            <div class="scene">
                <?php if($message != ""): ?>
                    <?= $message ?>
                <?php else: ?>
                    <?php if($number_of_item > 0): ?>
                        <?php while ($book=$statement->fetch()): ?>                                                                     
                            <div class="card">
                                <div class="card__face card__face--front">
                                    <img src="<?= $book['cover'] ?>" />
                                </div>
                                <div class="card__face card__face--back">
                                    <h2><?= $book['book_name'] ?></h2>
                                    <p><?= $book['pen_name'] ?></p>
                                    <a href="detailed_index.php?id=<?= $book['book_id'] ?>">Discover More</a>
                                </div>
                            </div>                       
                        <?php endwhile ?>
                    <?php else: ?>
                        <div class="page_info">
                            <h2>Sorry 🥲 Bookaholic hasn't had any Books that catergorized as  <?= $_POST["genre"] ?> yet 😥</h2>

                            <h2>
                                Updated your own Book of this Genre? 😊
                                <a href="admin.php">Upload here!</a>
                            </h2>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            </div>
        </section>

        <footer>
            <div class="footer-content">
                <h3>Bookaholic</h3>
                <p>Bookaholic is the new-era digital library, in where you can find any types of your favorite books!!!</p>
                <ul class="socials-media">
                    <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa-brands fa-youtube"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
                </ul>
            </div>

            <div class="footer-bottom">
                    <p>copyright &copy; <a href="#">Bookaholic</a></p>
                        <div class="footer-menu">
                            <ul class="f-menu">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="sign_up.php">Register</a></li>                           
                            </ul>
                        </div>
                </div>
        </footer>
    </div>
</body>
</html>