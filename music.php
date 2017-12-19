<!---Start Includes--->
<?php  
include "header.php";
?>
<!---End Includes--->

<!---Start Getting data from database--->
<?php
$stmt= $db ->prepare("SELECT * FROM music JOIN componist ON music.componistId=componist.componistId");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
?>
<!---End Getting  data from database--->

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UFT-8">
        <title>Love2Sing</title>
        <!---Start Linking--->
        <link href="style.css" rel="stylesheet" type="text/css">
        <!---End Linking--->
    </head>

    <section>
        <!---Start Main--->
        <!---Start Search Bar--->
        <h1 class="title">Muziekbibliotheek</h1>
        <div class="searchBar">
            <form class="form-wrapper cf" method="POST" action="functions.php">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <input class="form-control" type="text" name="q" placeholder="Zoek op muzieknaam of componist">
                    </div>
                    <div class="col-lg-3 col-sm-12">

                        <select class="form-control" name="column">
                            <option class="option" value="0">Muzieknaam</option>
                            <option class="option" value="1">Componist</option>
                        </select>
                    </div>
                       <div class="col-lg-3 col-sm-12">
                        <input class="search btn btn-primary text-uppercase"  type="submit" name="submit" value="Zoeken">
                    </div>
                    </div>
                    </form>
                </div>

            <br><br>

            <!---End Search Bar--->

            <!---Start Box--->
            <div class="results">
                <div class="row">
                    <?php
                    if ($stmt->rowCount() > 0){
                        while($row = $stmt->fetch()){
                            echo '<div class="col-lg-4 col-sm-12">';
                            echo '<div class="musicBox">';
                            echo '<h1>';
                            echo $row['musicName'];
                            echo '</h1>';
                            echo '<br><p><b>Componist: </b>';
                            echo $row['componistName'];
                            echo '<p><b>Geboortedatum componist: </b>';
                            echo $row['componistYearOfBirth'];
                            echo '</p><p><b>Pitch: </b>';
                            echo $row['musicPitch'];
                            echo '</p><p>';
                            echo '<a href="'.$row['musicMp3'].'" download><img src="uploads/play-button_318-42541.jpg" height=100px></a>';
                            echo '<a href="'.$row['musicPdf'].'" download><img src="uploads/images.jpg" height=100px></a>';
                            echo '</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }

                    ?>
                </div>
            </div>
            <!---End Box--->

            <!---End Main--->
            </section>
        <?php
        require 'footer.php';
        ?>