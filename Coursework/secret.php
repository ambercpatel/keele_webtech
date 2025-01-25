<?php session_start();
    if(!isset($_SESSION['loggedin'])) header("Location: session.php");
    if($_SESSION['loggedin']===FALSE) header("Location: session.php");
?>
<!DOCTYPE html>
<html><head><title>Secret Area</title></head>
<body>
    Welcome to the private message area for
    <?php echo $_SESSION['username'] ?>.
    <br>
    <p>
        You are   
    <?php
// PHP code here to retrieve messages for this user ...
if (intval($_SESSION["admin"])==1){
    echo ' an admin user therefore you can create and delete users AND submit new data <p> <a href = "admin.php"> Administrator Access </a> <p> <p> <a href = "submit.php"> Submit New Data </a> <p> <p> <a href = "list.php"> View data </a>' ;
    
}
else{
    echo "a non-admin user therefore you cannot create users or entries. <p> <a href = 'list.php'> View data </a>";
}

?>
 
</p>
<br>

<?php 
//PHP code here to retrieve messages for the user
?>
<form action="logout.php" method="POST">
<input type="submit" name="logout" value="Log out">
</form>
<p>&copy; Private Message Limited</p>
</body></html>