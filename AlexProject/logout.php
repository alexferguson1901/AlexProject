<?php
session_start();
session_unset();
session_destroy();
setcookie('username', '', time() - 3600, "/"); // Expire the cookie

// Redirect to users.php with logout status message
header("Location: users.php?status=loggedout");
exit();
?>
