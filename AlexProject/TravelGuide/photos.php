
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
    <style>
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
