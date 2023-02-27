

<?php


require_once('connect.php');

session_start(); //to ensure you are using same session

// $email = $_SESSION['email'];

// $deleteSQL = "DELETE FROM `client` WHERE `client`.`email` = '$email'; " ;

// // execute a query
// $statement = $conn->query($deleteSQL)->execute();;

// fetch all rows

session_destroy(); //destroy the session

header("location:index.php"); //to redirect back to "index.php" after logging out
exit();



?>