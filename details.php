<?php
require "connect.php";

require "functions.php";
session_start();

if (isset($_GET["pageId"])) {

    $annonceID = $_GET["pageId"];

    $sqlAnnonceID = "SELECT * FROM `annonce` WHERE annonceID = $annonceID";

    // execute a query
    $statement = $conn->query($sqlAnnonceID);

    // fetch all rows
    $annonce = $statement->fetch(PDO::FETCH_ASSOC);

    // $clientID = "SELECT annonce.clientID  FROM annonce WHERE annonce.annonceID = $annonceID";
    $clientEmail = $_SESSION["email"];
    $selectClientID = "SELECT clientID  FROM client WHERE email = '$clientEmail'";
    $clientIDArr = $conn->query($selectClientID)->fetch();
    $clientID = $clientIDArr['clientID'];

    $sqlGetImages = "SELECT annonce.annonceID, annonce.clientID ,title, price, publicationDate, type, category, superficie, postalCode, city, avenue, image.imagePath FROM annonce JOIN image WHERE annonce.annonceID = $annonceID AND annonce.annonceID = image.annonceID;
    ";

    // execute a query
    $result = $conn->query($sqlGetImages);

    // fetch all rows
    $images = $result->fetchAll();







?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">


        <title>Edit page</title>
    </head>

    <body>



        <header class="hero page-inner overlay" style="
        background-image: 
        url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=996&q=80'); background-size: cover;height: 35vh;">
            <nav id="nav" class="navbar navbar-expand-md d-flex justify-content-between">
                <div class="container-md nav-position">

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <a class="navbar-brand text-light fs-3 d-none d-md-block" href="index.php">SOA</a>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                            </li>
                        </ul>
                    </div>


                    <div class="justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php

                            if (auth()) {
                                $clientEmail = $_SESSION['email'];
                                // select clientID for select annonces client;
                                $selectClientID = "SELECT clientID  FROM `client` WHERE email = '$clientEmail'";
                                $clientIDArr = $conn->query($selectClientID)->fetch();
                                $clientID = $clientIDArr['clientID'];
                            ?>
                                <!-- display compte the client -->
                                <div>
                                    <a href="createAnnonce.php" class="btn btn-success text-uppercase text-white" style="margin-right: 10px; width: 190px;">
                                        <svg class="av-icon" height="18" width="18" style="fill: currentcolor; stroke: currentcolor; stroke-width: 0px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-labelledby="AddTitleID">
                                            <title id="AddTitleID">Add Icon</title>
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6z"></path>
                                        </svg>
                                        déposer une annonce</a>
                                </div>

                                <div class="dropdown">

                                    <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="height: 9px; ">
                                        <?php
                                        $sql = "SELECT profielPic FROM client WHERE  clientID = '$clientID'";
                                        $photoProfile = $conn->query($sql)->fetch();
                                        $profiel = $photoProfile[0];

                                        if ($profiel > 0) {

                                        ?>
                                            <img class="rounded-circle mt-4" id="output" width="38px" src="profile/<?php echo $profiel; ?>" alt="pohotProfiel" loading="lazy">
                                        <?php
                                        } else {
                                        ?>
                                            <img class="rounded-circle mt-4" id="output" width="38px" src="https://static.thenounproject.com/png/1074726-200.png" alt="pohotProfiel" loading="lazy">
                                        <?php
                                        }
                                        ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end bg-dark" aria-labelledby="navbarDropdownMenuAvatar">
                                        <li>
                                            <a class="dropdown-item item" href="mesAnonnces.php">Mes annoces</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item item" href="profiel.php">My profile</a>
                                        </li>
                                        <!-- <li>
                                    <a class="dropdown-item item" href="#">Settings</a>
                                </li> -->
                                        <li>
                                            <a class="dropdown-item item" href="logout.php">Logout</a>
                                        </li>
                                    </ul>
                                </div>

                            <?php
                            } else {
                            ?>
                                <!-- diplay nav to connect -->
                                <li class="" style="margin-right: 10px;">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#sign-in-up">
                                        SE CONNECT</a>
                                </li>

                                <div>
                                    <a class="btn btn-success text-uppercase text-white" data-bs-toggle="modal" data-bs-target="#sign-in-up">
                                        <svg class="av-icon" height="18" width="18" style="fill: currentcolor; stroke: currentcolor; stroke-width: 0px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-labelledby="AddTitleID">
                                            <title id="AddTitleID">Add Icon</title>
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6z"></path>
                                        </svg>
                                        déposer une annonce</a>
                                </div>
                            <?php
                            }
                            ?>



                        </ul>
                    </div>
                </div>


            </nav>




            <div class="container slideTop justify-content-center align-items-center">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12 col-md-9 text-center mt-5">
                        <h1 class="mt-5 text-light">
                            Annonce
                        </h1>
                    </div>
                </div>
            </div>



        </header>



        <div class="row container mx-auto">
            <div id="carousel" class="col-md-6 py-2 text-center mt-5">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($images as $key => $value) : ?>
                            <div class="carousel-item active">
                                <img src="<?php echo $value['imagePath'] ?>" class="d-block w-100" alt="...">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-md-6 py-2 ">
                <div class="container rounded bg-white mt-5 mb-5">
                    <div class=" border-right border-left">
                        <div>
                            <div class="col-md-12">
                                <h5 class="labels">Titre</h5>
                                <p><?php echo $images[0]["title"]; ?></p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5 class="h5s">Superficie</h5>
                                <p><?php echo $images[0]["superficie"]; ?> m²</p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5 class="h5s">Prix</h5>
                                <p><?php echo $images[0]["price"]; ?> Dhs</p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5 class="h5s">Avenue</h5>
                                <p><?php echo $images[0]["avenue"] ?></p>
                                <hr>
                                <h5 class="h5s">City</h5>
                                <p><?php echo $images[0]["city"] ?></p>
                                <hr>
                                <h5 class="h5s">Code postal</h5>
                                <p><?php echo $images[0]["postalCode"] ?></p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5 class="h5s">Catégorie</h5>
                                <p><?php echo $images[0]["category"] ?></p>
                            </div>
                            <hr>
                            <div class="col-md-12">
                                <h5 class="h5s">Type</h5>
                                <p><?php echo $images[0]["type"] ?></p>
                            </div>






                        </div>
                    </div>
                </div>

            </div>
        </div>












        <!--=========== footer  ===========-->
        <footer class="">
            <div class="media container d-flex justify-content-between">
                <p class="text-light">Copyright © 2023. All Rights Reserved.</p>
                <a href="#"> Go to top</a>
            </div>
        </footer>





        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
        </script>
    </body>

    </html>



<?php
}
?>