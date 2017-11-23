<?php
if (isset($_POST['contactName']) && isset($_POST['contactEmail']) && isset($_POST['contactMessage'])) {   
    $contactName = $_POST['contactName'];
    $contactEmail = $_POST['contactEmail'];
    $contactMessage = nl2br($_POST['contactMessage']);

    $to = "whnijsink@gmail.com";
    $subject = "Contactformulier van koor";
    $message = "
    <h1 style='font-size: 22px;'>Het contact formulier is ingevuld door ".$contactName."</h1>
    
    <h2 style='font-size: 18px;'>Het volgende bericht is gestuurd:</h2>
    
    <p style='font-size: 14px;'>". $contactMessage."</p>
    <h2 style='font-size: 18px;'>Gegevens:</h2>
    <b>Naam: </b>".$contactName."<br>
    <b>E-mail: </b>".$contactEmail."<br>
    <b>Verstuurd op: </b>".date("Y-m-d");
    $headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: '.$contactEmail.'' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $headers .= "MIME-Version: 1.0\r\n";
    $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";

    echo $message;
    mail($to,$subject, $message, $headers);
}
else {
    echo "error";
}
?>