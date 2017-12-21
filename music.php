<!---Start Includes--->
<?php  
include "header.php";
?>
<!---End Includes--->



<style>
    .row {
        margin: 0px;
    }
</style>


<section>
    <!---Start Main--->
    <!---Start Search Bar--->
    <h2 class="section-heading text-uppercase text-center">Muziekbibliotheek</h2>
    <hr class="my-4">
    <div class="searchBar">
        <form class="form-wrapper cf" method="POST" >
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
            if (isset($_POST['submit'])){
                $columnnaam = $_POST['column'];
                $zoekopdracht = $_POST['q'];
                if ($columnnaam == '0'){
                    $result = $db->prepare("SELECT * FROM music JOIN componist ON componist.componistId = music.componistId WHERE musicName LIKE '%$zoekopdracht%'");
                    $result->execute(array($zoekopdracht));
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    while ($row = $result->fetch()){
                        echo '<div class="col-lg-4 col-sm-12">';
                        echo '<div class="card" style="margin: 20px 0;">';
						echo '<div class="card-body">';
                        echo '<h1>';
                        echo $row['musicName'];
                        echo '</h1>';
                        echo '</h2> <p><b>Componist: </b>';
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
                        echo '</div>';
                    }
                } elseif ($columnnaam == '1'){
                    $result = $db->prepare("SELECT * FROM music JOIN componist ON componist.componistId = music.componistId WHERE componistName LIKE '%$zoekopdracht%'");
                    $result->execute(array($zoekopdracht));
                    $result->setFetchMode(PDO::FETCH_ASSOC);
                    while ($row = $result->fetch()) {
                        echo '<div class="col-lg-4 col-sm-12">';
                        echo '<div class="card" style="margin: 20px 0;">';
						echo '<div class="card-body">';
                        echo '<h1>';
                        echo $row['musicName'];
                        echo '</h1>';
                        echo '</h2> <p><b>Componist: </b>';
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
                        echo '</div>';
                    }
                } if ($result->rowCount() == 0){ 
                    echo "Geen resultaten gevonden.";
                }
            }
            else {
                $stmt= $db ->prepare("SELECT * FROM music JOIN componist ON music.componistId=componist.componistId");
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                if ($stmt->rowCount() > 0){
                    while($row = $stmt->fetch()){
                        echo '<div class="col-lg-4 col-sm-12">';
                        echo '<div class="card" style="margin: 20px 0;">';
						echo '<div class="card-body">';
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
                        echo '<a href="'.$row['musicMp3'].'" download><img src="img/mp3.jpg" height=100px></a>';
                        echo '<a href="'.$row['musicPdf'].'" download class="float-right" ><img src="img/pdf.jpg" height=100px></a>';
                        echo '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
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