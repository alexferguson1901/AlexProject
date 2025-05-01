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

// Fetch all comments including avatar paths
$comments_query = "SELECT user_name, comment_type, comment, avatar_path FROM comments ORDER BY id DESC";
$comments_result = $conn->query($comments_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Comments Page</title>
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
        .comment {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .comment-header {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .comment-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .comment h4 {
            margin: 0;
            color: #333;
        }
        .comment p {
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
            if (isset($_SESSION['user'])) {
                echo "Hi, " . htmlspecialchars($_SESSION['user']) . "!";
            } else {
                echo "<a href='users.php'>Log in</a>";
            }
            ?>
        </li>
    </ul>
</nav>

<div class="container">
    <h1>Share Your Tips & Experiences</h1>

    <h2>Submit Your Comment</h2>
    <form id="commentForm">
        <div class="form-group">
            <label for="user_name">Your Name:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>
        <div class="form-group">
            <label for="comment_type">Comment Type:</label>
            <select id="comment_type" name="comment_type" required>
                <option value="tip">Tip</option>
                <option value="experience">Experience</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment">Your Comment:</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>
        </div>
        <button type="submit">Submit Comment</button>
    </form>

    <div id="response"></div>
    <hr>

    <h2>All Comments</h2>
    <?php
    if ($comments_result->num_rows > 0) {
        while ($comment = $comments_result->fetch_assoc()) {
            $avatarPath = !empty($comment['avatar_path']) && file_exists($comment['avatar_path']) 
                ? $comment['avatar_path'] 
                : 'default-avatar.png';

            echo "<div class='comment'>";
            echo "<div class='comment-header'>";
            echo "<img src='" . htmlspecialchars($avatarPath) . "' alt='Avatar'>";
            echo "<h4>" . htmlspecialchars($comment['user_name']) . " - " . ucfirst(htmlspecialchars($comment['comment_type'])) . "</h4>";
            echo "</div>";
            echo "<p>" . nl2br(htmlspecialchars($comment['comment'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments yet. Be the first to share!</p>";
    }
    ?>
</div>

<script>
document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('submit_comment.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('response').innerHTML = data;
        document.getElementById('commentForm').reset();
    })
    .catch(error => {
        document.getElementById('response').innerText = "Error: " + error;
    });
});
</script>

</body>
</html>
