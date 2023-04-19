<?php 
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Admin Upload Page

****************/

require ('connect.php');

// Initialize the session
session_start();
$_SESSION["key"] = "upload";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Prepare query to get genre_name from genre_id in Genres table
$genre_query = "SELECT * FROM genres ORDER BY genre_id ASC";
$genre_statement = $db->prepare($genre_query);
$genre_statement->execute();

// Prepare query to get pen_name from author_id in Authors table
$author_query = "SELECT * FROM authors ORDER BY author_id ASC";
$author_statement = $db->prepare($author_query);
$author_statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_book.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Upload Page</title>
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
                    <h1>Welcome back The Librarian <i class="fa-brands fa-teamspeak"></i></h1>		
                </div>

            </div>
            
            <div class="add_book">
                <a href="pre_level_up.php"><i class="fa-solid fa-book-medical"></i></a>
            </div>
        </div> 

        
        <section class="main">
            <div id="admin_book">  
            
                <div id="title">
                    <a href="admin_book.php">Add New Book <i class="fa-solid fa-plus"></i></a>
                    <a href="admin_pre_edit.php">Edit Book <i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="admin_delete.php">Delete Book <i class="fa-solid fa-trash"></i></a>
                </div>              
                
                <form method="post" id="form" action="upload.php">
                    <div class="post_input">
                            
                        <div class="input-container">
                            <p>Cover Image</p>
                            <?php if(isset($_GET['cover'])): ?>
                                <img src="uploads/<?= $_GET['cover'] ?>" alt="">
                                <input name="cover" type="hidden" value="<?= $_GET['cover'] ?>">
                                <a href="choose_image.php">+ Choose Other Cover</a>
                            <?php else: ?>
                                <p>NO COVER SELECTED</p>
                                <input name="cover" type="hidden" value="">
                                <a href="choose_image.php">+ Choose Cover</a>
                            <?php endif ?>
                        </div>

                        <div class="input-container">
                            <input type="text" name="title" required="">
                            <label>Title</label>
                        </div>
                                
                        <div class="input-container">
                            <input type="text" name="genre" list="genre_browser" required="">
                            <label>Genre</label>
                            <datalist id="genre_browser">
                                <?php while($genre = $genre_statement->fetch()): ?>
                                    <option value="<?= $genre['genre_name'] ?>"></option>
                                <?php endwhile ?>
                            </datalist>
                        </div>    

                        <div class="input-container">
                            <input type="text" name="author" list="author_browser" required="">
                            <label>Author</label>
                            <datalist id="author_browser">
                                <?php while($author = $author_statement->fetch()): ?>
                                    <option value="<?= $author['pen_name'] ?>"></option>
                                <?php endwhile ?>
                            </datalist>
                            <a href="new_item.php">+ New Author</a>
                        </div>    

                        <div class="input-container">
                            <textarea id="content" name="content" required=""></textarea>
                            <label>Short Description</label>
                        </div>

                        <div class="input-container">
                            <input type="text" name="rating" required="">
                            <label>Rating</label>
                        </div>

                        <div><input type="submit" id="button" value="Upload Book"></div>
                    </div>
                </form>
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
                            <li><a href="choose_image.php">About</a></li>
                            <li><a href="sign_up.php">Register</a></li>                           
                            </ul>
                        </div>
                </div>
        </footer>
    </div>
</body>
</html>