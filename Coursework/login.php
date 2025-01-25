<?php
session_start();
if (($handle = fopen("user.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $user[$data[0]] = array("password"=>$data[1], "admin"=>$data[2]);
    }
    fclose($handle);
    }
    /* Get the data entered on the form: */
    $u = $_POST['username']; $p = $_POST['password'];
    /* Check it against our 'database': */
    if(isset($user[$u]) and $user[$u]['password'] == $p ) {
    $_SESSION['loggedin']=TRUE;
    $_SESSION['username']=$u;
    $_SESSION["admin"] = $user[$u]["admin"];
    header("Location: secret.php");
    }
    else{
    header("Location: session.php");
    }
?>

