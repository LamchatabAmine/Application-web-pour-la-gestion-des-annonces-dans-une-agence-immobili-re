<?php 

require_once('connect.php');



if(isset($_GET["pageId"]) ){

    $annonceID = $_GET["pageId"];
    
    $sql = "SELECT * FROM `annonce` WHERE annonceID = $annonceID " ;
    
    // execute a query
    $statement = $conn->query($sql);
    
    // fetch all rows
    $annonce = $statement->fetch(PDO::FETCH_ASSOC);


    header('Content-Type: application/json');


    echo json_encode($annonce);

}





?>