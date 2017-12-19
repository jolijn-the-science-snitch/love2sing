<?php
    require 'header.php';
?>

<head>
    <link rel="stylesheet" type="text/css" href="guestbook.css">
    <link rel="stylesheet" type="text/css" href="css/creative.min.css">
</head>
    
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
                    <p class="guestbook-text">Welkom bij ons gastenboek! Wilt u ook een bericht achterlaten? Klik dan <a class="page-reference" href="addtoGuestbook.php?gb=true"><b>hier!</b></a></p>
                </div>
        
        <?php
<<<<<<< HEAD
  
=======
     
>>>>>>> origin/wim
        //d.m.v. prepare, veilige query om de benodigde data uit de tabel op te halen
        $stmt= $db->prepare("SELECT * FROM guestbook WHERE guestbookApproved = 1 ORDER BY guestbookDate DESC");
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
    <?php
    require 'footer.php';
?>