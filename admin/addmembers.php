<?php
include("adminpageheader.php");
$formStyle = "";
$buttonstyle = "style='display: none;'";
?>

<?php
require_once '../includes/functions.php'; //connect database en functies
if (isset($_POST['username']) && isset($_FILES['fileToUpload'])) {
    // als er een bestand is geupload een naam is ingevuld
    $username = $_POST['username'];
    $file = $_FILES['fileToUpload'];
    $type = array("jpg","jpeg");

    //Upload functie aanroepen
    $result = fileUpload($file,$type);
    $fileName = $result[0]; // bestandsnaam voor in de database

    if ($result[1] === 1) {
        // check of uploaden is gelukt, zo ja sql query uitvoeren
        $statement = $db->prepare("INSERT INTO facemap(facemapUrl, facemapName) VALUES(:facemapUrl, :facemapName)");
        $statement->execute(array(
            'facemapUrl' => $fileName,
            'facemapName' => $username
        ));
        if  ($statement->rowCount() == 1) {
            // als sql query goed is uitgevoerd een melding geven
            message("success",'Succesvol toegevoegd!',"Deze persoon is succesvol toegevoegd");
            $formStyle = "style='display: none'";
            $buttonstyle = "";
        }
        else {
            message("danger",'Database fout',"Deze persoon is niet toegevoegd");         
        }
    }
} 
else {
}
?>
<section>   
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading text-uppercase">Voeg koorlid toe aan het smoelenboek</h2>
            </div>
        </div>

        <form action='addmembers.php' method="post" enctype="multipart/form-data">
            <div id="musicform" <?= $formStyle ?> >
                <div class="row">
                    <div class="col md6">
                        <h3>Lid Toevoegen</h3>
                        <div class="form-group">
                            <label for="username">Voor- en achternaam</label>
                            <input type="text" class="form-control" id="username" placeholder="naam achternaam" name="username" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1"> Selecteer een plaatje om toe te voegen:</label>
                            <input type="file" class="form-control" name="fileToUpload" id="fileToUpload" required><br><br>
                            <input type="submit" value="Persoon toevoegen" name="submit" class="btn btn-primary btn-xl text-uppercase">
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </form>
        <div id="message"></div>
        <br><br>
        <a id="addMore" class="btn btn-primary btn-xl text-uppercase" href="addmembers.php" <?= $buttonstyle ?> >Voeg nog een koorlid toe</a>
    </div>
</section>

<?= $message ?>

<? require_once '../footer.php' ?>
