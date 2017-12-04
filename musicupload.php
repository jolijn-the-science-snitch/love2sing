<?php
require 'header.php';
?>

<!-- javascripts inporteren -->
<script src="js/functions.js"></script>

<?php
include("includes/functions.php");
// moet vervangen worden door inlog check
$user= "root";
$password= "";
$db = new PDO('mysql:host=localhost;dbname=love2sing', $user, $password);
//

$formStyle = ""; // formulier zichtbaar
$message = ""; // melding is leeg
$uploadMoreStyle = 'style="display: none;"'; // upload meer button onzichtbaar
$addComponistStyle = 'style="display: none;"'; // componist toevoegen iframe onzichtbaar

// checken of het formulier is verzonden
if (isset($_POST["title"]) && isset($_POST["componist"]) && isset($_POST["genre"]) && isset($_POST["pitch"])) {
    $message = "<script>"; // begin van mogelijkheid om meldingen weer te geven

    // componistId bij componist naam selecteren
    $stmt = $db->prepare("SELECT componistId FROM componist WHERE componistName = :componist");
    $stmt->bindParam(':componist', $componist);
    $componist = $_POST["componist"];
    $stmt->execute();

    $componistId = null;

    while ($row = $stmt->fetch())
    {
        $componistId = $row["componistId"];
    }

    // check of componistId gevonden is, zo nee:
    // - foutmelding weergeven
    // - componist toevoegen zichtbaar maken
    $componistExist = false; 
    if (empty($componistId)) {
        if (!empty($_POST["componistName"]) && !empty($_POST["componistDate"])) {
            $stmt = $db->prepare("INSERT INTO componist (componistName, componistYearOfBirth) VALUES(:componistName, :componistYearOfBirth)");

            $stmt->bindParam(':componistName', $componistName);
            $stmt->bindParam(':componistYearOfBirth', $componistYearOfBirth);

            $componistName = $_POST["componistName"];
            $componistYearOfBirth = date("Y-m-d",strtotime($_POST["componistDate"]));


            $stmt->execute();


            if($stmt->rowCount() == 1) {
                $message .= 'message("success", "Componist opgeslagen", "'.$componistName.' is succesvol toegevoegd");';

                $stmt = $db->prepare("SELECT componistId FROM componist WHERE componistName = :componist");
                $stmt->bindParam(':componist', $componist);
                $componist = $_POST["componist"];
                $stmt->execute();

                $componistId = null;

                while ($row = $stmt->fetch())
                {
                    $componistId = $row["componistId"];
                }
                if (!empty($componistId)) {
                    $componistExist = true;     
                }
            }
            else {
                $message .= 'message("danger", "Componist is niet opgeslagen", "Er is een technishe fout opgetreden");';
            }
        }
        else {
            $message .= 'message("danger", "' . $componist . ' is niet bekend", "Vul <a href=\"javascript:addComponist()\" class=\"alert-link\">hier</a> de gegevens van de componist in, zodat dit muziekstuk kan worden toegevoegd"); ';
//            $formStyle = ' style="display: none;" ';
            $addComponistStyle = "";
        }
    }
    else {
        $componistExist = true;
    }

    $stmt = null;
    // componist is toegevoegd of bestaat
    if ($componistExist) {
        // query voorbereiden met alle gegevens die gepost zijn
        $stmt = $db->prepare("INSERT INTO music (musicName, componistId, musicPitch, musicPdf, musicMp3) VALUES(:musicName, :componistId, :musicPitch, :musicPdf, :musicMp3)");

        $stmt->bindParam(':musicName', $musicName);
        $stmt->bindParam(':componistId', $componistId);
        $stmt->bindParam(':musicPitch', $musicPitch);
        $stmt->bindParam(':musicPdf', $musicPdf);
        $stmt->bindParam(':musicMp3', $musicMp3);

        $musicName = $_POST["title"];
        $musicPitch = $_POST["pitch"];
        $genre = $_POST["genre"];
        $musicMp3 = null;
        $musicPdf = null;

        // controleren of er een bestand verzonden is, en zo ja: 
        // - bestand een tijdelijke naam geven waarmee opslaglocatie kan worden uitgelezen
        // - bestand uploaden functie aanroepen uit functions.php:81
        // - url naar bestand omzetten in variable die in database wordt opgeslagen

        if (isset($_FILES["mp3"]["name"])) {
            $name = "mp3-file";
            $fileUpload["mp3"] = upload($_FILES["mp3"],"mp3",$name);   
            $musicMp3 = $fileUrl[$name];
        }
        if (isset($_FILES["pdf"]["name"])) {
            $name = "pdf-file";
            $fileUpload["pdf"] = upload($_FILES["pdf"],"pdf",$name);
            $musicPdf = $fileUrl[$name];
        }
        // (fout) meldingen weergeven
        // code's: 
        // 0    technische fout
        // 1    gelukt
        // 2    bestand bestaat al
        // 3    bestand is te groot
        // 4    bestandstype is verkeerd
        // 5    er is geen bestand gekozen of bijgevoegd

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

        // nadat alles gereed is de query uitvoeren
        $stmt->execute();

        if($stmt->rowCount() == 1) {
            $message .= 'message("success", "Muziekstuk opgeslagen", "Het muziekstuk is succesvol toegevoegd");';
            $formStyle = ' style="display: none;" ';
            $uploadMoreStyle = '';
            // na succesvol uitvoeren van query een meling weergeven, het uploadformulier onzichtbaar maken en de upload meer knop zichtbaar maken
        }
        else {
            $message .= 'message("danger", "Muziekstuk is niet opgeslagen", "Het muziekstuk is niet toegevoegd");';
            // bij het mislukken van de query een foutmelding weergeven
        }
    } 

    $message .= "</script>"; // einde van mogelijkheid om meldingen weer te geven
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
                <form id="musicForm" name="uploadMusic" method="post" onsubmit="sendButton('Muziek uploaden...',true,'uploadButton'); checkdatalist()" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Informatie muziekstuk</h3>
                            <div id="musicform" <?= $formStyle ?> >
                                <div class="form-group">
                                    Titel
                                    <input class="form-control" id="title" name="title" type="text" placeholder="Titel muziekstuk" required data-validation-required-message="Vul a.u.b een titel in">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group" id="componistinput">
                                    Componist
                                    <input class="form-control" list="componistlist" name="componist" id="componist" placeholder="componist" required data-validation-required-message="Vul a.u.b een genre in" onkeyup="checkdatalist()">
                                    <datalist id="componistlist">

                                        <?php
    $stmt2 = $db->prepare("SELECT componistId, componistName FROM componist ORDER BY componistName");
                                 $stmt2->execute();
                                 while ($row = $stmt2->fetch())
                                 {
                                     echo '<option value="'.$row["componistName"].'" />';
                                 }
                                        ?>

                                    </datalist>
                                    <p class="help-block text-danger"></p>

                                    <script>
                                        function checkdatalist() {
                                            messageCount = 0;
                                            var val=$("#componist").val();
                                            var obj=$("#componistlist").find("option[value='"+val+"']")
                                            if(obj !=null && obj.length>0) {
                                                document.getElementById('message').innerHTML = "";
                                                return true;
                                            }
                                            else {
                                                document.getElementById('message').innerHTML = "";
                                                message("info", "Deze componist is onbekend", 'Klik <a href="javascript:addComponist()" class="alert-link">hier</a> om de componist aan te maken'); // don't allow form submission
                                                return false;
                                            }
                                        }
                                    </script>

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

                                <div id="addcomponist" style="display: none;"> 
                                    <h3>Componist</h3>
                                    <div class="form-group">
                                        Naam
                                        <input class="form-control" id="componistName" name="componistName" type="text" placeholder="Componist naam" >
                                    </div>
                                    <div class="form-group">
                                        Geboortedatum
                                        <input class="form-control" id="componistDate" name="componistDate" type="date" >
                                    </div>
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
                                <button id="uploadButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Uploaden</button>
                                
                            </div>

                            <div id="message"></div>
                            <a id="uploadMore" class="btn btn-primary btn-xl text-uppercase" href="musicupload.php" <?= $uploadMoreStyle ?> >Upload nog een muziekstuk</a>
                        </div>
                    </div>
                </form>

                <script>
                    function addComponist() {
                        document.getElementById('addcomponist').style.display = 'block';
                        document.getElementById('componistName').value = document.getElementById('componist').value;

                        document.getElementById('componistinput').style.display = 'none';
                    }
                </script>


            </div>
        </div>
    </div>
</section>

<!-- melingen weergeven -->
<?= $message ?>



<?php
    require 'footer.php';
?>
