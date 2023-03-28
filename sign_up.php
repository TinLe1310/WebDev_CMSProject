<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Sign Up Page

****************/
require('connect.php');

$username = $username_err = "";
$password = $password_err = "";
$confirm_password = $confirm_password_err = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $query = "SELECT user_id FROM users WHERE user_name = :username";
        
        if($statement = $db->prepare($query)){
            // Set parameters
            $param_username = trim($_POST["username"]);

            // Bind variables to the prepared statement as parameters
            $statement->bindParam(":username", $param_username);
            
            // Attempt to execute the prepared statement
            if($statement->execute()){
                if($statement->rowCount() == 1){
                    $username_err = " * This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = " * Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = " * Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = " * Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = " * Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $query = "INSERT INTO users (user_name, password, level) VALUES (:username, :password, 1)";
         
        if($statement = $db->prepare($query)){
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Bind variables to the prepared statement as parameters
            $statement->bindParam(":username", $param_username);
            $statement->bindParam(":password", $param_password);
            
            
            // Attempt to execute the prepared statement
            if($statement->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
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
    <link rel="stylesheet" href="sign_up.css">
    <script src="https://kit.fontawesome.com/1b22186fee.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title>Register</title>
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
                    <h1> Sign Up to Bookaholic <i class="fa-brands fa-teamspeak"></i></h1>		
                </div>

            </div>
            
        </div> 
        <section class="main">   
            <h2>Sign Up <i class="fa-solid fa-user-plus"></i></h2>
            <p>Please fill this form to create an account.</p>
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
                    <div class="input-container">                        
                        <input type="password" name="confirm_password" required="" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <label>Confirm Password</label>
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div>
                        <input type="submit" id="button" value="Sign Up">
                    </div>
                    <p>Already have an account? <a href="login.php">Login here</a></p>
                </div>
            </form>
        </section> 
</body>
</html>