<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Login Page

****************/
require('connect.php');

session_start();

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("Location: index.php");
    exit;
}

$username = $username_err = "";
$password = $password_err = "";
$login_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = " * Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = " * Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $query = "SELECT * FROM users WHERE user_name = :username";
        
        if($statement = $db->prepare($query)){
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Bind variables to the prepared statement as parameters
            $statement->bindParam(":username", $param_username);             
            
            // Attempt to execute the prepared statement
            if($statement->execute()){
                // Check if username exists, if yes then verify password
                if($statement->rowCount() == 1){
                    if($user = $statement->fetch()){
                        $id = $user["user_id"];
                        $username = $user["user_name"];
                        $level = $user["level"];
                        $hashed_password = $user["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["level"] = $level;                         
                            
                            // Redirect user to welcome page
                            header("Location: index.php");
                            exit;
                        } 
                        else{
                            // Password is not valid, display a generic error message
                            $login_err = " * Invalid password.";
                        }
                    }
                } 
                else{
                    // Username doesn't exist, display a generic error message
                    $login_err = " * Invalid username";
                }
            } 
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Sign In</title>
</head>
<body>
    <div class="main_page">
        <div class="header">
            <img src="images/logo.png" alt="logo">
            
            <div class="navContainer">
                <nav class="navMenu">
                    <a href="index.php" class="navigation">Home</a>
                    <a href="#" class="navigation">Genre</a>
                    <a href="#" class="navigation">Author</a>
                    <a href="#" class="navigation">Library</a>
                    <a href="#" class="navigation">About</a>
                    <a href="#" class="navigation">Register Now</a>
                </nav>

                <div class="welcome">
                    <h1> Sign In Bookaholic Account <i class="fa-brands fa-teamspeak"></i></h1>		
                </div>

            </div>
            
        </div> 
        <section class="main">   
            <h2>Sign In <i class="fa-solid fa-user"></i></h2>
            <p>Please fill this form to sign in your account.</p>
            <p>
                <?php 
                    if(!empty($login_err)){
                        echo $login_err;
                    }        
                ?>
            </p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="post_input">     
                    <div class="input-container">
                        <input type="text" name="username" required="" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <label>Username</label>
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>       
                    <div class="input-container">                       
                        <input type="password" name="password" required=""class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <label>Password</label>
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div>
                        <input type="submit" id="button" value="Login">
                    </div>
                    <p>Don't have any account? <a href="sign_up.php">Register here</a></p>
                </div>
            </form>
        </section> 
</body>
</html>