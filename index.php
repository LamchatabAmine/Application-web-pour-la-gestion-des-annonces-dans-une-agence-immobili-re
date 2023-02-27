<?php

require_once('connect.php');

session_start();
require "functions.php";

// session_destroy();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {

        $password = $_POST['password'];
        $hashPass = password_hash($password, PASSWORD_DEFAULT);

        $email = $_POST['email'];



        $signIn = "SELECT password FROM `client` WHERE email = '$email' ; ";
        $result = $conn->query($signIn)->fetch();
        $clientPass = $result['password'];




        if (password_verify($password, $hashPass)) {

            $_SESSION['email'] = $email;
        } else {
            // echo "please confirmé your information";
        };
    } elseif (isset($_POST['signUp'])) {

        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];




        $_SESSION['email'] = $email;

        $hashPass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `client` 
            (`firstName`, `lastName`, `email`, `password`, `phone`) 
            VALUES 
            ('$firstName', '$lastName', '$email', '$hashPass', $phone);";
        // execute a query
        $conn->query($sql)->fetch();
    }
}











if (isset($_GET["pageId"])) {

    $endIndex = 6 * $_GET["pageId"];

    $startIndex = $endIndex  - 6;

    // $sql = "SELECT title, type, category, publicationDate, price, city FROM annonce";

    $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
         FROM annonce
         JOIN image
         ON annonce.annonceID = image.annonceID 
         WHERE imageType = 1 
         LIMIT 6  OFFSET $startIndex;";

    $allAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // $sql = "SELECT * FROM `annonce` LIMIT 6  OFFSET $startIndex ";
    // $allAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

} else {

    $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
         FROM annonce
         JOIN image
         ON annonce.annonceID = image.annonceID 
         WHERE imageType = 1 
         LIMIT 6 OFFSET 0;";

    $allAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // $sql = 'SELECT * FROM `annonce` LIMIT 6 OFFSET 0';

    // // execute a query
    // $allAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // fetch all rows
    // $annonce = $statement->fetchAll(PDO::FETCH_ASSOC);

}

$sql = 'SELECT COUNT(*) FROM `annonce` ';

$annonceLength = $conn->query($sql)->fetch();

$pagesNum = 0;

if (($annonceLength[0] % 6) == 0) {

    $pagesNum = $annonceLength[0] / 6;
} else {

    $pagesNum = ceil($annonceLength[0] / 6);
}


?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="contact.css" />
    <link rel="stylesheet" href="sign-in-up.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

</head>

<body>



    <!-- heaedr + nav -->
    <header class="hero page-inner overlay"
        style="
    background-image: 
    url('https://images.unsplash.com/photo-1582407947304-fd86f028f716?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=996&q=80'); background-size: cover;">


        <nav id="nav" class="navbar navbar-expand-md d-flex justify-content-between">
            <div class="container-md nav-position">

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
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
                            <a href="createAnnonce.php" class="btn btn-success text-uppercase text-white"
                                style="margin-right: 10px;">
                                <svg class="av-icon" height="18" width="18"
                                    style="fill: currentcolor; stroke: currentcolor; stroke-width: 0px;"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-labelledby="AddTitleID">
                                    <title id="AddTitleID">Add Icon</title>
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6z"></path>
                                </svg>
                                déposer une annonce</a>
                        </div>

                        <div class="dropdown">

                            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#"
                                id="navbarDropdownMenuAvatar" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false" style="height: 9px; ">
                                <?php
                                    $sql = "SELECT profielPic FROM client WHERE  clientID = '$clientID'";
                                    $photoProfile = $conn->query($sql)->fetch();
                                    $profiel = $photoProfile[0];

                                    if ($profiel > 0) {

                                    ?>
                                <img class="rounded-circle mt-4" id="output" width="38px"
                                    src="profile/<?php echo $profiel; ?>" alt="pohotProfiel" loading="lazy">
                                <?php
                                    } else {
                                    ?>
                                <img class="rounded-circle mt-4" id="output" width="38px"
                                    src="https://static.thenounproject.com/png/1074726-200.png" alt="pohotProfiel"
                                    loading="lazy">
                                <?php
                                    }
                                    ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end bg-dark"
                                aria-labelledby="navbarDropdownMenuAvatar">
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
                            <a class="btn btn-success text-uppercase text-white" data-bs-toggle="modal"
                                data-bs-target="#sign-in-up">
                                <svg class="av-icon" height="18" width="18"
                                    style="fill: currentcolor; stroke: currentcolor; stroke-width: 0px;"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-labelledby="AddTitleID">
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



        <form action="index.php" method="post" class="container slideTop">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-9 text-center mt-5">
                    <div class="row justify-content-center align-items-center mb-5">
                        <h1 class="mt-5 text-light">
                            Easiest way to find your dream home
                        </h1>
                        <div class="row text-center mt-3">
                            <div class="col input-group">
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
                            <div class="col input-group">
                                <select name="category" class="form-select" id="inputGroupSelect01">
                                    <option selected value="">Category</option>
                                    <option value="location">loca</option>
                                    <option value="vente">Vente</option>
                                </select>
                            </div>
                            <div class="col input-group">
                                <input type="number" name="priceMax" min="1" class="form-control" placeholder="Max" />
                                <input type="number" name="priceMin" min="0" class="form-control" placeholder="Min" />
                            </div>
                            <div class="col input-group">
                                <select name="type" class="form-select" id="inputGroupSelect01">
                                    <option selected value="">Type</option>
                                    <option value="maison">Maison</option>
                                    <option value="viila">Villa</option>
                                    <option value="appartement">Appartement</option>
                                    <option value="bureau">Bureau</option>
                                    <option value="terrain">Terrain</option>
                                </select>
                            </div>

                            <input type="submit" name="searchAnnonces" class="btn search col" value="Search">
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </header>

    <!-- Sort -->


    <form action="">
        <div class="d-flex"></div>
    </form>



    <form method="post" action="" class="mt-5 d-flex justify-content-center ">
        <div class="d-flex justify-content-center align-items-center style">
            <p>Sort by price</p>
            <button class="iconSort" id="iconDesc" role="link" type="submit" name="sortPriceDesc">
                <span class="icon-arrow">&UpArrow;</span>
            </button>

            <button class="iconSort" id="iconAsc" role="link" type="submit" name="sortPriceAsc">
                <span class="icon-arrow">&DownArrow;</span>
            </button>
        </div>

        <div class=" d-flex justify-content-center align-items-center style">
            <p>Sort by Date</p>
            <button class="iconSort" role="link" type="submit" name="sortDateDesc">
                <span class="icon-arrow">&DownArrow;</span>
            </button>
            <button class="iconSort" role="link" type="submit" name="sortDateAsc">
                <span class="icon-arrow">&UpArrow;</span>
            </button>
        </div>

    </form>

    <?php

    if (isset($_POST['searchAnnonces'])) :
        $minPrice = $_POST['priceMin'];
        $maxPrice = $_POST['priceMax'];
        $type = $_POST['type'];
        $category = $_POST['category'];
        $city = $_POST['city'];

        // prepare SELECT statement with placeholders
        $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath FROM annonce JOIN `image`
      ON annonce.annonceID = image.annonceID WHERE imageType = 1";

        if (!empty($minPrice)) {
            $sql .= " AND price > $minPrice ";
        }
        if (!empty($maxPrice)) {
            $sql .= " AND price < $maxPrice";
        }
        if (!empty($type)) {
            $sql .= " AND `type` LIKE '$type'";
        }
        if (!empty($category)) {
            $sql .= " AND category LIKE '$category'";
        }
        if (!empty($city)) {
            $sql .= " AND city LIKE '$city'";
        }
        $filteredAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);


    ?>

    <section class="container mb-3">
        <div class="row justify-content-between container mt-4">

            <!-- <div class="bg">
            <img src="img/Contact/home.png" alt="">
            <div class="overlay">
                <h2>Check This <span>Out!</span></h2>
                <p>this is some text.</p>
            </div>
        </div> -->


            <?php
                foreach ($filteredAnnonces as $key => $value) :
                ?>
            <div class="card  mt-3 mx-auto" style="width: 20rem;">

                <div class="img-zoom">
                    <img src="<?php echo $value['imagePath'] ?>" alt="image" style="overflow: hidden;">
                </div>
                <div class="card-body">
                    <div class="type">
                        <span><?php echo  $value['category'] ?></span>
                    </div>
                    <div class="card-title mt-2"><span><?php echo $value['title'] ?></span></div>

                    <p class="card-text "><?php echo  $value['city'] ?> </p>
                    <p class="card-text "><?php echo  $value['publicationDate'] ?> </p>
                    <div class="card-price mt-2"><?php echo  $value['price'] . ' MAD' ?></div>
                </div>

                <div class="card-footer">
                    <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
                        <button type="submit" class="btn more btn-success">
                            more details
                        </button>
                    </a>
                </div>



            </div>
            <?php
                endforeach;
                ?>
        </div>

    </section>


    <!-- Sort annonces Ascendally by date -->


    <?php
    elseif (isset($_POST['sortDateAsc'])) :
        $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
        FROM annonce
        JOIN image
        ON annonce.annonceID = image.annonceID WHERE imageType = 1 ORDER BY publicationDate;";
        $sortedAnnoncesByDateAsc = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <section class="container mb-3">
        <div class="row justify-content-between container mt-4">
            <?php
                foreach ($sortedAnnoncesByDateAsc as $key => $value) :
                ?>
            <div class="card  mt-3 mx-auto" style="width: 20rem;">
                <div class="img-zoom">
                    <img src="<?php echo $value['imagePath'] ?>" alt="image" style="overflow: hidden;">
                </div>
                <div class="card-body">
                    <div class="type">
                        <span><?php echo  $value['category'] ?></span>
                    </div>
                    <div class="card-title mt-2"><span><?php echo $value['title'] ?></span></div>

                    <p class="card-text "><?php echo  $value['city'] ?> </p>
                    <p class="card-text "><?php echo  $value['publicationDate'] ?> </p>
                    <div class="card-price mt-2"><?php echo  $value['price'] . ' MAD' ?></div>
                </div>

                <div class="card-footer">
                    <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
                        <button type="submit" class="btn more btn-success">
                            more details
                        </button>
                    </a>
                </div>

            </div>
            <?php
                endforeach;
                ?>
        </div>

    </section>

    <!-- Sort annonces Descendally by date -->

    <?php

    elseif (isset($_POST['sortDateDesc'])) :
        $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
        FROM annonce
        JOIN image
        ON annonce.annonceID = image.annonceID WHERE imageType = 1 ORDER BY publicationDate DESC;";
        $sortedAnnoncesByDateDesc = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <section class="container mb-3">
        <div class="row justify-content-between container mt-4">
            <?php
                foreach ($sortedAnnoncesByDateDesc as $key => $value) :
                ?>
            <div class="card  mt-3 mx-auto" style="width: 20rem;">
                <div class="img-zoom">
                    <img src="<?php echo $value['imagePath'] ?>" alt="image" style="overflow: hidden;">
                </div>
                <div class="card-body">
                    <div class="type">
                        <span><?php echo  $value['category'] ?></span>
                    </div>
                    <div class="card-title mt-2"><span><?php echo $value['title'] ?></span></div>

                    <p class="card-text "><?php echo  $value['city'] ?> </p>
                    <p class="card-text "><?php echo  $value['publicationDate'] ?> </p>
                    <div class="card-price mt-2"><?php echo  $value['price'] . ' MAD' ?></div>
                </div>

                <div class="card-footer">
                    <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
                        <button type="submit" class="btn more btn-success">
                            more details
                        </button>
                    </a>
                </div>

            </div>
            <?php

                endforeach;

                ?>
        </div>
        <!-- Sort annonces Descendally by price -->
    </section>
    <?php
    elseif (isset($_POST['sortPriceDesc'])) :
        $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
        FROM annonce
        JOIN image
        ON annonce.annonceID = image.annonceID WHERE imageType = 1 ORDER BY price DESC;";
        $sortedAnnoncesByPriceDesc = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <section class="container mb-3">
        <div class="row justify-content-between container mt-4">
            <?php
                foreach ($sortedAnnoncesByPriceDesc as $key => $value) :
                ?>
            <div class="card mt-3  mx-auto" style="width: 20rem;">
                <div class="img-zoom">
                    <img src="<?php echo $value['imagePath'] ?>">
                </div>
                <div class="card-body">
                    <div class="type">
                        <span><?php echo  $value['category'] ?></span>
                    </div>
                    <div class="card-title mt-2"><span><?php echo $value['title'] ?></span></div>

                    <p class="card-text "><?php echo  $value['city'] ?> </p>
                    <p class="card-text "><?php echo  $value['publicationDate'] ?> </p>
                    <div class="card-price mt-2"><?php echo  $value['price'] . ' MAD' ?></div>
                </div>

                <div class="card-footer">
                    <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
                        <button type="submit" class="btn more btn-success">
                            more details
                        </button>
                    </a>
                </div>

            </div>
            <?php

                endforeach;

                ?>
        </div>

        <!-- Sort annonces Ascendally by price -->

    </section>
    <?php
    elseif (isset($_POST['sortPriceAsc'])) :
        $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
        FROM annonce
        JOIN image
        ON annonce.annonceID = image.annonceID WHERE imageType = 1 ORDER BY price;";
        $sortedAnnoncesByPriceAsc = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <section class="container mb-3">
        <div class="row justify-content-between container mt-4">
            <?php
                foreach ($sortedAnnoncesByPriceAsc as $key => $value) :
                ?>
            <div class="card  mt-3 mx-auto" style="width: 20rem;">
                <div class="img-zoom">
                    <img src="<?php echo $value['imagePath'] ?>" class="card-img-top" alt="image"
                        style="overflow: hidden;">
                </div>
                <div class="card-body">
                    <div class="type">
                        <span><?php echo  $value['category'] ?></span>
                    </div>
                    <div class="card-title mt-2"><span><?php echo $value['title'] ?></span></div>

                    <p class="card-text "><?php echo  $value['city'] ?> </p>
                    <p class="card-text "><?php echo  $value['publicationDate'] ?> </p>
                    <div class="card-price mt-2"><?php echo  $value['price'] . ' MAD' ?></div>
                </div>

                <div class="card-footer">
                    <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
                        <button type="submit" class="btn more btn-success">
                            more details
                        </button>
                    </a>
                </div>

            </div>
            <?php

                endforeach;

                ?>
        </div>

        <!--  =============== Fetch all annonces ================ -->

    </section>
    <?php
    else :
        // $sql = "SELECT title, type, category, publicationDate, price, city FROM annonce";
        // $allAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        // $sql = "SELECT annonce.annonceID, title, type, category, publicationDate, price, city, imagePath
        // FROM annonce
        // JOIN image
        // ON annonce.annonceID = image.annonceID WHERE imageType = 1;";
        // $allAnnonces = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <!-- Cards -->

    <section class="container mb-3">

        <div class="row justify-content-between container mt-4">
            <?php
                foreach ($allAnnonces as $key => $value) :
                ?>

            <div class="card  mt-3 mx-auto" style="width: 20rem;">
                <div class="img-zoom">
                    <img src="<?php echo $value['imagePath'] ?>" class="card-img-top" alt="image"
                        style="overflow: hidden;">
                </div>
                <div class="card-body">
                    <div class="type">
                        <span><?php echo $value['category'] ?></span>
                    </div>
                    <div class="card-title mt-2"><span><?php echo $value['title'] ?></span></div>

                    <p class="card-text "><?php echo  $value['city'] ?> </p>
                    <p class="card-text "><?php echo  $value['publicationDate'] ?> </p>
                    <div class="card-price mt-2"><?php echo  $value['price'] . ' MAD' ?></div>

                </div>


                <div class="card-footer">
                    <a href="details.php?pageId=<?php echo $value['annonceID']; ?>">
                        <button type="submit" class="btn more btn-success">
                            more details
                        </button>
                    </a>
                </div>

            </div>
            <?php

                endforeach;
                ?>
            <nav class="mt-4 mb-4 " aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php
                        for ($i = 1; $i <= $pagesNum; $i++) {
                        ?>
                    <li class="page-item"><a class="page-link bg-dark"
                            href="<?php echo "index.php?pageId=" . $i ?>"><?php echo $i; ?></a></li>
                    <?php
                        }
                        ?>
                </ul>
            </nav>
            <?php

        endif;
            ?>
        </div>








    </section>









    <!-- end the  cards -->


    <!-- modal sing-in-up -->














    <!-- Modal -->
    <div class="modal fade" id="sign-in-up" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="wrapper">
                        <div class="title-text">
                            <div class="title login">Login Form</div>
                            <div class="title signup">Signup Form</div>
                        </div>
                        <div class="form-container">
                            <div class="slide-controls">
                                <input type="radio" name="slide" id="login" checked />
                                <input type="radio" name="slide" id="signup" />
                                <label for="login" class="slide login">Login</label>
                                <label for="signup" class="slide signup">Signup</label>
                                <div class="slider-tab"></div>
                            </div>
                            <div class="form-inner">

                                <form class="login" method='post'>
                                    <div class="field">
                                        <input type="text" name="email" placeholder="Email Address" required />
                                    </div>
                                    <div class="field">
                                        <input type="password" name='password' placeholder="Password" required />
                                    </div>
                                    <div class="pass-link">
                                        <a href="#">Forgot password?</a>
                                    </div>
                                    <div class="field btn">
                                        <div class="btn-layer"></div>
                                        <input type="submit" name="login" value="Login" />
                                    </div>
                                    <div class="signup-link">
                                        Not a member? <a href="">Signup now</a>
                                    </div>
                                </form>
                                <!-- Sign Up -->
                                <form class="signup" id="signUpForm" method="post">
                                    <div class="field">
                                        <input type="text" name="firstName" placeholder="First Name"
                                            id="firstNameSignUp" required />
                                        <div class="error"></div>
                                    </div>
                                    <div class="field">
                                        <input type="text" name="lastName" placeholder="Last Name" id="lastNameSignUp"
                                            required />
                                        <div class="error"></div>

                                    </div>
                                    <div class="field">
                                        <input type="text" name="email" placeholder="Email Address" id="emailSignUp"
                                            required />
                                        <div class="error"></div>

                                    </div>
                                    <div class="field">
                                        <input type="password" name="password" placeholder="Password"
                                            id="passwordSignUp" required />
                                        <div class="error"></div>

                                    </div>
                                    <div class="field">
                                        <input type="password" placeholder="Confirm password" id="confirmPasswordSignUp"
                                            required />
                                        <div class="error"></div>

                                    </div>
                                    <div class="field">
                                        <input type="text" pattern="[0-9]*" name="phone" placeholder="Phone"
                                            id="phoneSignUp" required />
                                        <div class="error"></div>

                                    </div>
                                    <div class="field btn">
                                        <div class="btn-layer"></div>
                                        <input type="submit" name="signUp" value="Signup" id="signUp" />
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





    <!-- Our Services -->

    <!-- <div class="container mt-5">
        <h2 class="text-center m-4 pb-5">Our Services</h2>
        <div class="row gx-2">
            <div class="col-sm d-flex flex-column align-center">
                <img src="./img/Contact/home.png" alt="home" class="mw-100 w-25 mx-auto" />
                <p class="text-center mt-2">Find places anywhere in Morocco</p>
            </div>

            <div class="col-sm d-flex flex-column">
                <img src="./img/Contact/find.png" alt="home" class="mw-100 w-25 mx-auto" />
                <p class="text-center mt-2">Buy & Rent Properties</p>
            </div>

            <div class="col-sm d-flex flex-column">
                <img src="./img/Contact/support.png" alt="home" class="mw-100 w-25 mx-auto" />
                <p class="text-center mt-2">We have agents</p>
            </div>
        </div>
    </div> -->



    <section class="container ">
        <h3 class="text-center mb-3">Our Services</h3>
        <div class="blocs row mb-3">
            <div class="bloc col-sm d-flex flex-column align-center">
                <i class="fa-solid fa-coins"></i>
                <h4><span>Budget optimisé</span></h4>
                <p>Vous faire profiter de notre large pouvoir de négociation.</p>
            </div>
            <div class="bloc col-sm d-flex flex-column ">
                <i class="fa-solid fa-phone-volume"></i>
                <h4><span>Assitance 24/24</span></h4>
                <p>Vous assister à toutes les étapes de vos projets clients.</p>
            </div>
            <div class="bloc col-sm d-flex flex-column ">
                <i class="fa-solid fa-handshake-angle"></i>
                <h4><span>Valeur humaine</span></h4>
                <p>
                    Vous accueillir conformément à la tradition marocaine avec le cœur!.
                </p>
            </div>
        </div>
    </section>









    <section class="sponsors container">
        <h3 class="text-center mb-3 mt-5">Nos sponsors</h3>
        <div>
            <img src="img/qatar.png" alt="qatar" />
            <img src="img/airarabia.png" alt="airarabia" />
            <img src="img/royal.png" alt="royal" />
            <img src="img/omanair.png" alt="omanair" />
            <img src="img/turkishairlines.png" alt="turkishairlines" />
        </div>
    </section>












    <!--=========== footer  ===========-->
    <footer class="">
        <div class="media container d-flex justify-content-between">
            <p class="text-light">Copyright © 2023. All Rights Reserved.</p>
            <a href="#"> Go to top</a>
        </div>
    </footer>
















    <script src="validation.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous">
    </script>




    <script src="./js/sign-in-up.js"></script>

    <script src="https://kit.fontawesome.com/eec721374e.js" crossorigin="anonymous"></script>


</body>

</html>