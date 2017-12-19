<?php
include "includes/functions.php";
$msg = "";
//als de knop word ingedrukt
if (isset($_POST['upload'])) {
//Upload functie aanroepen
    
$file = $_FILES['image'];
$type = "jpg";
$name = "image";
$fileName = "test";
upload($file,$type,$name,$fileName);
$imgurl = $fileUrl[$name];        

// pad naar foto's

//Database verbinding
$db ="mysql:host=localhost;dbname=love2sing;port=3306";
$user = "admin";
$pass = "admin";
$pdo = new PDO($db, $user, $pass);

//Beschrijving foto
$text = $_POST['text'];

$sql = "INSERT INTO photoalbum(photoalbumUrl, photoalbumDescription) VALUES ('$imgurl', '$text')";
$stmt = $pdo->prepare($sql);
$stmt->execute();
echo $stmt->rowCount();
}
?>
<html>
    <head>
        <title>Foto uploaden</title>
    </head>  
    <body>
        <div id="content">
            <form method="post" enctype="multipart/form-data">
                <input type ="hidden" name="size" value="1000000">
                <div>
                    <input type ="file" name="image">
                </div>
                <div>
                    <textarea name="text" cols="40" rows="4" placeholder="Vertel wat over deze foto."></textarea>
                </div>
                <input type ="submit" name ="upload" value ="Upload Image">
                <div>
            </form>
            
        </div>
    </body>
</html>
