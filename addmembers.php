<?php
    include("adminpageheader.php");
    $formstyle = "";
    $buttonstyle = "style='display: none;'";
?>
<body>
	<div class="container">

		<div class="page-header text-center">
			<h1 class="display-4">Voeg koorlid toe aan het smoelenboek</h1>
		</div>

		<div class="jumbotron" style="padding: 10px;margin-top:20px;">
            <h3>Lid Toevoegen</h3><br>
            <form action='addmembers.php' method="post" enctype="multipart/form-data">
                <div class="form-group required">
                    <label for="username">Voor- en achternaam</label>
                    <input type="text" class="form-control" id="username" placeholder="naam achternaam" name="username" required>
                </div>
                <div class="form-group required">
                    <label for="exampleFormControlFile1"> Selecteer een plaatje om toe te voegen:</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
                    <input type="submit" value="Persoon toevoegen" name="submit" class="btn btn-primary">
                </div>
			</form>
            <h5>
                <?php
                if (isset($_SESSION['uploadError'])) {
                    echo 'Melding: ' . $_SESSION['uploadError'];
                }
                ?>
            </h5><br><br>
            <a href="../overzicht.php">Overzicht</a>
		</div>
		<? require_once '../scripts.php' ?>
    </div>
<? require_once '../footer.php' ?>

<?php

require_once '../includes/functions.php'; //connect database
require_once '../upload.php'; //require de upload functie in upload.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Query voor het toevoegen van Leden
	if(isset($_POST['username']) === false) {
        $_SESSION['uploadError'] = 'Je hebt een foutje gemaakt';
        header('Location: /KBS/love2sing/admin/addmembers.php'); exit;
	}

    //Upload functie aanroepen
    $file = $_FILES['fileToUpload'];
    $username = $_POST['username'];

    $fileName = uploadImage($file);

    if ($fileName === false) {
        $_SESSION['uploadError'] = 'Je bestand is kapot ofzo';
        header('Location: /KBS/love2sing/admin/addmembers.php'); exit;
    }

    $statement = $db->prepare("INSERT INTO facemap(facemapUrl, facemapName) VALUES(:facemapUrl, :facemapName)");

    $result = $statement->execute(array(
        'facemapUrl' => $fileName,
        'facemapName' => $username
    ));
    var_dump($result);
    if ($result === true) {
        $_SESSION['uploadError'] = 'Succesvol toegevoegd!';
        header('Location: /KBS/love2sing/admin/addmembers.php'); exit;
    }
} else {
    $_SESSION['uploadError'] = 'Vul alles in';

}

?>