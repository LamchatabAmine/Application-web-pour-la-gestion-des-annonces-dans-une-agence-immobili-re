<?php 
require_once "connect.php";
session_start();







$clientEmail = $_SESSION['email'];
$selectClientID = 
"SELECT clientID FROM `client` WHERE email = '$clientEmail'";
$clientIDArr = $conn->query($selectClientID)->fetch();
$clientID = $clientIDArr['clientID'];


    $sql = "SELECT * FROM `client` WHERE clientID = $clientID" ;
    // execute a query
    $statement = $conn->query($sql);
    // fetch all rows
    $annonce = $statement->fetch(PDO::FETCH_ASSOC);


    // print_r($annonce);



    header('Content-Type: application/json');


    echo json_encode($annonce);
