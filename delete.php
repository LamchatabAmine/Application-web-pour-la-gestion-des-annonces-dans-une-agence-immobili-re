<?php 
// connect to the database to get the PDO instance
require_once "connect.php";

if (isset($_GET['annonceId']) ){


    $annonceID = $_GET['annonceId'];

    $deleteSQL = "DELETE FROM `annonce` WHERE `annonce`.`annonceID` = $annonceID " ;
    
    // execute a query
    $statement = $conn->query($deleteSQL)->execute();;
    

    header("location:index.php");

} else{

    header("location:error.php");

}



