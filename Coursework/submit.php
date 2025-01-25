<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in and is an admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || intval($_SESSION['admin']) !== 1) {
    header("Location: session.php");
    exit();
}

// Function to sanitize input strings
function sanitize_string($string) {
    return htmlspecialchars(strip_tags($string), ENT_QUOTES, 'UTF-8');
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $title = sanitize_string($_POST['title']);
    $authors = sanitize_string($_POST['authors']);
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
    $journal = sanitize_string($_POST['journal']);
    $doi = sanitize_string($_POST['doi']);
    $school = sanitize_string($_POST['school']);

    // Perform validation
    if (empty($title)) $errors[] = "Title is required.";
    if (empty($authors)) $errors[] = "Authors are required.";
    if (!$year || $year < 1900 || $year > date("Y")) $errors[] = "Invalid year.";
    if (empty($journal)) $errors[] = "Journal is required.";
    if (empty($school)) $errors[] = "School name is required.";
    
    // Validate DOI only if provided
    if (!empty($doi) && !preg_match('/^10.\d{4,9}\/[-._;()\/:A-Z0-9]+$/i', $doi)) {
        $errors[] = "Invalid DOI format.";
    }

    if (empty($errors)) {
        $newRecord = [$title, $authors, $year, $journal, $doi, $school];
        $fp = @fopen('publications.csv', 'a');
        if ($fp === false) {
            $errors[] = "Unable to open file. Please check file permissions.";
        } else {
            if (fputcsv($fp, $newRecord) === false) {
                $errors[] = "Failed to write to file.";
            } else {
                $success = "Record added successfully.";
            }
            fclose($fp);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit New Publication</title>
</head>
<body>
    <h2>Submit New Publication</h2>
    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>
    <form method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>

        <label for="authors">Authors:</label><br>
        <input type="text" id="authors" name="authors" required><br>

        <label for="year">Year:</label><br>
        <input type="number" id="year" name="year" required><br>

        <label for="journal">Journal:</label><br>
        <input type="text" id="journal" name="journal" required><br>

        <label for="doi">DOI (optional):</label><br>
        <input type="text" id="doi" name="doi"><br>

        <label for="school">School Name:</label><br>
        <input type="text" id="school" name="school" required><br>

        <input type="submit" value="Submit">
    </form>

     <!-- Cancel Button: Redirect to session.php -->
     <form action="session.php" method="get">
        <input type="submit" value="Cancel" />
    </form>
    
</body>
</html>