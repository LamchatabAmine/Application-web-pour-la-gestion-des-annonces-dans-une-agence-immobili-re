<?php
require_once "connect.php";
session_start();

require "functions.php";

// Get client ID

$clientEmail = $_SESSION['email'];
$selectClientID = "SELECT clientID FROM `client` WHERE email = '$clientEmail'";
$clientIDArr = $conn->query($selectClientID)->fetch();
$clientID = $clientIDArr['clientID'];

not_auth_redirect();
if (isset($_POST['title']) && isset($_POST['price']) && isset($_POST['type']) && isset($_POST['category']) && isset($_POST['postalCode']) && isset($_POST['superficie']) && isset($_POST['city']) && isset($_POST['avenue']) && $_FILES['image']) {

    echo "<script>alert('workiiiiing')</script>";

    $annonceTitle = $_POST['title'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $superficie = $_POST['superficie'];
    $postalCode = $_POST['postalCode'];
    $city = $_POST['city'];
    $avenue = $_POST['avenue'];

    print_r($_POST);
    $sql = "INSERT INTO `annonce` 
    (`title`, `price`, `type`, `category`, `superficie`, `postalCode`,`city`, `avenue`, `clientID`) 
    VALUES 
    ('$annonceTitle', '$price', '$type', '$category', '$superficie', '$postalCode', '$city', '$avenue' ,'$clientID')";
    // execute a query
    $statement = $conn->query($sql);

    $LAST_INSERT_ID = $conn->query("SELECT LAST_INSERT_ID()")->fetch(); {
        if (count($_FILES['image']['name']) <= 5) {

            //Use something similar before processing files.
            $files = array_filter($_FILES['image']['name']);
            // Count the number of images files in array
            $total_count = count($_FILES['image']['name']);
            // Loop through every file
            $imgRole = 1;
            for ($i = 0; $i < $total_count; $i++) {
                //The temp file path is obtained
                $tmpFilePath = $_FILES['image']['tmp_name'][$i];
                //A file path needs to be present
                if ($tmpFilePath != "") {
                    //Setup our new file path
                    $newFilePath = "./imagesFiles/" . $_FILES['image']['name'][$i];
                    //File is uploaded to temp dir
                    if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                        //Other code goes here
                        $insertImg = "INSERT INTO `image` 
                        (`imagePath`, `imageType`, `annonceID`) 
                        VALUES 
                        ('$newFilePath', $imgRole ,'$LAST_INSERT_ID[0]');";
                        $imgRole = 0;
                        // execute a query
                        $statement = $conn->query($insertImg);
                    }
                }
            }
            // header('location: mesAnnonces.php');
        } else {
            echo "<script>alert('You can enter more than ')</>";
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>


    <link rel="stylesheet" href="style.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>

    <script defer src="validation.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>



</head>

<body>

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



    <section class="container">
        <div class="mb-5">
            <div class="container mt-5 ">
                <div class="col-md-8 col-sm-12 mx-auto">
                    <form id="createAnnonceForm" enctype="multipart/form-data">

                        <!-- Annonce title input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="Your email here" />
                        </div>
                        <!-- Price input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="price">Price</label>
                            <input type="number" id="price" name="price" class="form-control" placeholder="Enter price here" />
                        </div>
                        <!-- images -->
                        <div class="form-outline mb-4">
                            <input name="image[]" id="image" type="file" multiple="multiple" accept="image/*" onchange="limitImages(this)" required>
                        </div>
                        <!-- Type input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="type">Type:</label>
                            <select name="type" id="type" name="type">
                                <option value="appartement">Appartement</option>
                                <option value="maison">Maison</option>
                                <option value="villa">Villa</option>
                                <option value="bureau">Bureau</option>
                                <option value="terrain">Terrain</option>
                            </select>
                        </div>
                        <!-- Category input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="category">Category:</label>
                            <select name="category" name="category" id="category">

                                <option value="vente">vente</option>
                                <option value="location">loué</option>
                            </select>
                        </div>
                        <!-- superficie input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="postalCode">superficie</label>
                            <input type="number" id="postalCode" name="postalCode" class="form-control" placeholder="please entre a superficie m²" />
                        </div>
                        <!-- Postal code input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="superficie">Postal code</label>
                            <input type="number" id="superficie" name="superficie" class="form-control" placeholder="Enter code postal" />
                        </div>
                        <!-- City input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="city">City:</label>
                            <select name="city" class="form-select" name="city" id="city">
                                <option value="" selected>City</option>
                                <option value="tanger">Tanger</option>
                                <option value="Béni Mellal">Béni Mellal</option>
                                <option value="Berkane">Berkane</option>
                                <option value="Casablanca">Casablanca</option>
                                <option value="El Jadida">El Jadida</option>
                                <option value="Fès">Fès</option>
                                <option value="Kénitra">Kénitra</option>
                                <option value="Khémisset">Khémisset</option>
                                <option value="Khouribga">Khouribga</option>
                                <option value="Laayoune">Laayoune</option>
                                <option value="Marrakech">Marrakech</option>
                                <option value="Meknès">Meknès</option>
                                <option value="Mohammédia">Mohammédia</option>
                                <option value="Nador">Nador</option>
                                <option value="Oujda">Oujda</option>
                                <option value="Rabat">Rabat</option>
                                <option value="Safi">Safi</option>
                                <option value="Salé">Salé</option>
                                <option value="Tanger">Tanger</option>
                                <option value="Taza">Taza</option>
                                <option value="Témara">Témara</option>
                                <option value="Tétouan">Tétouan</option>
                            </select>
                        </div>
                        <!-- avenue input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="avenavenueue">
                                avenue
                            </label>
                            <input type="text" id="avenue" name="avenue" class="form-control" placeholder="Your avenue here" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                                <label class="form-check-label" for="form2Example3">
                                    Remember me
                                </label>
                            </div>
                            <a href="#!" class="text-body">Forgot password?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem">
                                Create annonce
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


</body>

</html>