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

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Fetch avatar from DB if not already in session
if (!isset($_SESSION['avatar'])) {
    $stmt = $conn->prepare("SELECT avatar_path FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $stmt->bind_result($storedAvatar);
    if ($stmt->fetch() && !empty($storedAvatar) && file_exists($storedAvatar)) {
        $_SESSION['avatar'] = $storedAvatar;
    } else {
        $_SESSION['avatar'] = 'default-avatar.png';
    }
    $stmt->close();
}

// Unsaving via fetch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unsave_id'])) {
    $stmt = $conn->prepare("DELETE FROM saved_destinations WHERE id = ? AND username = ?");
    $stmt->bind_param("is", $_POST['unsave_id'], $_SESSION['user']);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Destination unsaved.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unsave failed.']);
    }
    $stmt->close();
    exit;
}

// Avatar Upload + Save to DB
$avatarDir = 'avatars/';
if (!file_exists($avatarDir)) {
    mkdir($avatarDir, 0777, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    header('Content-Type: application/json');
    $file = $_FILES['avatar'];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload error.']);
        exit;
    }
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type.']);
        exit;
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'File too large (max 2MB).']);
        exit;
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $safeName = preg_replace("/[^a-zA-Z0-9]/", "_", $_SESSION['user']);
    $filename = $avatarDir . $safeName . '.' . $ext;

    if (move_uploaded_file($file['tmp_name'], $filename)) {
        $_SESSION['avatar'] = $filename;
        $update = $conn->prepare("UPDATE users SET avatar_path = ? WHERE username = ?");
        $update->bind_param("ss", $filename, $_SESSION['user']);
        $update->execute();
        $update->close();
        echo json_encode(['status' => 'success', 'message' => 'Avatar updated!', 'avatar' => $filename]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to move file.']);
    }
    exit;
}

$avatarPath = isset($_SESSION['avatar']) && file_exists($_SESSION['avatar']) ? $_SESSION['avatar'] : 'default-avatar.png';

$destinations = [];
$stmt = $conn->prepare("SELECT id, destination_name, description FROM saved_destinations WHERE username = ?");
$stmt->bind_param("s", $_SESSION['user']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $destinations[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Profile</title>
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
            font-family: Arial, sans-serif;
            margin-top: 70px;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            width: 600px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        img.avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        button {
            padding: 8px 12px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        #favorites {
            margin-top: 20px;
            display: none;
            text-align: left;
        }
        .favorite {
            border-top: 1px solid #ccc;
            padding: 10px 0;
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
            <?php echo "Hi, " . htmlspecialchars($_SESSION['user']) . "!"; ?>
        </li>
    </ul>
</nav>

<div class="container">
    <h2>Your Profile</h2>
    <img id="avatarImage" src="<?php echo $avatarPath; ?>" alt="Avatar" class="avatar">
    <form id="avatarForm" enctype="multipart/form-data">
        <input type="file" name="avatar" accept="image/*" required>
        <button type="submit">Upload Avatar</button>
    </form>
    <div id="response"></div>
    <form method="post" action="logout.php">
        <button type="submit">Log Out</button>
    </form>

    <button onclick="toggleFavorites()">Favorites</button>

    <div id="favorites">
        <h3>Your Saved Destinations</h3>
        <?php foreach ($destinations as $dest): ?>
            <div class="favorite">
                <h4><?= htmlspecialchars($dest['destination_name']) ?></h4>
                <p><?= nl2br(htmlspecialchars($dest['description'])) ?></p>
                <form onsubmit="unsaveDestination(event, <?= $dest['id'] ?>)">
                    <button type="submit">Unsave</button>
                </form>
            </div>
        <?php endforeach; ?>
        <?php if (empty($destinations)) echo "<p>You haven't saved any destinations yet.</p>"; ?>
    </div>
</div>

<script>
document.getElementById('avatarForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('profile.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const resBox = document.getElementById('response');
        resBox.style.color = data.status === 'success' ? 'green' : 'red';
        resBox.innerText = data.message;
        if (data.status === 'success') {
            document.getElementById('avatarImage').src = data.avatar + '?v=' + new Date().getTime();
        }
    })
    .catch(error => {
        document.getElementById('response').innerText = 'Error: ' + error;
    });
});

function toggleFavorites() {
    const fav = document.getElementById('favorites');
    fav.style.display = fav.style.display === 'none' ? 'block' : 'none';
}

function unsaveDestination(e, id) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('unsave_id', id);
    fetch('profile.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.status === 'success') location.reload();
    });
}
</script>

</body>
</html>
