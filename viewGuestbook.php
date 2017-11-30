<?php
    require 'header.php';
?>

<head>
    <link rel="stylesheet" type="text/css" href="guestbook.css">
    <link rel="stylesheet" type="text/css" href="css/creative.min.css">
</head>
    
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Love2Sing</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#about">Over ons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#services">Fotoalbum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="guestbook.php">Gastenboek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <!--<header class="masthead text-center text-white d-flex">
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="text-uppercase">
                        <strong>Gastenboek</strong>
                    </h1>
                    <hr>
                </div>
                <div class="col-lg-8 mx-auto">
                    <a class="btn btn-primary btn-xl js-scroll-trigger" href="addtoGuestbook.php?gb=true">Schrijf in gastenboek</a>
                </div>
            </div>
        </div>
    </header> !-->

    <body>

        <?php
 
        //koppelen aan database
        include("dbconnection.php");
        
        //query om de benodigde data uit de tabel op te halen
        $stmt= $db->prepare("SELECT * FROM guestbook");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                while($row =$stmt->fetch()){
                    echo"
                    <b>Titel: </b>".$row['guestbookTitle']."<br>
                    <b>Bericht: </b>
                     <p>
                    ".$row['guestbookMessage']."
                    </p>
                    ".$row['guestbookDate']."
                    ";
               }
          }
   
    
    
    ?>


    </body>
