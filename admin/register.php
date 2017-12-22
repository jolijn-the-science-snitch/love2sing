<?php
include("adminpageheader.php");
$formStyle = "";
$buttonstyle = "style='display: none;'";
?>

<?php
//require_once '../includes/functions.php'; //connect database en functies
$required = "required";
$name = "";
$filehtml = "";
$fileInputStyle = "";
$form = "";
$back = "";
$title = "Gebruikersaccount toevoegen";

    $register = new DbHelper();
    
    if(isset ($_POST["username"])){
        $register-> createUser();
    }
?>


    <section>   
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading text-uppercase">Gebruikersaccount toevoegen</h2>
                <?= $back ?>
            </div>
        </div>
                       <form method="post" enctype="multipart/form-data">
                            <div id="musicform" <?= $formStyle ?> >
                                <div class="row">
                                    <div class="col md6">
                          <h3>Gebruikers informatie</h3>
                            
                        <div class="form-group">
                            <label for="username">Gebruikersnaam</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Gebruikersnaam" required=""/>               
                        </div>                
                        <div class="form-group">
                            <label for="username">Emailadres</label>
                            <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Email" required="" />
                        </div>
                        <div class="form-group">
                            <label for="username">Wachtwoord</label>
                            <input type="password" class="form-control" id="userPassword "name="userPassword" placeholder="Wachtwoord" required=""/>
                        </div>
                        <div class="form-group">
                            <label for="username">Herhaal wachtwoord</label>
                            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Herhaal wachtwoord" required=""/>
                           </div>
                        <div class="form-group"> 
                            <label for="username">Gebruikersrechten</label>
                            <br>
                          <button id="addUseraccount" name="addUseraccount" value="1" class="btn btn-primary btn-xl text-uppercase" type="submit">Useraccount</button>
                          <button id="addAdminaccount" name="addUseraccount" value="2" class="btn btn-primary btn-xl text-uppercase" type="submit">Adminaccount</button>
                            <div id="message"></div> <?= $message ?>
                            
                        </div>
                                        
                                    </div>
                                    <div class="col invisibleOnPhone"></div>
                                </div>
                           </div>
                        </form>
                      </div>
            
           
        </section>
    

<?php


   include("adminpagefooter.php");
?>