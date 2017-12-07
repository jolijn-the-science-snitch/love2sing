<?php
require 'header.php';
?>
<!-- Styling -->
<style type="text/css">
    .thumbnails {
       
        height: 80px;
        margin-bottom: 50px;
        overflow: hidden;
        transition: .5s all;
            left: 0px;
            position: relative;
            
    }    
    
	.thumbnails img {
		height: 80px;
		border: 2px solid #857991;
		padding: 1px;
		margin: 0 5px 0 5px;
                width: 140px;
                
	}
        
        .thumbnails ul li {
                float: left;
        }
        .thumbnails ul {
            
            list-style: none;
            margin: 0px;
            
        }
	.thumbnails img:hover {
		border: 2px solid #685e79;
		cursor:pointer;
	}

	.preview img {
		width: 100%;
	}
        .preview {
            border: 2px solid #857991;
            max-width: 800px;
            padding: 1px;
            background: #685e79;
            color: white;
        }
        
        
        .preview h2 {
            margin-top: 10px;
        }
        #back {
            float: left;
        }
        #next {
            float: right;
        }
        .control {
            font-size: 30px;
            z-index: 10;
        }
        .extraheight {
            height: 25px;
        }
        #slideshow {
            max-width: calc(140px * 8);
            overflow: hidden;
        }
</style>


<!-- Vormgeving -->
<section>
<div class="gallery" align="center">
<h2>Fotoalbum Love2Sing</h2>


<!-- Alle foto's in het klein -->
<div id="back" onclick="slide(1)" class="control"><div class="extraheight"></div><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
<div id="next" onclick="slide(-1)" class="control"><div class="extraheight"></div><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
<div id="slideshow">
<div class="thumbnails" id="slides">
    <ul> 
        <?php
        //Include database configuration file
        $db ="mysql:host=localhost;dbname=love2sing;port=3306";
        $user = "admin";
        $pass = "admin";
        $pdo = new PDO($db, $user, $pass);
        
        //get images from database
        $query = $pdo->query("SELECT * FROM photoalbum ORDER BY photoalbumId DESC");
        $preview = "Geen foto's om weer te geven";
        $i=0;
        if($query->rowCount() > 0){
            while($row = $query->fetch()){
                $imgSrc = $row["photoalbumUrl"];
                $description = $row["photoalbumDescription"];
                if ($i == 0) {
                    $preview = '<img name="preview" src="'.$imgSrc.'" alt=""/><h2 id="text">'.$description.'</h2>';
                }
                echo '<li><img style="left: 0px;" onclick="preview.src=img'.$i.'.src; document.getElementById(\'text\').innerHTML=img'.$i.'.alt" name="img'.$i.'" id="img'.$i.'" src="'.$imgSrc.'" alt="'.$description.'" /></li>';
                $i++;
            }
            
            echo "<style>.thumbnails { width: calc(150px * ".$i." + 150px) };</style>";
        }
        ?>
    </ul>
</div>
</div>
<!-- Grote foto preview -->
<div class="preview" align="center">
    <?= $preview ?>
</div>
</div>
</section> 


<script>
    var move = 0;
    function slide(direction) {      
    var width = $(window).width(); 
    if ((move > -<?= $i ?> + 1 || direction == -1) && (move < 1 || direction == 1) ) {
        var left = direction * -150 + move * 150;
        document.getElementById("slides").style.left = left + "px";
        move -= direction;
    }
        if (move == -<?= $i ?> || move == 1) {
            
        }
    }
</script>
<?php
        require 'footer.php';
?>
