<?php
require 'config/database.php';
if (isset($_POST['submit'])){
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!$username_email){
        $_SESSION['signin'] = "Enter Username or E-mail";
    }
    elseif(!$password){
        $_SESSION['signin'] = "Enter password";
    } else {
       $fetch_user = "SELECT * FROM users WHERE username='$username_email' or email ='$username_email'";
       $fetch_result = mysqli_query($connection, $fetch_user);
       if(mysqli_num_rows($fetch_result) ==1) {
        $user_record = mysqli_fetch_assoc($fetch_result);
        $db_password = $user_record ['password'];
        if (password_verify($password, $db_password)){
            $_SESSION['user-id'] = $user_record['id'];
            if($user_record['isadmin'] == 1){
                $_SESSION['user_is_admin']= true;
            }
            header ('location: ' . Root_URL . 'admin/');
        } else {
            $_SESSION['signin'] = "Password is incorrect";
            }
    } else {
      $_SESSION['signin'] = "User not found";
      }
   }
if(isset($_SESSION['signin'])){
    $_SESSION['signin-data'] = $_POST;
    header ('location: ' . Root_URL . 'signin.php');
    die();
}

} else{
    header ('location: ' . Root_URL . 'signin.php');
    die();
}