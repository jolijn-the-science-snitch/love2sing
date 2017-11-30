<?php
    require 'header.php';
    include 'includes/functions.php';
?>

    <head>
        <link rel="stylesheet" type="text/css" href="guestbook.css">
        <link rel="stylesheet" type="text/css" href="css/creative.min.css">
    </head>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">Love2Sing</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#about">Over ons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#services">Fotoalbum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="guestbook.php">Gastenboek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!--<header>

    <h1 class="text-uppercase">
        <strong>Gastenboek</strong>
    </h1>
</header> !-->

    <div id="form-main">
        <div id="form-div">
            <form class="form" id="form1" method="POST">

                <p class="name">
                    <input name="titel" type="text" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Titel" id="name" />
                </p>

                <p class="text">
                    <textarea name="bericht" class="validate[required,length[6,300]] feedback-input" id="comment" placeholder="Bericht"></textarea>
                </p>


                <div class="submit">
                    <input type="submit" name="verzenden" value="Verzend bericht" id="button-blue" />
                    <div class="ease"></div>
                </div>
            </form>
        </div>



        <?php
   if(isset($_GET['gb'])){
        
        if(isset($_POST['verzenden'])){
            //variables
            $title= $_POST['titel'];
            $message= $_POST['bericht'];
            $date= date("Y-m-d");
            
            //connect database
            include("dbconnection.php");
            
            //insert in de tabel
            $stmt= $db->prepare("INSERT INTO guestbook (guestbookTitle, guestbookMessage, guestbookDate) VALUES('$title','$message','$date')");
            $stmt->execute();
            echo "Bedankt voor het schrijven in ons gastenboek!";
            
            //verstuur mail
            $subject= "Nieuw gastenboek bericht";
            $message= "<!DOCTYPE html>
<html lang='en'>
    
    <body>
        <p>Er is een nieuw verzoek voor een bericht in het gastenboek:</p>
        <h1>Titel</h1>
        <p>Bericht</p>
        <p>Wilt u dit bericht toevoegen aan het gastenboek of verwijderen?</p>
    </body>

</html>";
            $replyTo= null;
                
           echo sendMail($subject,$message,$replyTo); 
            
            
        }
           
   }
   
   ?>

            <?php
    require 'footer.php';
    ?>
