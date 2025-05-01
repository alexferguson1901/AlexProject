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

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS saved_destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    destination_name VARCHAR(255),
    description TEXT
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['destination_name'])) {
    header('Content-Type: application/json');

    if (!isset($_SESSION['user'])) {
        echo json_encode(['status' => 'error', 'message' => 'You must be logged in to save destinations.']);
        exit();
    }

    $username = $_SESSION['user'];
    $destination = trim($_POST['destination_name']);
    $description = trim($_POST['description']);

    if (empty($destination) || empty($description)) {
        echo json_encode(['status' => 'error', 'message' => 'Incomplete data.']);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO saved_destinations (username, destination_name, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $destination, $description);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Destination saved!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save.']);
    }
    $stmt->close();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Destinations Page</title>
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
            width: 80%;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .destination {
            margin-bottom: 40px;
        }
        h3 {
            margin-bottom: 10px;
        }
        img {
            max-width: 100%;
            border-radius: 10px;
        }
        button {
            background-color: #005f73;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Cookie popup styles */
        #cookiePopup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    width: 80%;
    max-width: 400px;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
    z-index: 10000;
    display: none;
    text-align: center;
}

#cookiePopup p {
    font-size: 14px;
    margin-bottom: 15px;
    color: #333;
}

#cookiePopup button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
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
    <center><h1>Indonesia Bali Coastal Travel Guide</h1></center>

    <?php
    $spots = [
        ["Legian Beach", "LegianBeach.jpg", "Legian Beach is a lively destination known for its golden sand, beautiful sunsets, and great surfing waves. Located between Kuta and Seminyak, it offers a perfect mix of relaxation and vibrant nightlife, with beachside cafes, shops, and entertainment options.\n\nHere are some activity ideas to do near the area:\nSurfing: Legian Beach is famous for its consistent waves, making it perfect for surfers of all levels.\nBeach Clubs: Enjoy relaxing at beachfront cafes and bars with live music, perfect for a sunset view.\nShopping: Explore the nearby Legian street markets for souvenirs, clothes, and local handicrafts.\nMassage and Spas: Many spas are located along Legian Beach for a relaxing treatment after a day at the beach.\nNightlife: The Legian area has a vibrant nightlife with bars, clubs, and restaurants."],
        ["Padma Beach", "PadmaBeach.jpg", "Padma Beach is a peaceful stretch of sand located in Legian, Bali. Known for its calm waters and beautiful sunset views, it’s perfect for swimming, sunbathing, and leisurely walks along the shore. The beach is also home to upscale resorts, making it a relaxing escape with easy access to local amenities.\nHere are some activity ideas to do near the area:\nSurfing: Like Legian, Padma Beach also offers great surfing conditions.\nRelaxing on the Beach: Less crowded than other beaches.\nWalks and Cycling: Rent a bicycle along the beach path.\nSpa and Wellness: Enjoy luxury spa facilities nearby."],
        ["Balangan Beach", "BalanganBeach.jpg", "Balangan Beach is a beautiful, serene spot located in southern Bali. Known for its golden sand, clear turquoise waters, and stunning cliffside views, it’s a paradise for surfers and beach lovers alike.\nSurfing: Famous for world-class surf breaks.\nSunbathing: Less crowded and peaceful.\nBeachfront Cafes: Try local seafood.\nSnorkeling: Great for shallow water exploration."],
        ["Pantai Nusadua", "PantaiNusadua.jpg", "Pantai Nusa Dua is a pristine, white-sand beach in Bali's luxury resort area.\nWater Sports: Jet-skiing, parasailing, banana boats.\nSwimming: Calm and clear waters.\nGolfing: Nearby Bali National Golf Club.\nShopping: Visit Bali Collection Mall.\nCulture: Attend traditional Balinese performances."],
        ["Sanur Beach", "SanurBeach.jpg", "Sanur Beach is a tranquil coastal destination known for calm waters and sunrises.\nSnorkeling: Great for colorful reef views.\nCycling: 5km beachfront path.\nCultural Attractions: Le Mayeur Museum and Pura Blanjong Temple.\nWindsurfing: A favorite among water sport enthusiasts.\nRelaxing: Enjoy sunrise and soft sands."],
        ["Bias Tugel Beach", "BiasTugelBeach.jpg", "Bias Tugel Beach is a hidden gem near Padangbai.\nSnorkeling: Clear waters with coral reefs.\nSwimming: Calm, inviting water.\nPhotography: Surrounded by scenic cliffs.\nPicnic: Peaceful and secluded.\nTemples: Visit Pura Penataran Agung nearby."],
        ["Virgin Beach", "VirginBeach.jpg", "Virgin Beach (Pantai Perasi) is a hidden paradise in Karangasem.\nSnorkeling: Clear waters and marine life.\nSwimming: Calm conditions.\nSunbathing: Quiet and relaxing.\nFishing: Try local fishing or tours.\nCultural: Visit nearby fishing villages."],
        ["Amed Beach", "AmedBeach.jpg", "Amed Beach is known for black volcanic sand and clear waters.\nDiving: Rich coral reefs and marine life.\nHiking: Trek Mount Agung.\nShipwreck: Dive the Japanese wreck.\nRelaxing: Quiet beach days.\nTours: Visit Tirta Gangga Water Palace."]
    ];

    foreach ($spots as $spot) {
        $title = $spot[0];
        $image = $spot[1];
        $rawDescription = $spot[2];
        $description = nl2br(htmlspecialchars($rawDescription));

        echo "<div class='destination'>";
        echo "<h3>$title</h3>";
        echo "<img src='images/$image' alt='$title'><br><br>";
        echo "<p>$description</p>";
        echo "<button onclick=\"saveDestination('$title', `$rawDescription`)\">Save</button>";
        echo "<hr></div>";
    }
    ?>
</div>

<!-- Cookie Popup -->
<div id="cookiePopup">
    <p>This website uses cookies to enhance your browsing experience, serve personalized ads or content, and analyze our traffic. By clicking 'Accept All Cookies', you consent to our use of cookies. You can manage your preferences or withdraw your consent at any time. For more information, see our Cookie Policy and Privacy Policy.</p>
    <button onclick="acceptCookies()">Accept</button>
</div>

<script>
function saveDestination(name, desc) {
    const formData = new FormData();
    formData.append('destination_name', name);
    formData.append('description', desc);

    fetch('destinations.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => alert(data.message))
    .catch(err => alert('Error: ' + err));
}

// Cookie popup logic using sessionStorage
window.addEventListener('load', () => {
    setTimeout(() => {
        if (!sessionStorage.getItem('cookieAccepted')) {
            document.getElementById('cookiePopup').style.display = 'block';
        }
    }, 5000);
});

function acceptCookies() {
    sessionStorage.setItem('cookieAccepted', 'true');
    document.getElementById('cookiePopup').style.display = 'none';
}
</script>

</body>
</html>
