<?php
require 'admin/config/database.php';
if (isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $repassword = filter_var($_POST['repassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    if(!$firstname){ 
        $_SESSION['signup'] = "Please enter your first name";
    }
    elseif(!$lastname){
        $_SESSION['signup'] = "Please enter your last name";
    }
    elseif(!$username){
        $_SESSION['signup'] = "Please enter your username";
    }
    elseif(!$email){
        $_SESSION['signup'] = "Please enter a valid E-mail";
    }
    elseif(strlen($password) < 8 || strlen($repassword) < 8){
        $_SESSION['signup'] = "Password should be at least 8 characters";
    }
    elseif(!$avatar['name']){
        $_SESSION['signup'] = "Please add an avatar";
    }
    else{
        if($password !== $repassword){
        $_SESSION['signup'] = "Passwords do not match";
        } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user_check = "SELECT * FROM users WHERE username ='$username' OR email='$email'";
        $user_check_result = mysqli_query($connection, $user_check);
        if(mysqli_num_rows($user_check_result) > 0){
        $_SESSION['signup'] = "Username or Email already exist";
        } else  {
        $time = time();
        $avater_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = 'images/'. $avater_name;
        $allowed_files = ['png','jpg','jpeg'];
        $extension = explode('.', $avater_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)){
            if($avatar['size'] < 2000000){
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
            } else {
            $_SESSION['signup'] = "Avatar size should be less than 2 MB";
            }
        } else {
            $_SESSION['signup'] = "Avatar should be PNG, JPG or JPEG";
        }
      }
    }
}
    if(isset ($_SESSION['signup'])){
        $_SESSION['signup-data'] = $_POST;
        header ('location: ' . Root_URL . 'signup.php');
    } else {
        $insert_query = "INSERT INTO users Set firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avater_name', isadmin=0";
        $query_result = mysqli_query($connection, $insert_query);
        if(!mysqli_errno($connection)){
            $_SESSION['signup-success'] = "Registration is successful, Please log in.";
            header ('location: ' . Root_URL . 'signin.php');
            die();
        }
    }
}
 else {
    header ('location: ' . Root_URL . 'signup.php');
    die();
} 