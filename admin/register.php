<?php
require 'adminpageheader.php';
$register = new DbHelper();
?>

<!-- Page Header -->
<section>

    <!-- Post Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="wrapper">
                    <form class="form-signin" method="post" action="register.php">       
                        <h2 class="form-signin-heading">Registreer</h2>
                        <div class="form-group">
                            Gebruikersnaam: <br>
                            <input type="text" class="form-control" name="username" placeholder="Gebruikersnaam" required="" autofocus="" />
                        </div>
                        <div class="form-group">
                            E-mailadres: <br>
                            <input type="text" class="form-control" name="userEmail" placeholder="Email" />
                        </div>
                        <div class="form-group">
                            Nieuw wachtwoord:
                            <input type="password" class="form-control" name="userPassword" placeholder="Wachtwoord" required=""/>
                        </div>
                        <div class="form-group">
                            Herhaal wachtwoord: <br>
                            <input type="password" class="form-control" name="repeatPassword" placeholder="Herhaal wachtwoord" required=""/>
                        </div>
                        <div class="form-group">
                            Rechten: <br>
                            <input type="text" class="form-control" name="userRights" placeholder="1 = user, 2 = admin" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="register" value="Registreer" class="btn btn-lg btn-primary btn-block"/> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<?php
if(isset ($_REQUEST['register'])){
    $register-> createUser();
}

require 'adminpagefooter.php';
?>