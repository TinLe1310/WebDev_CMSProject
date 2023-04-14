<?php
    $files = scandir('uploads');
    session_start();
    $_SESSION["key"] = "edit";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="choose_image.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Edit Image Page</title>
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
                    <h1><i class="fa-solid fa-bars-staggered"></i>  Images Gallery <i class="fa-solid fa-bars-staggered"></i></h1>
                </div>	
            </div>
            
            <div class="admin">                  
                <a href="admin_book.php"><i class="fa-solid fa-circle-user"></i></a>                    
            </div>
            <a href="logout.php" class="logout">Logout</a>
        </div>    

        <section class="main">
            <div class="scene">
                <?php foreach($files as $file): ?>  
                    <?php if($file !== "." && $file !== ".."): ?>                                                               
                        <div class="card">
                            <div class="card__face card__face--front">
                                <img src="uploads/<?= $file?>" />
                            </div>
                            <div class="card__face card__face--back">
                                <h2><?= $file ?></h2>`    
                                <a href="admin_edit.php?cover=<?= $file ?>">Choose this Cover</a>
                            </div>
                        </div>
                    <?php endif ?>                      
                <?php endforeach ?>
            </div>

            <form action="fileUpload.php" method="post" enctype="multipart/form-data">
                <h2>Upload your cover Image to the Gallery</h2>    
                <input type="file" name="uploaded_file" id="choose_file">
                <div><input type="submit" name="submit" id="button1"  value="Upload Cover"></div>
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