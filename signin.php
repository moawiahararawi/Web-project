<?php
include 'partials/header.php';
$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password'] ?? null;
unset($_SESSION['signin-data']);
?>
<section class="form_section">
    <div class=" container form_section-container">
        <h2 class="signin"> Sign In </h2>
        <br>
        <?php if (isset($_SESSION['signup-success'])): ?>
            <div class="alert_message success">
                <p>
                    <?= $_SESSION['signup-success'];
                    unset($_SESSION['signup-success']);
                    ?>
                </p>
            </div>
            <?php elseif (isset($_SESSION['signin'])): ?>
            <div class="alert_message error">
                <p>
                    <?= $_SESSION['signin'];
                    unset($_SESSION['signin']);
                    ?>
                </p>
            </div>
            <?php endif ?>
        <form action="<?php Root_URL ?> signin-logic.php" method="POST">
            <input type="text" name="username_email" value="<?= $username_email ?>" placeholder=" Username or E-mail">
            <input type="password" name="password" value="<?= $password ?>" placeholder="  Password">
            <button type="submit" name="submit" class="btn">Sign In</button>
            <small> Don't have an account? <a href="signup.php"> Sign Up</a></small>
        </form>

    </div>
</section>
</body>

</html>