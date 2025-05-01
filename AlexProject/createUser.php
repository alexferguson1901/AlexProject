<?php
// Show errors (development only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include('db.php'); // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') {
        // Gather form data
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        // Basic validation
        if (empty($name) || empty($surname) || empty($email) || empty($password) || empty($confirm)) {
            echo "All fields are required.";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format.";
            exit;
        }

        if (strlen($password) < 6) {
            echo "Password must be at least 6 characters.";
            exit;
        }

        if ($password !== $confirm) {
            echo "Passwords do not match.";
            exit;
        }

        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $fullName = $name . ' ' . $surname;

        try {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->rowCount() > 0) {
                echo "Email is already registered.";
                exit;
            }

            // Insert user securely
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $fullName,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);

            // Start session and set cookie
            $_SESSION['user'] = $fullName;
            setcookie('username', $fullName, time() + (86400 * 30), "/");

            echo "Account created and logged in as <strong>$fullName</strong>.";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if ($action === 'login') {
        // Gather login input
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            echo "Please enter email and password.";
            exit;
        }

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify hashed password
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                setcookie('username', $user['username'], time() + (86400 * 30), "/");
                echo "Logged in as <strong>{$user['username']}</strong>.";
            } else {
                echo "Invalid email or password.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
