<?php
require 'admin/config/constants.php';
$firstname = $_SESSION['signup-data']['firstname'] ?? null;
$lastname = $_SESSION['signup-data']['lastname'] ?? null;
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
unset($_SESSION['signup-data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pal News </title>
    <link rel="stylesheet" href="<?php echo Root_URL ?>css/style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <script src="js/main.js"></script>


</head>

<body>
<section class="form_section">
    <div class=" container form_section-container">
        <h2 class="signup"> Sign Up </h2>
        <br>
        <?php if(isset($_SESSION['signup'])) : ?> 
           <div class="alert_message error">
            <p> 
            <?= $_SESSION['signup'];
            unset($_SESSION['signup']);
            ?>
            </p>
           </div>
        
        <?php endif ?>
        <form action="<?php echo Root_URL ?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder=" First Name">
            <input type="text" name="lastname" value="<?= $lastname ?>" placeholder=" Last Name">
            <input type="text" name="username" value="<?= $username ?>" placeholder=" User Name">
            <input type="email" name="email" value="<?= $email ?>" placeholder=" Email">
            <input type="password" name="password" placeholder=" Create Password">
            <input type="password" name="repassword" placeholder=" Confirm Password">
            <div class="form_control">
                <label for="avatar"></label>
                <input type="file" name="avatar" id="avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign up</button>
            <small> Already have an account? <a href="signin.php"> Sign in</a></small>


        </form>

    </div>
</section>
</body>
</html> 