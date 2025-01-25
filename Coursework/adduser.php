<?php
session_start();

//enable error reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Check if the user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || intval($_SESSION['admin']) !== 1) {
    header("Location: session.php");
    exit();
}

// Get the submitted data from the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $admin = intval($_POST['admin']);

    // Validate inputs
    if (!empty($username) && !empty($password) && ($admin === 0 || $admin === 1)) {
        $csvFile = 'user.csv';

        // Append the new user details to the CSV file
        $newUser = "\"$username\",\"$password\",$admin" . PHP_EOL;
        if (file_put_contents($csvFile, $newUser, FILE_APPEND | LOCK_EX)) {
            echo "User successfully added! <a href='admin.php'>Go back</a>";
        } else {
            echo "Error: Unable to add the user. Please try again.";
        }
    } else {
        echo "Invalid input. Please ensure all fields are filled out correctly.";
    }
} else {
    echo "Invalid request method.";
}
?>