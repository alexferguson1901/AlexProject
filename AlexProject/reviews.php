<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'alexproject';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Safe check: Only create column if it doesn't exist
$columnCheck = $conn->query("SHOW COLUMNS FROM reviews LIKE 'avatar_path'");
if ($columnCheck->num_rows == 0) {
    $conn->query("ALTER TABLE reviews ADD COLUMN avatar_path VARCHAR(255)");
}

// ✅ Fetch reviews with avatar
$reviews_query = "SELECT user_name, rating, comment, avatar_path FROM reviews ORDER BY id DESC";
$reviews_result = $conn->query($reviews_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reviews Page</title>
    <style>
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
        body {
            margin-top: 50px;
            font-family: Arial, sans-serif;
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
        .review-header {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .review-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .review h4 {
            margin: 0;
            color: #333;
        }
        .review p {
            margin: 10px 0;
        }
        #response {
            margin-top: 10px;
        }
    </style>
</head>
<body>

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
            echo isset($_SESSION['user']) 
                ? "Hi, " . htmlspecialchars($_SESSION['user']) . "!"
                : "<a href='users.php'>Log in</a>";
            ?>
        </li>
    </ul>
</nav>

<div class="container">
    <h1>User Reviews</h1>

    <h2>Submit Your Review</h2>
    <form id="reviewForm">
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
        <button type="submit">Submit Review</button>
    </form>

    <div id="response"></div>

    <hr>
    <h2>All Reviews</h2>
    <?php
    if ($reviews_result->num_rows > 0) {
        while ($review = $reviews_result->fetch_assoc()) {
            $avatarPath = !empty($review['avatar_path']) && file_exists($review['avatar_path']) 
                ? $review['avatar_path']
                : 'default-avatar.png';

            echo "<div class='review'>";
            echo "<div class='review-header'>";
            echo "<img src='" . htmlspecialchars($avatarPath) . "' alt='Avatar'>";
            echo "<h4>" . htmlspecialchars($review['user_name']) . " - Rating: " . htmlspecialchars($review['rating']) . "/5</h4>";
            echo "</div>";
            echo "<p>" . nl2br(htmlspecialchars($review['comment'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No reviews yet. Be the first to review!</p>";
    }
    ?>
</div>

<script>
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('submit_review.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const responseBox = document.getElementById('response');
        responseBox.style.color = data.status === 'success' ? 'green' : 'red';
        responseBox.innerText = data.message;
        if (data.status === 'success') this.reset();
    })
    .catch(error => {
        document.getElementById('response').innerText = 'Error: ' + error;
    });
});
</script>

</body>
</html>
