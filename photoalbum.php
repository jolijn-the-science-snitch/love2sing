<?php
require 'header.php';
?>
<!-- Styling -->
<style type="text/css">
    .thumbnails {
        height: 80px;
        margin-bottom: 10px;
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
        /*        height: calc(100% - 450px);*/
        cursor: pointer;
    }
    .preview {

        overflow: hidden;
    }
    .preview h2 {
        border: 2px solid #857991;
        padding: 1px;
        background: #685e79;
        color: white;
        border-top: 0px;
    }
    .control {
        font-size: 30px;
        z-index: 10;
        position: relative;
        top: 50%;
        cursor: pointer;
        margin-left: auto;
        margin-right: auto;
    }
    .extraheight {
        height: 25px;
    }
    #slideshow {
        max-width: calc(140px * 8);
        overflow-x: auto;
        margin-bottom: 20px;

    }
    .a-img:focus img {
        filter: grayscale(1);
    }

    .photoview {
        max-height: calc(100% - 150px);
        margin: 0px;
        overflow: hidden;
        /*        max-height: calc(100% - 350px);*/
        margin-bottom: 50px;

    }
    #photoalbum {
        padding-bottom: 0px;

    }
    #viewphoto {
        background: url(uploads/jpg-2017-12-14-12-01-12-000000-7101.jpg);
        background-repeat:no-repeat;
        background-position: center;
        border: 2px solid #857991;
        padding: 1px;
        border-bottom: 0px;
        background-color: #685e79;
        background-size: cover;
        height: calc(100% - 250px);
        transition: .5s;

    }
</style>


<!-- Vormgeving -->
<section id="photoalbum">
    <h2 class="section-heading text-uppercase text-center">Fotoalbum</h2>
    <hr class="my-4">
    <div class="gallery" align="center">



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
                                $preview = '<img name="preview" src="' . $imgSrc . '" alt=""  />';
                                $h2 = '<h2 id="text">' . $description . '</h2>';
                            }
                            echo '<li><a class="a-img" id="imga' . $i . '" href="#viewphoto"><img id="img' . $i . '" style="left: 0px;" onclick="viewslide(img' . $i . '.src, img' . $i . '.alt, '.$i.')" name="img' . $i . '"  src="' . $imgSrc . '" alt="' . $description . '" /></a></li>';
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
            <div class="col-1 padding0">
                <div id="back" onclick="slide(-1)" class="control"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>
            </div>
            <div class="col-10 "><div class="preview" ><div id="viewphoto" onclick="view(this)" title="Klik om te vergroten/verkleinen"></div><?= $h2 ?></div></div>
            <div class="col-1 padding0">
                <div id="next" onclick="slide(1)" class="control"><i class="fa fa-chevron-right" aria-hidden="true"></i></div>
            </div>
        </div>




    </div>
</section> 


<script>
    var move = 0;
    function slide(direction) {
        var width = $(window).width();
        if ((move < <?= $i - 1 ?> || direction == -1 ) && (move > 0 || direction == 1)) {        
            var imgidold = "#img" + move;
            move += direction;
            var imgid = "#img" + move;
            var imgaid = "#imga" + move;

            //alert(move);
            $(imgid).click();
            $(imgaid).click();

            var left = $(imgid).offset().left - $(imgidold).offset().left;
            left = "+=" + left;
            $("#slideshow").animate( { scrollLeft: left }, 200);
            //$("#slideshow").animate( { scrollLeft: scroll }, 200);
            //$("#slideshow").scrollLeft(scroll);
        }
    }
    var viewactive = false;

    function view (element) {
        if (!viewactive) {
            element.style.position = "fixed";
            element.style.width = "100%";
            element.style.height = "100%";
            element.style.top = "0px";
            element.style.left = "0px";
            element.style.zIndex = "1000000000";
            element.style.backgroundSize = "contain";
            element.style.border = "0px";
            viewactive = true;
        }
        else {
            var img = document.getElementById('viewphoto'),
                style = img.currentStyle || window.getComputedStyle(img, false),
                source = style.backgroundImage;

            element.removeAttribute("style");
            viewactive = false;

            document.getElementById('viewphoto').style.backgroundImage = source;
        }
    }

    function viewslide(source, text, id) {       
        document.getElementById('viewphoto').style.backgroundImage = "url(" + source + ")";
        document.getElementById('text').innerHTML = text;
        move = id;
    }

</script>
<?php
    require 'footer.php';
?>