<?php 
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Admin Upload Page

****************/

require ('authenticate.php')
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
                    <a href="#" class="navigation">Home</a>
                    <a href="#" class="navigation">Genre</a>
                    <a href="#" class="navigation">Author</a>
                    <a href="#" class="navigation">Library</a>
                    <a href="#" class="navigation">About</a>
                    <a href="#" class="navigation">Register Now</a>
                </nav>

                <div class="welcome">
                    <h1>Welcome back The Librarian <i class="fa-brands fa-teamspeak"></i></h1>		
                </div>

            </div>
            
            <div class="add_book">
                <a href="admin.php"><i class="fa-solid fa-book-medical"></i></a>
            </div>
        </div> 

        
        <section class="main">
            <div id="admin_book">  
                <form method="post" id="form" action="insert.php"> 
                    <div id="title">
                        <a href="">Add New Book <i class="fa-solid fa-plus"></i></a>
                        <a href="admin_edit.php">Edit Book <i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="admin_delete.php">Delete Book <i class="fa-solid fa-trash"></i></a>
                    </div>    
            
                    <div class="post_input">
                            
                        <div class="input-container">
                            <input type="text" name="title" required="">
                            <label>Title</label>
                        </div>
                            
                        <div class="input-container">
                            <input type="text" name="genre" required="">
                            <label>Genre</label>
                        </div>    

                        <div class="input-container">
                            <input type="text" name="author" required="">
                            <label>Author</label>
                        </div>    

                        <div class="input-container">
                            <textarea name="content" required=""></textarea>
                            <label>Description</label>
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
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Register</a></li>                           
                            </ul>
                        </div>
                </div>
        </footer>
    </div>
</body>
</html>