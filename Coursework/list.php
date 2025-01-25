<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: session.php");
    exit();
}

$publications = [];
if (($handle = fopen("publications.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $publications[] = $data;
    }
    fclose($handle);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Publication List</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Publication List</h2>
    <table>
        <tr>
            <th>Entry Number</th>
            <th>Title</th>
            <th>Authors</th>
            <th>Year</th>
        </tr>
        <?php foreach ($publications as $index => $pub): ?>
        <tr>
            <td><a href="display.php?id=<?php echo $index; ?>"><?php echo $index + 1; ?></a></td>
            <td><?php echo htmlspecialchars($pub[0]); ?></td>
            <td><?php echo htmlspecialchars($pub[1]); ?></td>
            <td><?php echo htmlspecialchars($pub[2]); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <!-- Cancel Button: Redirect to session.php -->
    <form action="session.php" method="get">
        <input type="submit" value="Cancel" />
    </form>
</body>
</html>