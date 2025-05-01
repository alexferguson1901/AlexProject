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

$user_name = trim($_POST['user_name'] ?? '');
$comment_type = trim($_POST['comment_type'] ?? '');
$comment = trim($_POST['comment'] ?? '');

if (empty($user_name) || empty($comment_type) || empty($comment)) {
    echo "<span style='color:red;'>All fields are required.</span>";
    exit;
}

if (!in_array($comment_type, ['tip', 'experience'])) {
    echo "<span style='color:red;'>Invalid comment type.</span>";
    exit;
}

// Determine avatar path (from session or default)
$avatar_path = isset($_SESSION['avatar']) && file_exists($_SESSION['avatar'])
    ? $_SESSION['avatar']
    : 'default-avatar.png';

// Insert comment with avatar path
$stmt = $conn->prepare("INSERT INTO comments (user_name, comment_type, comment, avatar_path) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $user_name, $comment_type, $comment, $avatar_path);

if ($stmt->execute()) {
    echo "<span style='color:green;'>Thank you for your comment!</span>";
} else {
    echo "<span style='color:red;'>Error: " . $stmt->error . "</span>";
}

$stmt->close();
$conn->close();
?>
