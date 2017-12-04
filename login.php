<?php
    require 'header.php';
    
    $login = new DbHelper();

    if(isset ($_REQUEST['login'])){
        $login-> selectUser();
    }
?>

    <div class="login">
        <div class="login-triangle"></div>

        <h2 class="login-header">Log in</h2>

        <form class="login-container" method="post" action="login.php">
            <p><input type="text" class="form-control" name="username" placeholder="Gebruikersnaam" required="" autofocus=""></p>
            <p><input type="password" class="form-control" name="password" placeholder="Wachtwoord" required=""></p>
            <p><input type="submit" name="login" value="Login"></p>
        </form>
    </div>


    <?php
    require 'footer.php';
?>
