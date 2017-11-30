<?php
    require 'adminHeader.php';
    $view = new DbHelper();

    if(isset ($_REQUEST['editPassword'])){
        if($_POST['password'] == $_POST['repeatPassword']){
        $view-> editUser();
        }else{ echo "Er ging iets verkeerd.";}
    }
?>    

    <div class="login">
        <h2 class="login-header">Wachtwoord veranderen</h2>

        <form class="login-container" method="post" action="editPassword.php">
            <p><input type="password" class="form-control" name="password" placeholder="Nieuw wachtwoord" required="" autofocus=""></p>
            <p><input type="password" class="form-control" name="repeatPassword" placeholder="Herhaal wachtwoord" required=""></p>
            <p><input type="submit" name="editPassword" value="Verander wachtwoord"></p>
        </form>
    </div>

    <?php
    require 'adminFooter.php';
?>
