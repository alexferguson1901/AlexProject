<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'alexproject';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $user_name = htmlspecialchars($_POST['user_name']);
    $rating = intval($_POST['rating']);
    $comment = htmlspecialchars($_POST['comment']);
    
 
    $sql = "INSERT INTO reviews (user_name, rating, comment) VALUES ('$user_name', '$rating', '$comment')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Thank you for your review!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}


$reviews_query = "SELECT user_name, rating, comment FROM reviews ORDER BY id DESC";
$reviews_result = $conn->query($reviews_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Reviews Page</title>
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
        .form-group {
            margin: 20px 0;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #005f73;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .review {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .review h4 {
            margin: 0;
            color: #333;
        }
        .review p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>User Reviews</h1>
    

    <h2>Submit Your Review</h2>
    <form method="POST" action="reviews.php">
        <div class="form-group">
            <label for="user_name">Your Name:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>
        
        <div class="form-group">
            <label for="rating">Rating:</label>
            <select id="rating" name="rating" required>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="comment">Your Review:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
        </div>
        
        <button type="submit" name="submit_review">Submit Review</button>
    </form>

    <hr>
    

    <h2>All Reviews</h2>
    <?php
    if ($reviews_result->num_rows > 0) {
        while ($review = $reviews_result->fetch_assoc()) {
            echo "<div class='review'>";
            echo "<h4>" . htmlspecialchars($review['user_name']) . " - Rating: " . htmlspecialchars($review['rating']) . "/5</h4>";
            echo "<p>" . nl2br(htmlspecialchars($review['comment'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No reviews yet. Be the first to review!</p>";
    }
    ?>

</div>

<?php
$conn->close();
?>

</body>
</html>
