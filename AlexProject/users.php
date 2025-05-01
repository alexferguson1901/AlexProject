<?php 
if (isset($_GET['status']) && $_GET['status'] === 'loggedout') {
    echo "<p style='color: green;'>You have been successfully logged out.</p>";
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Account</title>
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
            width: 400px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .toggle-form {
            text-align: center;
            margin-top: 10px;
            cursor: pointer;
            color: #007BFF;
        }

        #logout {
            text-align: right;
            margin-bottom: 10px;
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
    <div id="logout" style="display:none;">
        <form method="post" action="logout.php">
            <button type="submit">Log Out</button>
        </form>
    </div>

    <h2 id="formTitle">Log In</h2>

    <form id="userForm">
        <div id="nameFields" style="display: none;">
            <input type="text" name="name" placeholder="First Name">
            <input type="text" name="surname" placeholder="Surname">
        </div>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" style="display: none;">
        <input type="hidden" name="action" value="login">
        <button type="submit">Submit</button>
    </form>

    <div class="toggle-form" onclick="toggleForm()">Don't have an account? Create one</div>
    <div id="response"></div>
</div>

<script>
let isLogin = true;

function toggleForm() {
    isLogin = !isLogin;
    document.getElementById('formTitle').innerText = isLogin ? 'Log In' : 'Create Account';
    document.querySelector('input[name="action"]').value = isLogin ? 'login' : 'register';
    document.querySelector('input[name="confirm_password"]').style.display = isLogin ? 'none' : 'block';
    document.getElementById('nameFields').style.display = isLogin ? 'none' : 'block';
    document.querySelector('.toggle-form').innerText = isLogin
        ? "Don't have an account? Create one"
        : "Already have an account? Log in";
}

// 🌐 Handle form submission using Fetch API (Requirement 2)
document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('createUser.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById('response').innerHTML = data;
        if (data.includes('logged in')) {
            document.getElementById('logout').style.display = 'block';
            location.reload(); // refresh to show session
        }
    })
    .catch(err => {
        document.getElementById('response').innerHTML = 'Fetch error: ' + err;
    });
});
</script>

</body>
</html>
