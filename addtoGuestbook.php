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
//connect database hier anders kan de $_GET van het goedkeuren of weigeren er niet bij

if (isset($_POST['verzenden'])) {
    $valid = true;
    $title = htmlentities(trim($_POST['titel'],ENT_QUOTES));
    //checken of er een titel is ingevuld
    if (empty($title)) {
        echo "<p class='error'>Vul alstublieft een titel in</p>";
        $valid = false;
    }
    $gbmessage = htmlentities(trim($_POST['bericht'],ENT_QUOTES));
    //checken of er een bericht is ingevuld
    if (empty($gbmessage)) {
        echo "<p class='error'>Vul alstublieft een bericht in</p>";
        $valid = false;
    }
    $date= date("Y-m-d");
    //automatisch eerste letter hoofdletter maken
    $title= ucfirst(strtolower($title));
    $gbmessage = ucfirst(strtolower($gbmessage));
    
    //als de velden gecheckt zijn de data in de database gooien
    if ($valid== true) {
            
            
            
            //veilige insert in de tabel dmv prepare, daardoor geen string escape meer nodig
            $stmt= $db->prepare("INSERT INTO guestbook (guestbookTitle, guestbookMessage, guestbookDate) VALUES('$title','$gbmessage','$date')");
            $stmt->execute();
           echo "<div class='guestbook-text'>Uw verzoek om een bericht te plaatsen in het gastenboek is verstuurd! Als deze wordt geaccepteerd, zal uw bericht in het gastenboek verschijnen.</div>";
        
         
//verstuur mail voor het goedkeuren van een gastenboekbericht
        
            $id = $db->lastInsertId(); // krijg het id van het zojuist geinserte gastenboek item

            $subject= "Nieuw gastenboek bericht";
            $message= "
<!DOCTYPE html>
<html lang='en'>
    
    <body>
        <p>Er is een nieuw verzoek voor een bericht in het gastenboek:</p>
        <h3>".$title."</h3>
        <p>".$gbmessage." <br>
        ".$date."</p>
        <p>Wilt u dit bericht toevoegen aan het gastenboek of weigeren? Als u kiest voor weigeren, wordt het bericht niet in het gastenboek geplaats.</p>
        
        <a href='localhost/love2sing1/addtoGuestbook.php?toevoegen=true&id=".$id."' id='button-purple'>Toevoegen</a>
        <a href='localhost/love2sing1/addtoGuestbook.php?weigeren=true&id=".$id."' id='button-purple'>Weigeren</a>
             
    </body>

</html>
";             
            $replyTo= null; //persoon heeft geen mailadres moeten invoeren en krijgt dus ook geen bericht van toevoeging of weigering
                
           echo sendMail($subject,$message,$replyTo);             
}
 
}
   
   
   ?>


   <?php
        // alleen bij het zojuist toegevoegde bericht de status aanpassen d.m.v. de WHERE
        // $_GET, want een $_POST wil niet vanuit de mail
        if(isset($_GET['toevoegen']) && isset($_GET['id'])){
            $approve= $db->prepare("UPDATE guestbook SET guestbookApproved = 1 WHERE guestbookId = ?;");
            $approve->execute(array($_GET['id']));
            echo $approve->rowCount();
        }             
        if(isset($_GET['weigeren']) && isset($_GET['id'])){
            $approve= $db->prepare("UPDATE guestbook SET guestbookApproved = 0 WHERE guestbookId = ?;");
            $approve->execute(array($_GET['id']));
            echo $approve->rowCount();
        }
   ?>

            <?php
    require 'footer.php';
    ?>
