
<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'alexproject';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Image Gallery with Titles</title>

    <nav>
    <ul>
        <li><a href="destinations.php">Destination</a></li>
        <li><a href="photos.php">Gallery</a></li>
        <li><a href="reviews.php">Reviews</a></li>
        <li><a href="tips.php">Tips</a></li>
        <li><a href="users.php">Log In/Sign Up</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li style="float:right;">
            <?php
            if (isset($_SESSION['user'])) {
                echo "Hi, " . htmlspecialchars($_SESSION['user']) . "!";
            } else {
                echo "<a href='users.php'>Log in</a>";
            }
            ?>
        </li>
    </ul>
</nav>



    
  

    <style>

/* Navigation Bar Styles */
nav {
    background-color: #ffff;
    padding: 10px 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

nav ul {
    list-style-type: none;
    text-align: center;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin: 0 15px;
}

nav ul li a {
    color: black;
    text-decoration: none;
    font-size: 18px;
}

nav ul li a:hover {
    text-decoration: underline;
}

/* Adjust the body and content to account for the fixed nav bar */
body {
    margin-top: 50px; /* Make space for the navbar */
}

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #005f73;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .image-container {
            width: 200px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }
        .image-container h3 {
            margin: 10px;
            color: #333;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Bali, Indonesia Gallery</h1>


    <div class="gallery">
    


        <img src="Balii.jpg" width="300px">
        <img src="Bali3.jpg" width="300px">
        <img src="Bali4.jpg" width="300px">
        <img src="Bali6.jpg" width="300px">
        <img src="Bali7.jpg" width="300px">
        <img src="Bali8.jpg" width="300px">
        <img src="Bali9.jpg" width="300px">
        <img src="Bali10.jpg" width="300px">
        <img src="Bali1.jpg" width="300px">
    
    </div>
</div>

</body>
</html>
