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
                    <a class="nav-link js-scroll-trigger" href="viewGuestbook.php">Gastenboek</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<br>
<br>

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
        <h1 class="guestbook-header">Gastenboek</h1>
                
                <div class="col-lg-8 mx-auto">
                    <p class="guestbook-text">Welkom bij ons gastenboek! Wilt u ook een bericht achterlaten? Klik dan <a class="page-reference" href="addtoGuestbook.php?gb=true">hier!</a></p>
                </div>
        
        <?php
 
        //koppelen aan database
        include("dbconnection.php");
        
        //query om de benodigde data uit de tabel op te halen
        //zodra emailfunctie werkt, query aanpassen: WHERE approved = 1
        $stmt= $db->prepare("SELECT * FROM guestbook ORDER BY guestbookDate DESC");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0){
                while($row =$stmt->fetch()){
                    echo'
<article class="gb-entry">
  <div class="gb-entry-info-box">
    <div class="gb-entry-info-box-row">
    </div>
    <div class="gb-entry-info-box-row">
      <div class="gb-entry-info-box-row-value">
        '.$row["guestbookTitle"].'
      </div>
      <br class="clearfloat">
    </div>
  </div>
  <div class="gb-entry-message-box">
    <div class="gb-entry-message">
      '.$row["guestbookMessage"].'
      
      <br>
      <br>  
        '.$row["guestbookDate"].'
        
    </div>
  </div>
</article>
                    ';
               }
          }
   
    
    
    ?>


    </body>
