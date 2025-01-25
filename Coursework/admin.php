<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: session.php");
    exit();
}

if (intval($_SESSION['admin']) !== 1) {
    header("Location: session.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>. Use the form below to add a new user.</p>

    <!-- Add User Form -->
    <form action="adduser.php" method="POST">
        <label for="username">New Username:</label><br>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">New Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <label for="admin">Admin Status:</label><br>
        <select name="admin" id="admin" required>
            <option value="0">Non-Admin</option>
        </select><br><br>

        <input type="submit" value="Add User">
    </form>

    <!-- Cancel Button: Redirect to session.php -->
    <form action="session.php" method="get">
        <input type="submit" value="Cancel" />
    </form>

</body>
</html>