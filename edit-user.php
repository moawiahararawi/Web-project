<?php
include 'partials/header.php';
if (isset($_GET['id'])){
$id= filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
$query= "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($result);
}else{
    header ('location: '.Root_URL.'admin/index.php');
    die();
}
?>
<section class="form_section">
    <div class=" container form_section-container">
        <h2> Edit User </h2>
        <form action="<?php Root_URL ?>edit-user-logic.php" method = "POST">
            <input type="hidden" name = "id" value = "<?= $user['id']?>"placeholder="">
            <input type="text" name = "firstname" value = "<?= $user['firstname']?>"placeholder="First Name">
            <input type="text" name = "lastname" value = "<?= $user['lastname']?>" placeholder="Last Name">
            <input type="password" name = "password" placeholder="New password">
            <select name="userrole">
                <option value="0">Author</option>
                <option value="1">Admin</option>
            </select>
            <button type="submit" name = "submit" class="btn">Update User</button>
        </form>

    </div>
</section>
