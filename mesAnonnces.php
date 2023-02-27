<?php
require_once "connect.php";
session_start();

require "functions.php";
not_auth_redirect();

$clientEmail = $_SESSION['email'];
// select clientID for select annonces client;
$selectClientID = "SELECT clientID  FROM `client` WHERE email = '$clientEmail'";
$clientIDArr = $conn->query($selectClientID)->fetch();
$clientID = $clientIDArr['clientID'];

// 
// $sql = "SELECT * FROM `annonce` WHERE clientID = $clientID ;";
// // execute a query
// $statement = $conn->query($sql);
// $annonce = $statement->fetchAll(PDO::FETCH_ASSOC);




// .
// $selectAnnonceID = "SELECT annonceID FROM annonce WHERE clientID = $clientID;";
// // fetch a query
// $annonceIDArr = $conn->query($selectAnnonceID)->fetch();
// $annonceID = $annonceIDArr[0];




$sql = "SELECT annonce.annonceID, annonce.clientID ,title, price, publicationDate, type, category, superficie, postalCode, city, avenue, image.imagePath FROM annonce JOIN image WHERE annonce.annonceID = image.annonceID AND image.imageType = 1 AND annonce.clientID = $clientID; ";
$statement = $conn->query($sql);
$annonce = $statement->fetchAll(PDO::FETCH_ASSOC);




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


  <link rel="stylesheet" href="profiel.css">
  <link rel="stylesheet" href="style.css">




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
            Mes Annonces
          </h1>
        </div>
      </div>
    </div>



  </header>




  <section class="container mb-3">

    <div class="row justify-content-between container  mt-5">
      <?php

      foreach ($annonce as $key => $value) {

      ?>
        <div class="card mt-3 mx-auto .bg" style="width: 20rem;">
          <div class="img-zoom">
            <img src="<?php echo $value['imagePath']; ?>" class="card-img-top" alt="image" style="overflow: hidden;">
          </div>

          <div class="card-body">
            <div class="type">
              <span><span><?php echo $value['category']; ?></span></span>
            </div>
            <div class="card-title mt-2">
              <span><?php echo $value['title']; ?></span>
            </div>
            <p class="card-text mt-2">
              <?php echo $value['city'] . ", " . $value['avenue']; ?>
            </p>
            <p class="card-text">
              <?php
              echo $value['type'] . ", " .
                $value['superficie'] . "m²";
              ?>
            </p>
            <div class="card-price mt-2">
              <?php echo $value['price'] . "Dhs"; ?>
            </div>

            <div>
              <a class="btn  mt-3 icon-modal" data-bs-toggle="modal" data-bs-target="#EditAnnounce">
                <i class="fa-solid fa-pen-to-square" onclick="editAnnonce(<?php echo $value['annonceID']; ?>)"></i></a>
              <a class="btn  mt-3 icon-modal" data-bs-toggle="modal" data-bs-target="#deleteAnnonce">
                <i class="fa-solid fa-trash" onclick="deleteAnnonce(<?php echo $value['annonceID']; ?>)"></i></a>
            </div>
          </div>

          <div class=" card-footer">
            <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
              <button type="submit" class="btn more btn-success">
                more details
              </button>
            </a>
          </div>
        </div>

      <?php


      }

      ?>

    </div>

  </section>































  <!-- Modal Edite-->
  <div class="modal fade" id="EditAnnounce" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody">

          <form action="edite.php" method="GET">
            <div class="mb-3">
              <label for="annonceName" class="col-form-label">Announce Title :</label>
              <input type="text" name="annonceName" class="form-control" id="announce-Title" required>
            </div>
            <div class="mb-3">
              <label for="announcePrice" class="col-form-label">Announce Price :</label>
              <input type="number" name="announcePrice" class="form-control" min="0" id="announce-price" required>
            </div>

            <div class="mb-3">
              <!-- <div class="mb-3">
          <label for="recipient-name"  class="col-form-label">Announce Picture :</label>
          <input type="text" name="annonceImage" class="form-control" id="announce-image" placeholder="Type URL here.." required>
        </div> -->
              <div class="mb-3">
                <label for="superficie" class="col-form-label">superficie :</label>
                <input type="number" name="superficie" class="form-control" min="0" id="superficie" required>
              </div>
              <div class="mb-3">
                <label for="type " class="col-form-label">Announce type :</label>
                <select class="form-select input-xs" name="type" id="type " required>
                  <!-- <option selected>type </option> -->
                  <option value="maison">maison</option>
                  <option value="appartement">appartement</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="category" class="col-form-label">Announce category :</label>
                <select class="form-select input-xs" name="category" id="category" required>
                  <!-- <option selected>category</option> -->
                  <option value="loca">loca</option>
                  <option value="vendre">vendre</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="city" class="col-form-label">city :</label>
                <select name="city" class="form-select" id="inputGroupSelect01">
                  <option selected value="">City</option>
                  <option value="Agadir">Agadir</option>
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
                  <option value="Kénitra">Kénitra</option>
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
              <div class="mb-3">
                <label for="avenue" class="col-form-label">avenue :</label>
                <input type="text" name="avenue" class="form-control" id="avenue" required>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Annoce images :</label>
                <input class="form-control" name="image[]" id="image" type="file" multiple="multiple" accept="image/*" onchange="limitImages(this)" required>
              </div>

              <!-- <div class="mb-3">
            <label for="announceDate" class="col-form-label">Announce Date:</label>
            <input type="text" name="announceDate" class="form-control" min="0" id="announce-date" required>
        </div> -->

              <input type="hidden" name="id" id="hiddenId" value="">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>

              <input type="submit" name="save" class="btn btn-primary botton" value="Save">
            </div>
        </div>

        </form>

      </div>
    </div>
  </div>
  </div>
































  <!-- modal delete  -->
  <div class="modal fade" id="deleteAnnonce" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Annonce</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">are u sure</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
          <a type="button" id="deleteBtn" href="" class="btn btn-primary botton">Delete</a>
        </div>
      </div>
    </div>
  </div>






















  <!--=========== footer  ===========-->
  <footer class="">
    <div class="media container d-flex justify-content-between">
      <p class="text-light">Copyright © 2013. All Rights Reserved.</p>
      <a href="#"> Go to top</a>
    </div>
  </footer>


  <script src="script.js"></script>


  <script src="https://kit.fontawesome.com/eec721374e.js" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
  </script>


</body>

</html>