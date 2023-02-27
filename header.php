<?php
require 'config/database.php';
if(!isset ($_SESSION['user-id'])){
    header ('location: ' .Root_URL. 'signin.php');
   die();
}else{
    $id= filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM Users where ID=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pal News </title>
    <link rel="stylesheet" href="<?php echo Root_URL ?>css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;1,600;1,700;1,800&display=swap" rel="stylesheet">


</head>

<body>
    <nav>
        <div class="container nav_container">
            <a href="<?php echo Root_URL ?>" class="nav_logo"> Pal News </a>
            <ul class="nav_items">
                <li> <a href="<?php echo Root_URL ?>news-feed.php"> News Feed </a></li>
                <li> <a href="<?php echo Root_URL ?>about.php"> About</a></li>
                <li> <a href="<?php echo Root_URL ?>services.php"> Services </a></li>
                <li> <a href="<?php echo Root_URL ?>contact.php"> Contact Us</a></li>
                <?php if(isset($_SESSION['user-id'])) :?>
                <li class="nav_profile">
                    <div class="avatar">
                    <img src="<?= Root_URL.'images/'.$avatar['avatar']?>">
                    </div>
                    <ul>
                        <li> <a href="<?php echo Root_URL ?>admin/index.php"> Dashboard </a></li>
                        <li> <a href="<?php echo Root_URL ?>logout.php"> Logout </a></li>
                    </ul>
                </li>
                <?php else : ?>
                <li> <a href="<?php echo Root_URL ?>signin.php"> Sign in</a></li>
                <?php endif ?>
                </ul>
                    <button id=" open_nav_btn"><i class="uil uil-list-ul"></i></button>
                    <button id=" close_nav_btn"><i class="uil uil-times-circle"></i> </button>

        </div>
        </li>


        </ul>
        </div>
    </nav>