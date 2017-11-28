<?php
    require 'header.php';
?>

    <!-- scripts voor uploadformulier -->

    <script src="js/functions.js"></script>

    <script>
        function sendButton(buttonText, pointerStyle, loading) {
            if (loading) {
                buttonText = '<i class="fa fa-circle-o-notch fa-spin"></i> ' + buttonText;
            }
            document.getElementById('sendMessageButton').innerHTML = buttonText;
            document.getElementById('title').style.pointerEvents = pointerStyle;
            document.getElementById('componist').style.pointerEvents = pointerStyle;
            document.getElementById('genre').style.pointerEvents = pointerStyle;
        }
    </script>

    <?php

$formStyle = "";
$message = "";
$uploadMoreStyle = 'style="display: none;"';

if (isset($_POST["title"]) && isset($_POST["componist"]) && isset($_POST["genre"]) && isset($_POST["pitch"])) {
    $message = "<script>";

    $user= "root";
    $password= "";
    $db = new PDO('mysql:host=localhost;dbname=love2sing', $user, $password);
    
    $stmt = $db->prepare("SELECT componistId FROM componist WHERE componistName = :componist");
    $stmt->bindParam(':componist', $componist);
    $componist = $_POST["componist"];
    $stmt->execute();
    
    $componistId = null;
    $musicPdf = null;
    $musicMp3 = null;
        
    while ($row = $stmt->fetch())
    {
        $componistId = $row["componistId"];
    }

    if (empty($componistId)) {
        $message .= 'message("danger", "' . $componist . ' is niet bekend", "Vul hieronder de gegevens van de componist in, zodat dit muziekstuk kan worden toegevoegd"); ';
        $formStyle = ' style="display: none;" ';

        //$componistId = 1;
        // componist toevoegen en vragen om geboorte jaar
    }
 
    //echo "Componist ID" . $componistId . "<br>";    

    
    $stmt = $db->prepare("INSERT INTO music (musicName, componistId, musicPitch, musicPdf, musicMp3) VALUES(:musicName, :componistId, :musicPitch, :musicPdf, :musicMp3)");
        
    $stmt->bindParam(':musicName', $musicName);
    $stmt->bindParam(':componistId', $componistId);
    $stmt->bindParam(':musicPitch', $musicPitch);
    $stmt->bindParam(':musicPdf', $musicPdf);
    $stmt->bindParam(':musicMp3', $musicMp3);
    
    $musicName = $_POST["title"];
    $musicPitch = $_POST["pitch"];
    $genre = $_POST["genre"];
    
    $fileUpload["mp3"] = null;
    
    if (isset($_FILES["mp3"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["mp3"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if (file_exists($target_file)) {
            //echo "Er bestaat al een bestand met dezelfde naam.";
            $uploadOk = 0;
            $fileUpload["mp3"] .= "2";
        }
        // Check file size
        if ($_FILES["mp3"]["size"] > 2500000) {
            //echo "Het bestand is te groot, ". $_FILES["mp3"]["size"] / 1000000 ."MB, max 2.5MB";
            $uploadOk = 0;
            $fileUpload["mp3"] .= "3";
        }
        // Allow certain file formats
        if($fileType != "mp3") {
            //echo "Alleen mp3 is toegestaan";
            $uploadOk = 0;
            $fileUpload["mp3"] .= "4";
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Het bestand is niet geupload.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["mp3"]["tmp_name"], $target_file)) {
                //echo "Het bestand ". basename( $_FILES["mp3"]["name"]). " is geupload.";
                $musicMp3 = $target_file;
                $fileUpload["mp3"] = 1;
            } else {
                $uploadOk = 0;
                $fileUpload["mp3"] = 0;
                //echo "Sorry, there was an error uploading your file.";
            }
        }
        
        if ($_FILES["mp3"]["error"] == 4) {
            $fileUpload["mp3"] = 5;   
        }
    }
    else {
        $fileUpload["mp3"] = null;
    }
    
    $fileUpload["pdf"] = null;
    
    if (isset($_FILES["pdf"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
        $uploadOk = 1;
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if (file_exists($target_file)) {
            //echo "Er bestaat al een bestand met dezelfde naam.";
            $fileUpload["pdf"] .= "2";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["pdf"]["size"] > 2500000) {
            //echo "Het bestand is te groot, ". $_FILES["pdf"]["size"] / 1000000 ."MB, max 2.5MB";
            $fileUpload["pdf"] .= "3";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($fileType != "pdf") {
            //echo "Alleen pdf is toegestaan";
            $fileUpload["pdf"] .= "4";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Het bestand is niet geupload.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_file)) {
                //echo "Het bestand ". basename( $_FILES["pdf"]["name"]). " is geupload.";
                $musicPdf = $target_file;
                $fileUpload["pdf"] = 1;
            } else {
                $uploadOk = 0;
                $fileUpload["pdf"] = 0;
                //echo "Sorry, there was an error uploading your file.";
            }
        }
        
        if ($_FILES["pdf"]["error"] == 4) {
            $fileUpload["pdf"] = 5;   
        }
    }
    else {
        $fileUpload["pdf"] = null;
    }
    
    
    //print_r($fileUpload);
    
    foreach ($fileUpload as $key => $value) {
        if (preg_match('/1/',$value)) {
            $message .= 'message("success", "' . $key . ' is succesvol opgeslagen", "Het bestand ' . basename($_FILES[$key]["name"]) . ' is succesvol toegevoegd"); ';
        }
        elseif (preg_match('/2/',$value)) {
            $message .= 'message("warning", "' . $key . ' is niet opgeslagen", "Het bestand ' . basename($_FILES[$key]["name"]) . ' bestaat al"); ';
        }
        elseif (preg_match('/3/',$value)) {
            $message .= 'message("warning", "' . $key . ' is niet opgeslagen", "Het bestand ' . basename($_FILES[$key]["name"]) . ' is te groot '. $_FILES["pdf"]["size"] / 1000000 .'MB, max 2.5MB"); ';
        }
        elseif (preg_match('/4/',$value)) {
            $message .= 'message("warning", "' . $key . ' is niet opgeslagen", "Het bestand ' . basename($_FILES[$key]["name"]) . ' is geen pdf"); ';
        }
        elseif (preg_match('/0/',$value)) {
            $message .= 'message("danger", "' . $key . ' is niet opgeslagen", "Er is een technische fout opgetreden"); ';
        }
        else {
            $message .= 'message("info", "Er is geen ' . $key . ' bijgevoegd", "Dit muziekstuk heeft geen ' . $key . '"); ';
        }
    }    
    
    if (count($fileUpload) == 0 || count($_FILES) == 0) {
        $message .= 'message("danger", "De geuploade bestanden zijn niet opgeslagen", "Er is een technische fout opgetreden, mogelijk is het bestand groter dan 10MB"); '; //php.ini max staat op 10MB
    }
    
    
    $stmt->execute();
    
    
    if($stmt->rowCount() == 1) {
        $message .= 'message("success", "Muziekstuk opgeslagen", "Het muziekstuk is succesvol toegevoegd");';
        
        $formStyle = ' style="display: none;" ';
        $uploadMoreStyle = '';
    }
    else {
        $message .= 'message("danger", "Muziekstuk is niet opgeslagen", "Het muziekstuk is niet toegevoegd");';
    }
    
    
    $message .= "</script>";
    
}
?>










        <section id="musicupload">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="section-heading text-uppercase">Upload muziek</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form id="musicForm" name="uploadMusic" method="post" onsubmit="sendButton('Muziek uploaden...','none',true)" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Informatie muziekstuk</h3>
                                    <div id="musicform" <?= $formStyle ?> >
                                        <div class="form-group">
                                            Titel
                                            <input class="form-control" id="title" name="title" type="text" placeholder="Titel muziekstuk" required data-validation-required-message="Vul a.u.b een titel in">
                                            <p class="help-block text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            Componist
                                            <input class="form-control" list="componistlist" name="componist" id="componist" placeholder="componist" required data-validation-required-message="Vul a.u.b een componist in">
                                            <datalist id="componistlist">
                                                <option value="Bach">
                                                <option value="Beethoven">
                                                <option value="Händel">
                                                <option value="Iemand">
                                                <option value="Nog een naam">
                                            </datalist>
                                            <p class="help-block text-danger"></p>
                                        </div>
                                        <div class="form-group">
                                            Genre
                                            <input class="form-control" list="genrelist" name="genre" id="genre" placeholder="genre" required data-validation-required-message="Vul a.u.b een genre in">
                                            <datalist id="genrelist">
                                                <option value="Klassiek">
                                                <option value="Pop">
                                                <option value="Jazz">
                                                <option value="Opera">
                                                <option value="Nog een">
                                            </datalist>
                                            <p class="help-block text-danger"></p>
                                        </div>

                                        <h3>Audio</h3>
                                        <div class="form-group">
                                            <input class="form-control" id="mp3" name="mp3" type="file" placeholder="Titel muziekstuk" accept=".mp3">
                                            <p class="help-block text-danger"></p>
                                        </div>

                                        <div class="form-group">
                                            Pitch <span class="glyphicon glyphicon-ok"></span>
                                            <input class="form-control" id="pitch" name="pitch" type="text" placeholder="Titel muziekstuk" required data-validation-required-message="Vul a.u.b een titel in">
                                            <p class="help-block text-danger"></p>
                                        </div>

                                        <h3>Bladmuziek</h3>
                                        <div class="form-group">

                                            <input class="form-control" id="pdf" name="pdf" type="file" placeholder="Titel muziekstuk" accept=".pdf">
                                            <p class="help-block text-danger"></p>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div id="success"></div>
                                        <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Uploaden</button>
                                    </div>

                                    <div id="message"></div>
                                    <a id="uploadMore" class="btn btn-primary btn-xl text-uppercase" href="musicupload.php" <?= $uploadMoreStyle ?> >Upload nog een muziekstuk</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?= $message ?>


            <?php
    require 'footer.php';
?>
