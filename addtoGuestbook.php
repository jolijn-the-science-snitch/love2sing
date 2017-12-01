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
                        <a class="nav-link js-scroll-trigger" href="viewGuestbook.php">Gastenboek</a>
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
                    <input type="submit" name="verzenden" value="Verzend bericht" id="button-purple" />
                    <div class="ease"></div>
                </div>
            </form>
        </div>



        <?php
    //script beveiligd tegen XSS injecties dmv htmlentities in combinatie met ENT_QUOTES
    //dus &,<,>,",' worden in de database opgeslagen als hun html-entiteiten
if (isset($_POST['verzenden'])) {
    $valid = true;
    $title = htmlentities(trim($_POST['titel'],ENT_QUOTES));
    //checken of er een titel is ingevuld
    if (empty($title)) {
        echo "<p class='error'>Vul alstublieft een titel in</p>";
        $valid = false;
    }
    $message = htmlentities(trim($_POST['bericht'],ENT_QUOTES));
    //checken of er een bericht is ingevuld
    if (empty($message)) {
        echo "<p class='error'>Vul alstublieft een bericht in</p>";
        $valid = false;
    }
    $date= date("Y-m-d");
    //automatisch eerste letter hoofdletter maken
    $title= ucfirst(strtolower($title));
    $message = ucfirst(strtolower($message));
    
    //als de velden gecheckt zijn de data in de database gooien
    if ($valid== true) {
            
            //connect database
            include("dbconnection.php");
            
            //veilige insert in de tabel
            $stmt= $db->prepare("INSERT INTO guestbook (guestbookTitle, guestbookMessage, guestbookDate) VALUES('$title','$message','$date')");
            $stmt->execute();
            //echo "Bedankt voor het schrijven in ons gastenboek!";
    }
}/*
            
            //verstuur mail
            $titel= $stmt= ($db->prepare("SELECT guestbookTitle FROM guestbook");
                            $stmt->execute(););
            $bericht= $stmt= ($db->prepare("SELECT guestbookMessage FROM guestbook");
                                $stmt->execute(););
            $berichtdatum= $stmt= ($db->prepare("SELECT guestbookDate FROM guestbook");
                                $stmt->execute(););
            
            $subject= "Nieuw gastenboek bericht";
            $message= "
<!DOCTYPE html>
<html lang='en'>
    
    <body>
        <p>Er is een nieuw verzoek voor een bericht in het gastenboek:</p>
        <h1>".$titel."</h1>
        <p>".$bericht."
        ".$berichtdatum."</p>
        <p>Wilt u dit bericht toevoegen aan het gastenboek of verwijderen?</p>
        <div id='formmail'
            <form class='form' id='form2' method='POST'>
                <div class='submit'>
                    <input type='submit' name='toevoegen' value='Toevoegen' id='button-blue' />
                    <input type='submit' name='verwijderen' value='Verwijderen' id='button-blue' />
                </div>
            </form>
        </div>
    </body>

</html>
";
            //als $toevoegen isset, UPDATE guestbook SET approved = 1 WHERE guestbookId = ?
            //als $verwijderen isset, UPDATE guestbook SET approved = 0 WHERE guestbookId = ?
            $replyTo= null;
                
           echo sendMail($subject,$message,$replyTo); 
           */
            
            
        
           
   
   
   ?>

            <?php
    require 'footer.php';
    ?>
