<?php
require("includes/functions.php");
if (isset($_POST['contactName']) && isset($_POST['contactEmail']) && isset($_POST['contactMessage'])) {   
    $contactName = $_POST['contactName'];
    $contactEmail = $_POST['contactEmail'];
    $contactMessage = nl2br($_POST['contactMessage']);
    
    $message = "
    <h1 style='font-size: 22px;'>Het contact formulier is ingevuld door ".$contactName."</h1>
    
    <h2 style='font-size: 18px;'>Het volgende bericht is gestuurd:</h2>
    
    <p style='font-size: 14px;'>". $contactMessage."</p>
    <div style='font-size: 14px;'>
        <h2 style='font-size: 18px;'>Gegevens:</h2>
        <b>Naam: </b>".$contactName."<br>
        <b>E-mail: </b>".$contactEmail."<br>
        <b>Verstuurd op: </b>".date("d-m-Y H:i:s")."
    </div>";
    
    $result = sendMail("Contactformulier van koor",$message,$contactEmail);
    echo $result;
}
else {
    echo "2";
}
?>