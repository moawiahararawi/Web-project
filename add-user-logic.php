<?php
require 'config/database.php';
header ('location: ' . Root_URL . 'admin/index.php');
if (isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $repassword = filter_var($_POST['repassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $user_role = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    

    if(!$firstname){
        $_SESSION['add-user'] = "Please enter your first name";
    }
    elseif(!$lastname){
        $_SESSION['add-user'] = "Please enter your last name";
    }
    elseif(!$username){
        $_SESSION['add-user'] = "Please enter your username";
    }
    elseif(!$email){
        $_SESSION['add-user'] = "Please enter a valid E-mail";
    }
   // elseif(!$user_role){
      //  $_SESSION['add-user'] = "Please select a role";
    
    elseif(strlen($password) < 8 || strlen($repassword) < 8){
        $_SESSION['add-user'] = "Password should be at least 8 characters";
    }
    elseif(!$avatar['name']){
        $_SESSION['add-user'] = "Please add an avatar";
    }
    else{
        if($password !== $repassword){
        $_SESSION['add-user'] = "Passwords do not match";
        } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user_check = "SELECT * FROM users WHERE username ='$username' OR email='$email'";
        $user_check_result = mysqli_query($connection, $user_check);
        if(mysqli_num_rows($user_check_result) > 0){
        $_SESSION['add-user'] = "Username or Email already exist";
        } else  {
        $time = time();
        $avater_name = $time . $avatar['name'];
        $avatar_tmp_name = $avatar['tmp_name'];
        $avatar_destination_path = '../images/'. $avater_name;
        $allowed_files = ['png','jpg','jpeg'];
        $extension = explode('.', $avater_name);
        $extension = end($extension);
        if(in_array($extension, $allowed_files)){
            if($avatar['size'] < 2000000){
            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
            } else {
            $_SESSION['add-user'] = "Avatar size should be less than 2 MB";
            }
        } else {
            $_SESSION['add-user'] = "Avatar should be PNG, JPG or JPEG";
        }
      }
    }
}
    if(isset ($_SESSION['add-user'])){
        $_SESSION['add-user-data'] = $_POST;
        header ('location: ' . Root_URL . 'admin/add-user.php');
    } else {
        $insert_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avater_name', isadmin=$user_role";
        $query_result = mysqli_query($connection, $insert_query);
        if(!mysqli_errno($connection)){
            $_SESSION['add-user-success'] = "$firstname $lastname is successfully added.";
            header ('location: ' . Root_URL . 'admin/manage-users.php');
            die();
        }
    }
}
 else {
    header ('location: ' . Root_URL . 'admin/add-user.php');
    die();
} 