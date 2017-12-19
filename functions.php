<!---Link To CSS--->
<html>
<head>
<link href="style.css" type="text/css" rel="stylesheet">    
</head>
</html>
<!---Start Database Connection--->
<?php
include("includes/functions.php");

    $conn = $db;
?>
    <!--- End Database Connection--->

    <!---Start Search Bar--->
    <?php
    if (isset($_POST['submit'])){
        $columnnaam = $_POST['column'];
        $zoekopdracht = $_POST['q'];
        if ($columnnaam == '0'){
            $result = $conn->prepare("SELECT * FROM music JOIN componist ON componist.componistId = music.componistId WHERE musicName LIKE '%$zoekopdracht%'");
            $result->execute(array($zoekopdracht));
            $result->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $result->fetch()){
                echo '<div class="musicBox">';
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
                echo '</div>';}
        } elseif ($columnnaam == '1'){
            $result = $conn->prepare("SELECT * FROM music JOIN componist ON componist.componistId = music.componistId WHERE componistName LIKE '%$zoekopdracht%'");
            $result->execute(array($zoekopdracht));
            $result->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $result->fetch()) {
                echo '<div class="musicBox">';
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
                echo '</div>';}
        } if ($result->rowCount() == 0){ 
           echo "Geen resultaten gevonden.";
    }} 
?>
        <!---End Search Bar--->
