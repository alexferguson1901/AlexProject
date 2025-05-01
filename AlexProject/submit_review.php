<?php
session_start();
header('Content-Type: application/json');

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'alexproject';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

$user_name = trim($_POST['user_name']);
$rating = intval($_POST['rating']);
$comment = trim($_POST['comment']);
$avatar_path = isset($_SESSION['user']) ? "avatars/" . preg_replace("/[^a-zA-Z0-9]/", "_", $_SESSION['user']) . ".jpg" : 'default-avatar.png';

if ($user_name === "" || $rating < 1 || $rating > 5 || $comment === "") {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO reviews (user_name, rating, comment, avatar_path) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $user_name, $rating, $comment, $avatar_path);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Review submitted!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to submit review.']);
}

$stmt->close();
$conn->close();