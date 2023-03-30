<?php 
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Admin Upload Page

****************/

require ('connect.php');

 
// Check if the user is logged in, if not then redirect him to login page
if($_POST){
    if(!empty($_POST["user"]) && empty($_POST['id'])){

        // Prepare a select statement with chosen value
        $query = "SELECT * FROM users b 
                  WHERE user_name = :user";
    
        if($statement = $db->prepare($query)){
            // Set parameters
            $username = $_POST["user"];

            // Bind variables to the prepared statement as parameters
            $statement->bindParam(":user", $username);
            
            // Attempt to execute the prepared statement
            $statement->execute(); 
            
            $user = $statement -> fetch();
        }
    }
    else
    {
        $id = $_POST['id'];
        $level_query = "UPDATE users SET level = 2 WHERE user_id = $id";
        $level_statement = $db->prepare($level_query);
        $level_statement->execute();

        header("Location: index.php");
    }                                
}

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
                <a href="pre_level_up.php"><i class="fa-solid fa-arrow-rotate-left"></i></a>
            </div>
        </div> 

        
        <section class="main">
            <div id="admin_book">  
                <form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
                    <div id="title">
                        <a href="#">Level Up <i class="fa-solid fa-turn-up"></i></a>
                    </div>    
            
                    <div class="post_input">     
                        <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                                                                            
                        <div class="input-container">
                            <input type="text" name="name" value="<?= $user['user_name'] ?>">
                            <label>Username</label>
                        </div>    

                        <div class="input-container">
                            <input type="text" name="level" value="<?= $user['level'] ?>">
                            <label>Current Level</label>
                        </div>    

                        <div class="input-container">
                            <input id="content" name="date" value="<?= $user['date_created'] ?>"></textarea>
                            <label>Registered Date</label>
                        </div>

                        <div><input type="submit" id="button" value="Level Up !!!"></div>
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