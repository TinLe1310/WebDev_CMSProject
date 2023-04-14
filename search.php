<?php
/*******w******** 
    
    Name: Tin Le
    Date: 03/14/2023
    Description: CMS Project - Search Page

****************/
require('connect.php');
session_cache_limiter('private_no_expire');
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Validate genre value
    if(!empty($_POST["search_input"])){
        $keyword = $_POST["search_input"];
        $_SESSION["input"] = $keyword;                               
    }
}
else{
    $keyword = $_SESSION["input"];
}                                

// Setting starting page is 0 and items per page is 5
$start_page = 0;
$item_per_page = 8;

// Prepare and execute original query with no limit to capture number of pages
$pages_statement = $db->prepare("SELECT book_id, book_name, book_description, date_uploaded, rating, cover, pen_name, genre_name, author_name
                                 FROM books b JOIN authors a ON a.author_id = b.author_id 
                                 JOIN genres g ON g.genre_id = b.genre_id
                                 WHERE book_name LIKE '%". $keyword ."%' || genre_name LIKE '%". $keyword ."%' || 
                                       author_name LIKE '%". $keyword ."%' || pen_name LIKE '%". $keyword ."%'");

$pages_statement->execute();

$number_of_items = $pages_statement->rowCount();
$total_pages = ceil($number_of_items / $item_per_page);

if(isset($_GET["page"])){
    $page = $_GET["page"] - 1;
    $start_page = $page * $item_per_page;
}

// Prepare a select statement with chosen value
$query = "SELECT book_id, book_name, book_description, date_uploaded, rating, cover, pen_name, genre_name, author_name
          FROM books b JOIN authors a ON a.author_id = b.author_id 
          JOIN genres g ON g.genre_id = b.genre_id
          WHERE book_name LIKE '%". $keyword ."%' || genre_name LIKE '%". $keyword ."%' || 
                author_name LIKE '%". $keyword ."%' || pen_name LIKE '%". $keyword ."%'
          ORDER BY rating DESC LIMIT $start_page, $item_per_page";

$statement = $db->prepare($query);

// Attempt to execute the prepared statement
$statement->execute();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search.css">
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
                    <h1><i class="fa-sharp fa-solid fa-magnifying-glass-arrow-right fa-flip-horizontal"></i>Searching Tool <i class="fa-sharp fa-solid fa-magnifying-glass-arrow-right"></i></h1>
                </div>	
            </div>
            
            <div class="admin">                  
                <a href="admin_book.php"><i class="fa-solid fa-circle-user"></i></a>                    
            </div>
            <a href="logout.php" class="logout">Logout</a>
        </div>    

        <section class="main">
            <h2>Searching Books based on Keyword</h2>
            <div class="searchContainer">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="form">   
                    <div class="search_bar">   
                        <div class="input-container">
                            <input type="text" name="search_input" required="" value="<?= $keyword ?>"/>
                            <label>Your keyword 📚</label> 	
                        </div>
                        <div><input type="submit" id="button" value="Search 🔎"></div> 
                    </div> 
                </form>
            </div>

            <?php if($number_of_items > 0): ?>
                <div class="page_info">
                    <h2>Found <?= $number_of_items ?> Books based on your Keyword</h2>

                    <?php if(!isset($_GET["page"])): ?>
                        <?php $current_page = 1 ?>
                    <?php else: ?>
                        <?php $current_page = $_GET["page"] ?>
                    <?php endif ?>

                    <h2>Showing Page <?= $current_page ?> of <?= $total_pages ?></h2>
                </div>
                <div class="pagination">
                    
                    <!-- Navigate to the First Page -->
                    <a href="?page=1">First</a>
                    
                    <!-- Navigate to the Previous Page -->
                    <?php if(isset($_GET["page"]) && $_GET["page"] > 1): ?>
                        <a href="?page= <?= $_GET["page"] - 1 ?>">Previous</a>
                    <?php else: ?>
                        <a href="">Previous</a>    
                    <?php endif ?>
                    
                    <!-- Navigate to the Page with corresponding Number -->     
                    <?php for($counter = 1; $counter <= $total_pages; $counter++): ?>
                        <?php if($total_pages > 1): ?>
                            <a href="?page=<?= $counter ?>"><?= $counter ?></a>
                        <?php else: ?>
                            <a href=""><?= $counter ?></a>
                        <?php endif ?>
                    <?php endfor ?>
                    
                    
                    <!-- Navigate to the Next Page -->
                    <?php if(!isset($_GET["page"]) && $total_pages > 1): ?>
                        <a href="?page=2">Next</a>
                    <?php elseif(isset($_GET["page"]) && $_GET["page"] < $total_pages): ?>
                        <a href="?page= <?= $_GET["page"] + 1 ?>">Next</a>
                    <?php else: ?>
                        <a href="">Next</a> 
                    <?php endif ?>
                    
                    <!-- Navigate to the Last Page -->
                    <a href="?page=<?= $total_pages ?>">Last</a>
                </div>

                <div class="scene">
                    <?php while ($book=$statement->fetch()): ?>                                                                     
                        <div class="card">
                            <div class="card__face card__face--front">
                                <img src="uploads/<?= $book['cover'] ?>" />
                            </div>
                            <div class="card__face card__face--back">
                                <h2><?= $book['book_name'] ?></h2>
                                <p><?= $book['pen_name'] ?></p>
                                <a href="detailed_index.php?id=<?= $book['book_id'] ?>">Discover More</a>
                            </div>
                        </div>                       
                    <?php endwhile ?>
                </div>
            <?php else: ?>
                <div class="page_info">
                    <h2>Sorry 🥲 Bookaholic does not have any Books that related to your Keyword right now!</h2>

                    <h2>
                        Updated your title with this Keyword? 😊
                        <a href="admin_book.php">Upload here!</a>
                    </h2>
                </div>
            <?php endif ?>
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