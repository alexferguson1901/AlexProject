<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'alexproject';


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_comment'])) {
    $user_name = htmlspecialchars($_POST['user_name']);
    $comment_type = htmlspecialchars($_POST['comment_type']);
    $comment = htmlspecialchars($_POST['comment']);
    
    
    $sql = "INSERT INTO comments (user_name, comment_type, comment) VALUES ('$user_name', '$comment_type', '$comment')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p>Thank you for your comment!</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}


$comments_query = "SELECT user_name, comment_type, comment FROM comments ORDER BY tip_id DESC";
$comments_result = $conn->query($comments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
 
    <title>Comments Page</title>
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
        .comment {
            margin: 20px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .comment h4 {
            margin: 0;
            color: #333;
        }
        .comment p {
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Share Your Tips & Experiences</h1>
    
    
    <h2>Submit Your Comment</h2>
    <form method="POST" action="comments.php">
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
        
        <button type="submit" name="submit_comment">Submit Comment</button>
    </form>

    <hr>
    
    
    <h2>All Comments</h2>
    <?php
    if ($comments_result->num_rows > 0) {
        while ($comment = $comments_result->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<h4>" . htmlspecialchars($comment['user_name']) . " - " . ucfirst(htmlspecialchars($comment['comment_type'])) . "</h4>";
            echo "<p>" . nl2br(htmlspecialchars($comment['comment'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments yet. Be the first to share!</p>";
    }
    ?>

</div>

<?php
$conn->close();
?>

</body>
</html>
