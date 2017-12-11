<?php
include("adminpageheader.php"); 
$formStyle = ""; // formulier zichtbaar
$message = ""; // melding is leeg
$uploadMoreStyle = 'style="display: none;"'; // upload meer button onzichtbaar
$addComponistStyle = 'style="display: none;"'; // componist toevoegen iframe onzichtbaar

// checken of het formulier is verzonden
if (isset($_POST["title"]) && isset($_POST["componist"]) && isset($_POST["pitch"])) {
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
    // foutmelding weergeven
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
                message("success", "Componist opgeslagen", $componistName." is succesvol toegevoegd");
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
                message("danger", "Componist is niet opgeslagen", "Er is een technishe fout opgetreden");
            }
        }
        else {
            message("danger", "" . $componist . " is niet bekend", 'Vul <a href=\"javascript:addComponist()\" class=\"alert-link\">hier</a> de gegevens van de componist in, zodat dit muziekstuk kan worden toegevoegd'); 
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
        $musicMp3 = null;
        $musicPdf = null;

        // controleren of er een bestand verzonden is, en zo ja: 
        // - bestand uploaden functie aanroepen uit functions.php
        //      - functie maakt meldingen aan
        //      - hier een melding maken als er geen bestand is bijgevoegd
        // - url naar bestand omzetten in variable die in database wordt opgeslagen

        if (isset($_FILES["mp3"]["name"])) {
            $result = fileUpload($_FILES["mp3"],"mp3");   
            if ($result[1] == 5) {
                message("info", "Er is geen mp3 bijgevoegd", "Dit muziekstuk heeft geen mp3");
            } 
            $musicMp3 = $result[0];
        }
        else {
            message("info", "Er is geen mp3 bijgevoegd", "Dit muziekstuk heeft geen mp3");
        }

        if (isset($_FILES["pdf"]["name"])) {
            $result = fileUpload($_FILES["pdf"],"pdf");
            if ($result[1] == 5) {
                message("info", "Er is geen pdf bijgevoegd", "Dit muziekstuk heeft geen pdf");
            } 
            $musicPdf = $result[0];
        }
        else {
            message("info", "Er is geen pdf bijgevoegd", "Dit muziekstuk heeft geen pdf");
        }
        // nadat alles gereed is de query uitvoeren
        $stmt->execute();

        if($stmt->rowCount() == 1) {
            message("success", "Muziekstuk opgeslagen", "Het muziekstuk is succesvol toegevoegd");
            $formStyle = ' style="display: none;" ';
            $uploadMoreStyle = '';
            // na succesvol uitvoeren van query een meling weergeven, het uploadformulier onzichtbaar maken en de upload meer knop zichtbaar maken
        }
        else {
            message("danger", "Muziekstuk is niet opgeslagen", "Het muziekstuk is niet toegevoegd");
            // bij het mislukken van de query een foutmelding weergeven
        }
    } 
}
?>

<?php
// componist naam en geboortedatum ophalen en weergeven in datalist
$componistDatalist = "";
$stmt2 = $db->prepare("SELECT componistName FROM componist ORDER BY componistName");
$stmt2->execute();
while ($row = $stmt2->fetch())
{
    $componistDatalist .= '<option value="'.$row["componistName"].'" />';
}
?>

<section id="musicupload">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading text-uppercase">Upload muziek</h2>
            </div>
        </div>
        <form id="musicForm" name="uploadMusic" method="post" onsubmit="sendButton('Muziek uploaden...',true,'uploadButton')" enctype="multipart/form-data">
            <div id="musicform" <?= $formStyle ?> >
                <div class="row">
                    <div class="col md6">
                        <h3>Informatie muziekstuk</h3>
                        <div class="form-group">
                            Titel
                            <input class="form-control" id="title" name="title" type="text" placeholder="titel muziekstuk" required data-validation-required-message="Vul a.u.b een titel in">
                            <p class="help-block text-danger"></p>
                        </div>
                        <div class="form-group" id="componistinput">
                            Componist <span id="successText" class="text-success"></span>
                            <input class="form-control" list="componistlist" name="componist" id="componist" placeholder="componist" required data-validation-required-message="Vul a.u.b een componist in" onkeyup="checkdatalist(0)" onfocusout="checkdatalist(0)">
                            <datalist id="componistlist">
                                <?= $componistDatalist ?>
                            </datalist>
                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="form-group">
                            Pitch <span class="glyphicon glyphicon-ok"></span>
                            <input class="form-control" id="pitch" name="pitch" type="text" placeholder="pitch" required data-validation-required-message="Vul a.u.b een titel in">
                            <p class="help-block text-danger"></p>
                        </div>


                        <div id="addcomponist" style="display: none;"> 
                            <h3>Componist</h3>
                            <div class="form-group">
                                Naam
                                <input class="form-control" id="componistName" name="componistName" type="text" placeholder="Componist naam" 
                                       required data-validation-required-message="Vul a.u.b een naam in" >
                            </div>
                            <div class="form-group">
                                Geboortedatum
                                <input class="form-control" id="componistDate" name="componistDate" type="date" required data-validation-required-message="Vul a.u.b een datum in"  >
                            </div>
                        </div>
                    </div>
                    <div class="col md6">

                        <h3>Audio</h3>
                        <div class="form-group">
                            MP3 bestand
                            <input class="form-control" id="mp3" name="mp3" type="file" placeholder="Titel muziekstuk" accept=".mp3">
                            <p class="help-block text-danger"></p>
                        </div>


                        <h3>Bladmuziek</h3>
                        <div class="form-group">
                            PDF bestand
                            <input class="form-control" id="pdf" name="pdf" type="file" placeholder="Titel muziekstuk" accept=".pdf">
                            <p class="help-block text-danger"></p>
                        </div>



                    </div>
                    <div class="w-100"></div>

                    <div class="col">

                        <div class="clearfix"></div>
                        <div id="success"></div>
                        <button id="uploadButton" class="btn btn-primary btn-xl text-uppercase" type="submit" onclick="checkdatalist(1);">Uploaden</button>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">     
                    <div id="message"></div>
                    <?= $message ?>
                    <a id="uploadMore" class="btn btn-primary btn-xl text-uppercase" href="musicupload.php" <?= $uploadMoreStyle ?> >Upload nog een muziekstuk</a>
                </div>
            </div>
        </form>

        <script>
            var addcomponist = false;
            function addComponist() {
                var messageobj =  document.getElementById('message');
                messageobj.innerHTML = "";
                document.getElementById('addcomponist').style.display = 'block';
                document.getElementById('componistName').value = document.getElementById('componist').value;
                document.getElementById('componistinput').style.display = 'none';
                addcomponist = true;
            }

            var status = 1;
            function checkdatalist(i) {
                messageCount = 0;
                var val=$("#componist").val();
                var obj=$("#componistlist").find("option[value='"+val+"']")

                var required = true;
                var messageobj =  document.getElementById('message');

                var successText = document.getElementById("successText");
                var componistName = document.getElementById("componistName");
                var componistDate = document.getElementById("componistDate");
                if(obj !=null && obj.length>0) {
                    successText.innerHTML = "&#10003;"; // succesvinkje weergeven 
                    messageobj.innerHTML = ""; // meldingen verwijderen
                    required = false;
                    status = 1;
                }
                else {       
                    if (status == 1 || messageobj.innerHTML == "" || i == 1) { 
                        successText.innerHTML = ""; // succesvinkje verwijderen
                        messageobj.innerHTML = ""; // meldingen verwijderen
                        required = true; // 
                        status = 0;
                        if (i == 1) {
                            if (addcomponist == false) {
                                message("danger", "Deze componist is onbekend", 'Klik <a href="javascript:addComponist()" class="alert-link">hier</a> om de componist aan te maken'); 
                            }
                        }
                        else {
                            message("info", "Deze componist is onbekend", 'Klik <a href="javascript:addComponist()" class="alert-link">hier</a> om de componist aan te maken'); 

                        }                
                    }
                }
                componistName.required = required;
                componistDate.required = required;
            }
        </script>

    </div>
</section>

<!-- melingen weergeven -->


<?php
    include("adminpagefooter.php");
?>