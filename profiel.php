<?php
require_once "connect.php";
session_start();

require "functions.php";
not_auth_redirect();

$clientEmail = $_SESSION['email'];
$selectClientID = "SELECT clientID FROM `client` WHERE email = '$clientEmail'";
$clientIDArr = $conn->query($selectClientID)->fetch();
$clientID = $clientIDArr['clientID'];



if ($_SERVER['REQUEST_METHOD'] == 'POST') :

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashPass = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE `client` 
    SET `firstName` = '$firstName', `lastName` = '$lastName', `phone` = $phone, `email` = '$email', `password` = '$hashPass'  
    WHERE `client`.`clientID` = $clientID;";
    // execute a query
    $statement = $conn->query($sql);


    $image = $_FILES["fileToUpload"];

    $imageName = $_FILES["fileToUpload"]["name"];
    $imageType = $_FILES["fileToUpload"]["type"];
    $imageTmpName = $_FILES["fileToUpload"]["tmp_name"];
    $imageSize = $_FILES["fileToUpload"]["size"];
    $imageError = $_FILES["fileToUpload"]["error"];

    $errors = 1;


    $extension = array('jpg', 'jpeg', 'png', 'gif');



    $tmp = explode('.', $imageName);
    $imageExtension = strtolower(end($tmp));


    if ($imageError == 4) :

    else :

        if (!in_array($imageExtension, $extension)) {

            $errors = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 10000000) {

            $errors = 0;
        }
        if ($errors == 0) {


            // echo "Sorry, your file was not uploaded.";
        } else {
            move_uploaded_file(
                $imageTmpName,
                __DIR__ . '\profile\\' . $imageName
            );
            $sql = "UPDATE `client` SET `profielPic` = '$imageName' 
        WHERE `client`.`clientID` = $clientID;";
            $statement = $conn->query($sql);
        }


    endif;


endif;











?>


























<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js">


    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profiel.css">



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

    <div class="container rounded bg-white mt-5 mb-5">

        <div class="row">
            <div class="col-md-3 ">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5 img-profile">
                        <?php
                        $sql = "SELECT profielPic FROM client WHERE  clientID = '$clientID'";
                        $photoProfile = $conn->query($sql)->fetch();
                        $profiel = $photoProfile[0];
                        ?>
                        <img class="rounded-circle mt-5" id="output" width="150px" src="profile/<?php echo $profiel; ?>">

                        <div class="image-upload">
                            <label for="fileToUpload">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </label>
                            <input type="file" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)" style="display:none" />

                        </div>
                        <span class="font-weight-bold mt-2">Edogaru</span>
                        <span class="text-black-50">edogaru@mail.com.my</span>
                    </div>
            </div>


            <div class="col-md-5 border-right border-left">

                <div class="p-3 py-5">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="labels">First Name</label>
                            <input type="text" name="firstName" id="firstName" class="form-control" value="" required>
                        </div>
                        <div class="col-md-6">
                            <label class="labels">Last Name</label>
                            <input type="text" name="lastName" id="lastName" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Mobile Number</label>
                            <input type="number" id="phone" name="phone" class="form-control" value="" required>
                        </div>

                        <div class="col-md-12">
                            <label class="labels">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">New password</label>
                            <input type="password" name="password" id="password" class="form-control" value="" required>
                        </div>

                        <div class="col-md-12">
                            <label class="labels">Confirm password</label>
                            <input type="password" class="form-control" value="" required>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <input class="btn btn-primary profile-button" type="submit" value="Save Profile">
                    </div>

                    </form>

                </div>

            </div>

        </div>

    </div>


















    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>

    <script src="json.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/ad59909c53.js" crossorigin="anonymous"></script>

</body>

</html>