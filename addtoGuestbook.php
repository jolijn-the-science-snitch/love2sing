<?php
    require 'header.php';
    include 'includes/functions.php';
?>

    <head>
        <link rel="stylesheet" type="text/css" href="guestbook.css">
        <link rel="stylesheet" type="text/css" href="css/creative.min.css">
    </head>
<!--
<header>

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
            echo "Uw verzoek om een bericht te plaatsen in ons gastenboek is verstuurd! Zodra deze is goedgekeurd wordt het bericht in ons gastenboek geplaatst.";
         
            //verstuur mail
            $titel= $db->prepare("SELECT guestbookTitle FROM guestbook");
            $titel->execute();
            $bericht= $db->prepare("SELECT guestbookMessage FROM guestbook");
            $bericht->execute();
            $berichtdatum= $db->prepare("SELECT guestbookDate FROM guestbook");
            $berichtdatum->execute();
            
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
                    <input type='submit' name='toevoegen' value='Toevoegen' id='button-purple' />
                    <input type='submit' name='weigeren' value='Weigeren' id='button-purple' />
                </div>
            </form>
        </div>
    </body>

</html>
";
        //dit zou er moeten gebeuren als je op de knoppen drukt
        if(isset($_POST['toevoegen'])){
           $approve= $db->prepare("UPDATE guestbook SET approved = 1;");
            $approve->execute();
      }             
        if(isset($_POST['weigeren'])){
            $approve= $db->prepare("UPDATE guestbook SET approved = 0;");
            $approve->execute();
        }
        
                   
            $replyTo= null;
                
           echo sendMail($subject,$message,$replyTo);             
}
 
}
   
   
   ?>

            <?php
    require 'footer.php';
    ?>