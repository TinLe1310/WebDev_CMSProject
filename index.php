<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Index Home Page

****************/
require('connect.php');

// SQL is written as a String.
$query = "SELECT book_id, book_name, book_description, date_uploaded, rating, cover, pen_name, genre_name
          FROM books b JOIN authors a ON a.author_id = b.author_id 
                       JOIN genres g ON g.genre_id = b.genre_id
          ORDER BY rating DESC LIMIT 6";

 // A PDO::Statement is prepared from the query.
$statement = $db->prepare($query);

// Execution on the DB server is delayed until we execute().
$statement->execute();

$image_array = [];

// Truncated string for the blog over 200 characters. 
$length = 500;

function truncate($text, $length) {
if ($length >= \strlen($text)) {
    return $text;
}

return preg_replace("/^(.{1,$length})(\s.*|$)/s",'\\1...',$text);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
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

                <form action="search.php" method="post" id="form">
                    <div class="search_bar">   
                        <div class="input-container">
                            <input type="text" name="search_input" required=""/>
                            <label>Searching your favorite books 📚</label> 	
                        </div>
                        <div><input type="submit" id="button" value="Search 🔎"></div> 
                    </div>  	
                </form>
            </div>
            
            <div class="admin">                  
                <a href="admin_book.php"><i class="fa-solid fa-circle-user"></i></a>                    
            </div>
            <a href="logout.php" class="logout">Logout</a>
        </div>    

        
        <section class="main">
            <div class="container">
                <h1><i class="fa-solid fa-bookmark"></i> Most Popular <i class="fa-solid fa-bookmark"></i></h1>
                <div class="carousel">
                    <input type="radio" name="slides" checked="checked" id="slide-1">
                    <input type="radio" name="slides" id="slide-2">
                    <input type="radio" name="slides" id="slide-3">
                    <input type="radio" name="slides" id="slide-4">
                    <input type="radio" name="slides" id="slide-5">
                    <input type="radio" name="slides" id="slide-6">
                    <ul class="carousel__slides">
                        <?php while($book=$statement->fetch()): ?>
                            <?php $image_array[] = $book['cover'] ?>
                            <li class="carousel__slide">
                                <figure>
                                    <div>
                                        <img src="uploads/<?= $book['cover'] ?>" alt="cover_images">
                                    </div>
                                    <figcaption>
                                        <a href="detailed_index.php?id=<?= $book['book_id'] ?>" class="title">
                                            <span><?= $book['book_name'] ?></span>
                                        </a>
                                        <span class="description">
                                            <?php if($length < strlen($book['book_description'])):?>
                                                <?= truncate($book['book_description'], $length) ?>
                                                <a href="detailed_index.php?id=<?= $book['book_id'] ?>">Read more</a>
                                            <?php else: ?>
                                                <?= $book['book_description'] ?>
                                            <?php endif ?>
                                        </span>
                                        <span class="credit">Genre: <?= $book['genre_name'] ?></span>
                                        <span class="credit">Author: <?= $book['pen_name'] ?></span>
                                    </figcaption>
                                </figure>
                            </li>
                        <?php endwhile ?>
                    </ul>    
                    <ul class="carousel__thumbnails">
                        <li>
                            <label for="slide-1"><img src="uploads/<?= $image_array[0] ?>" alt=""></label>
                        </li>               
                        <li>
                            <label for="slide-2"><img src="uploads/<?= $image_array[1] ?>" alt=""></label>
                        </li>
                        <li>
                            <label for="slide-3"><img src="uploads/<?= $image_array[2] ?>" alt=""></label>
                        </li>
                        <li>
                            <label for="slide-4"><img src="uploads/<?= $image_array[3] ?>" alt=""></label>
                        </li>
                        <li>
                            <label for="slide-5"><img src="uploads/<?= $image_array[4] ?>" alt=""></label>
                        </li>
                        <li>
                            <label for="slide-6"><img src="uploads/<?= $image_array[5] ?>" alt=""></label>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="scene">
                <div class="card">
                    <div class="card__face card__face--front">
                        <img src="https://i.loli.net/2019/11/23/cnKl1Ykd5rZCVwm.jpg" />
                    </div>
                    <div class="card__face card__face--back">
                        <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1647930822i/23807.jpg" />
                    </div>
                </div>
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