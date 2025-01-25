<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: session.php");
    exit();
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    echo "Invalid record ID.";
    exit();
}

$publications = [];
if (($handle = fopen("publications.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $publications[] = $data;
    }
    fclose($handle);
}

if (!isset($publications[$id])) {
    echo "Record not found.";
    exit();
}

$publication = $publications[$id];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Publication Details</title>
</head>
<body>
    <h2>Publication Details</h2>
    <p><strong>Title:</strong> <?php echo htmlspecialchars($publication[0]); ?></p>
    <p><strong>Authors:</strong> <?php echo htmlspecialchars($publication[1]); ?></p>
    <p><strong>Year:</strong> <?php echo htmlspecialchars($publication[2]); ?></p>
    <p><strong>Journal:</strong> <?php echo htmlspecialchars($publication[3]); ?></p>
    <p><strong>DOI:</strong> <?php echo htmlspecialchars($publication[4]); ?></p>
    <p><strong>School Name:</strong> <?php echo htmlspecialchars($publication[5]); ?></p>
    <a href="list.php">Back to List</a>
</body>
</html>