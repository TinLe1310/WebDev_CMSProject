<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Detailed Index Home Page

****************/

require('connect.php');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);


if(!$id){
    header("Location: index.php");
    exit;
}

if(isset($_GET['id'])){
    // SQL is written as a String.
    $query = "SELECT book_id, book_name, book_description, date_uploaded, rating, cover, pen_name, genre_name
    FROM books b JOIN authors a ON a.author_id = b.author_id 
                JOIN genres g ON g.genre_id = b.genre_id
    WHERE book_id = $id";

    // A PDO::Statement is prepared from the query.
    $statement = $db->prepare($query);

    // Execution on the DB server is delayed until we execute().
    $statement->execute();

    $book=$statement->fetch();
    $rating = $book['rating'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detailed_index.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title><?= $book['book_name'] ?></title>
</head>
<body>
    <div class="main_page">

        <div class="header">
            <img src="images/logo.png" alt="logo">
            
            <div class="navContainer">
                <nav class="navMenu">
                    <a href="index.php" class="navigation">Home</a>
                    <a href="genre.php" class="navigation">Genre</a>
                    <a href="#" class="navigation">Author</a>
                    <a href="#" class="navigation">Library</a>
                    <a href="#" class="navigation">About</a>
                    <a href="sign_up.php" class="navigation">Register Now</a>
                </nav>

                <div class="input-container">
                    <input type="text" required=""/>
                    <label>Searching your favorite books</label>		
                </div>

            </div>
            
            <div class="admin">
                <a href="admin_book.php"><i class="fa-solid fa-users"></i></a>
            </div>
        </div>    

        
        <section class="main">
            <div class="container">
                <h1><i class="fa-solid fa-bookmark"></i> <?= $book['book_name']?> - <?= $book['book_id'] ?> <i class="fa-solid fa-bookmark"></i></h1>
                <div class="carousel">
                    <input type="radio" name="slides" checked="checked" id="slide-1">
                    
                    <ul class="carousel__slides">
                        <li class="carousel__slide">
                            <figure>
                                <div>
                                    <img src="<?= $book['cover'] ?>" alt="cover_images">
                                </div>
                                <figcaption>
                                    <span class="title">
                                        <?= $book['book_name'] ?>
                                    </span>    
                                    <span class="author"><?= $book['pen_name'] ?></span>
                                    <span class="rating">
                                        Rating:
                                        <?php while($rating >= 1): ?>
                                            <i class="fa-solid fa-star"></i>
                                            <?php
                                                $rating -= 1;
                                            ?> 
                                        <?php endwhile ?>
                                        <p> (<?= $book['rating'] ?>) </p>
                                    </span>
                                    <span class="description">                                                                                                                                        
                                        <?= $book['book_description'] ?>                                           
                                    </span>
                                    <span class="genre">Genre: <?= $book['genre_name'] ?></span>
                                    
                                </figcaption>
                            </figure>
                        </li>
                    </ul>    
                </div>
            </div>

            <div class="comment">
                
            </div>

            <form action="">
                <div class="sign_up">    
                    <p>Sign up to Bookaholic Guide</p>                                                                     
                    <input type="text" placeholder="Enter your name"/>                                             
                    <input type="mail" placeholder="Enter your email"/>            
                    <button class="btn">
                        <span>Subcribe</span>
                    </button>
                </div>
            </form>
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