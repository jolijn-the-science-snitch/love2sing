<?php
    require 'header.php';
    $register = new DbHelper();
?>

<!-- Page Header -->
    <header class="intro-header" style="background-image: url('img/register.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="page-heading">
                        <h1>Registreer</h1>
                        <hr class="small">
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Post Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="wrapper">
                        <form class="form-signin" method="post" action="register.php">       
                          <h2 class="form-signin-heading">Registreer</h2>
                            <input type="text" class="form-control" name="username" placeholder="Gebruikersnaam" required="" autofocus="" />
                          <input type="text" class="form-control" name="userEmail" placeholder="Email" />
                          <input type="password" class="form-control" name="userPassword" placeholder="Wachtwoord" required=""/>
                          <input type="password" class="form-control" name="repeatPassword" placeholder="Herhaal wachtwoord" required=""/><br>
			<input type="text" class="form-control" name="userRights" placeholder="1 = user, 2 = admin" />
                          <input type="submit" name="register" value="Registreer" class="btn btn-lg btn-primary btn-block"/> 
                        </form>
                      </div>
                </div>
            </div>
        </div>
        
    <hr>


<?php
    if(isset ($_REQUEST['register'])){
        $register-> createUser();
    }

    require 'footer.php';
?>