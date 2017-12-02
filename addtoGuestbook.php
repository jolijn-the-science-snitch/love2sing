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
//connect database hier anders kan de $_GET van het goedkeuren of weigeren er niet bij
include("dbconnection.php");

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
            
            
            
            //veilige insert in de tabel
            $stmt= $db->prepare("INSERT INTO guestbook (guestbookTitle, guestbookMessage, guestbookDate) VALUES('$title','$message','$date')");
            $stmt->execute();
            echo "Uw verzoek om een bericht te plaatsen in ons gastenboek is verstuurd! Zodra deze is goedgekeurd wordt het bericht in ons gastenboek geplaatst.";
         
            //verstuur mail  
            $titel = $title;
            $bericht = $message;
            $berichtdatum = $date;
            
            $id = $db->lastInsertId(); // krijg het id van het zojuist geinserte gastenboek item

            // $berichtdatumpdo= $db->prepare("SELECT guestbookDate FROM guestbook"); Selecteer alle gastenboekdata, niet nodig en niet relevant, want je hebt de variablen al geinsert, die kan je ook gebruiken in de mail
            // $berichtdatumpdo->execute(); is geen string met kollom inhoud, maar een pdo statement


// !!!!!!!!!!!!!!

// localhost/nando/love2sing/addtoGuestbook.php aanpassen naar url waar de website staat

// !!!!!!!!!!!!!!
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
        
        <a href='localhost/nando/love2sing/addtoGuestbook.php?toevoegen=true&id=".$id."' id='button-purple'>Toevoegen</a>
        <a href='localhost/nando/love2sing/addtoGuestbook.php?weigeren=true&id=".$id."' id='button-purple'>Weigeren</a>
             
    </body>

</html>
";
        //goedkeuren van bericht
       
        
                   
            $replyTo= null;
                
           echo sendMail($subject,$message,$replyTo);             
}
 
}
   
   
   ?>


   <?php
        // alleen bij het zojuist toegevoegde bericht de status aanpassen d.m.v. de WHERE
        // en even een $_GET van gemaakt, want een post wil niet vanuit de mail
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
