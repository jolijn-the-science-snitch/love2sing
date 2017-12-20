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
        transition: .5s all;
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
        position: relative;
        top: 50%;
    }
    .extraheight {
        height: 25px;
    }
    #slideshow {
        max-width: calc(140px * 8);
        overflow: hidden;
    }
    .a-img:focus img {
        filter: grayscale(1);
    }

    .photoview {
        /*        max-height: calc(100% - 350px);*/
        margin: 0px;

    }
    #photoalbum {
        padding-bottom: 0px;

    }
</style>


<!-- Vormgeving -->
<section id="photoalbum">
    <div class="gallery" align="center">
        <h2>Fotoalbum Love2Sing</h2>


        <!-- Alle foto's in het klein -->



        <div id="slideshow">
            <div class="thumbnails" id="slides">
                <ul> 
                    <?php
                    //Include database configuration file
                    //get images from database
                    $query = $db->query("SELECT * FROM photoalbum ORDER BY photoalbumId DESC");
                    $preview = "Geen foto's om weer te geven";
                    $i = 0;
                    if ($query->rowCount() > 0) {
                        while ($row = $query->fetch()) {
                            $imgSrc = $row["photoalbumUrl"];
                            $description = $row["photoalbumDescription"];
                            if ($i == 0) {
                                $preview = '<img name="preview" src="' . $imgSrc . '" alt=""/>';
                                $h2 = '<h2 id="text">' . $description . '</h2>';
                            }
                            echo '<li><a class="a-img" id="imga' . $i . '" href="#"><img id="img' . $i . '" style="left: 0px;" onclick="preview.src=img' . $i . '.src; document.getElementById(\'text\').innerHTML=img' . $i . '.alt" name="img' . $i . '"  src="' . $imgSrc . '" alt="' . $description . '" /></a></li>';
                            $i++;
                        }
                        echo "<style>.thumbnails { width: calc(150px * " . $i . " + 150px) };</style>";
                    }
                    ?>
                </ul>
            </div>
        </div>


        <!-- Grote foto preview -->


        <div class="row photoview">
            <div class="col">
                <div id="back" onclick="slide(-1)" class="control"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
            </div>
            <div class="col-8 preview"><?= $preview ?><?= $h2 ?></div>
            <div class="col">
                <div id="next" onclick="slide(1)" class="control"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
            </div>

        </div>




    </div>
</section> 


<script>
    var move = 0;
    function slide(direction) {
        var width = $(window).width();
        if ((move > -<?= $i ?> + 1 || direction == -1) && (move < 1 || direction == 1)) {
            var left = direction * -150 + move * 150;
            document.getElementById("slides").style.left = left + "px";
            move -= direction;
            var imgid = "#img" + move * -1;
            var imgaid = "#imga" + move * -1;
            //alert(imgid);
            $(imgid).click();
            $(imgaid).click();
        }
        if (move == -<?= $i ?> || move == 1) {
        }
    }
</script>
<?php
    require 'footer.php';
?>