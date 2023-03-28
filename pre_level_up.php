<?php 
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Level Up Page

****************/

require ('connect.php');

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["level"] != 2){
    header("location: admin_book.php");
    exit;
}

// Prepare a select statement with chosen value
$user_query = "SELECT * FROM users ORDER BY user_id ASC";

// Prepare statement
$user_statement = $db->prepare($user_query);

// Attempt to execute the prepared statement
$user_statement->execute();

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
    <title>Level Up Page</title>
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

                <div class="welcome">
                    <h1>Leveling Up Our Users  <i class="fa-brands fa-teamspeak"></i></h1>		
                </div>

            </div>
            
            <div class="add_book">
                <a href="admin_book.php"><i class="fa-solid fa-arrow-rotate-left"></i></a>
            </div>
        </div> 

        
        <section class="main">
            <div id="admin_book">  
                <form method="post" id="form" action="level_up.php"> 
                    <div id="title">
                        <a href="#">Level Up <i class="fa-solid fa-turn-up"></i></a>
                    </div>    
            
                    <div class="post_input">
                                
                        <div class="input-container">
                            <input type="text" name="user" list="user_browser" required="">
                            <label>Choose User</label>
                            <datalist id="user_browser">
                                <?php while($user = $user_statement->fetch()): ?>
                                    <option value="<?= $user['user_name'] ?>"></option>
                                <?php endwhile ?>
                            </datalist>
                        </div>

                        <div><input type="submit" id="button" value="Choose User"></div>
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
                            <li><a href="#">About</a></li>
                            <li><a href="sign_up.php">Register</a></li>                           
                            </ul>
                        </div>
                </div>
        </footer>
    </div>
</body>
</html>