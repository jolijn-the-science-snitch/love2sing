<?php
    require 'header.php';
    //include 'includes/functions.php';
?>

    <head>
        <link rel="stylesheet" type="text/css" href="guestbook.css">
        <link rel="stylesheet" type="text/css" href="css/creative.min.css">
    </head>

    <!-- Navigation -->

    <!--<header>
    <h1 class="text-uppercase">
        <strong>Gastenboek</strong>
    </h1>
</header> !-->
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
            //include("dbconnection.php");
            
//            //insert in de tabel
//            $stmt= $db->prepare("INSERT INTO guestbook (guestbookTitle, guestbookMessage, guestbookDate) VALUES('$title','$message','$date')");
//            $stmt->execute();
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
            $replyTo= "love2singtestmail";
                
           echo sendMail($subject,$message,$replyTo); 
            
            
        }
           
   }
   
   ?>

            <?php
    require 'footer.php';
    ?>