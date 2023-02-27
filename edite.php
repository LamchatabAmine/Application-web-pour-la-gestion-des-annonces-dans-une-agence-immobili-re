<?php 
require "connect.php";


// echo "<pre>";

// print_r($_GET);


// echo "</pre>";



$title  = $_GET['annonceName'];
$price = $_GET['announcePrice'];
$superficie = $_GET['superficie'];
$category = $_GET['category']; 
$type = $_GET['type']; 
$city = $_GET['city'];
$avenue = $_GET['avenue'];
$publicationDate = $_GET['announceDate'];
$id = $_GET['id'];

    $sql = "UPDATE `annonce` 
    SET `title` = '$title ', `price` = '$price', `superficie` = '$superficie', `city` = '$city', `avenue` = '$avenue', 
    `publicationDate` = '$publicationDate', `type` = '$type',`category` = '$category'
    
    WHERE `annonce`.`annonceID` = $id; ";

    
    
    // execute a query
    $statement = $conn->query($sql)->execute();
    
    // fetch all rows
    header("location:mesAnonnces.php");

