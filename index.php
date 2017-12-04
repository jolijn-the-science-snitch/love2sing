<?php
    require 'header.php';
?>

    <!-- Navigation -->
<<<<<<< HEAD
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
=======
    
>>>>>>> jolijn
    <header class="masthead text-center text-white d-flex">
        <div class="container my-auto">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h1 class="text-uppercase">
                        <strong>Love2Sing</strong>
                    </h1>
                    <hr>
                </div>
                <div class="col-lg-8 mx-auto">
                    <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Ga verder</a>
                </div>
            </div>
        </div>
    </header>

    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-heading text-white  text-center">Over Love2Sing</h2>
                    <hr class="light my-4">
                    <p class="text-faded mb-4">Gemengd koor Love2sing uit Harderwijk is opgericht in 2016 en telt momenteel 17 enthousiaste zangers en zangeressen (SATB) die veel van zingen houden.<br> Op het repertoire staan mooie arrangementen, van de Britse pianist, arrangeur, componist en producer Tom Parker.<br> Bekende projecten van Tom Parker zijn: The Young Messiah, The Young Verdi, The Young Beethoven, The Young Mozart, The Young Schubert enz. deze muziek wordt uitgevoerd door The New London Chorale.<br> De laatste jaren is The New London Chorale een vast onderdeel bij The Max of the Proms, maar sinds een paar jaar treed The New London Chorale ook weer op in Nederland, niet meer met Tom Parker, want hij is helaas overleden op 18 april 2013.<br> De muziek van Tom Parker is een mooie balans tussen de traditionele klassieke en de populaire muziek.<br> In de toekomst gaan wij kijken of wij nog andere mooie muziek kunnen vinden in deze genre, maar Tom Parker en zijn muziek zal altijd een onderdeel blijven bij Love2sing.
                    </p>

                    <h2 class="section-heading text-white  text-center">Dirigente &#038; pianist</h2>
                    <hr class="light my-4">
                    <p class="text-faded mb-4">Love2sing staat onder leiding van dirigente Manon Arnold en pianist Sander Worrell. Ze hebben samen veel ervaring op muziekgebied.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Bezoek onze concerten!</h2>
                    <hr class="my-4">
                </div>
            </div>
        </div>

        <div class="container" style="text-align:center;">
            <iframe src="https://calendar.google.com/calendar/embed?showTitle=0&amp;showPrint=0&amp;showTabs=0&amp;showCalendars=0&amp;showTz=0&amp;height=450&amp;wkst=1&amp;hl=nl&amp;bgcolor=%23ffffff&amp;src=kmhu140epkhr7rq6fb2i5t837c%40group.calendar.google.com&amp;color=%23691426&amp;ctz=Europe%2FAmsterdam" style="border-width:0" width="450" height="450" frameborder="0" scrolling="no"></iframe>
        </div>
    </section>

    <section class="bg-dark text-white">
        <div class="container text-center">
            <h2 class="mb-4">Bekijk nog meer foto's van ons koor!</h2>
            <a class="btn btn-light btn-xl sr-button" href="photoalbum.php">Ga naar foto album</a>
        </div>
    </section>

    <!-- scripts voor contactformulier -->

    <script src="js/functions.js"></script>

    <script>
        function contactForm(buttonText, pointerStyle,loading,buttonid) {
            sendButton(buttonText, loading, buttonid);
            document.getElementById('name').style.pointerEvents = pointerStyle;
            document.getElementById('email').style.pointerEvents = pointerStyle;
            document.getElementById('contactMessage').style.pointerEvents = pointerStyle;
        }

        var firstTime = true;

        function mail() {
            if (!firstTime) {
                var iframeContent = document.getElementById('contactIframe').contentWindow.document.body.innerHTML;
                if (iframeContent == "1") { // 1: mail met contactgegevens is verzonden
                    document.getElementById("contactForm").style.display = "none"; // contact formulier onzichtbaar maken
                    message("success", "Bericht verzonden", "Uw bericht is succesvol verzonden, wij reageren z.s.m.");
                } else if (iframeContent == "0") { // 0: mail met contactgegevens is niet verzonden
                    sendButton('Verstuur bericht opnieuw', 'auto',false);
                    message("warning", "Bericht verzenden mislukt", "Probeer het opnieuw");
                } else {
                    sendButton('Verstuur bericht opnieuw', 'auto', false);
                    message("danger", "Bericht verzenden mislukt", "Er is een technishe fout opgetreden");
                }
            } else {
                firstTime = false;
            }
        }    
    </script>

    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading text-uppercase">Contact</h2>
                    <h3 class="section-subheading text-muted">Wij nemen zo snel mogelijke conact met u op.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="contactForm" name="sentMessage" method="post" action="mail.php" target="contact" onsubmit="contactForm('Bericht versturen...','none',true,'sendMessageButton')">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input class="form-control" id="name" name="contactName" type="text" placeholder="Uw naam" required data-validation-required-message="Vul a.u.b een naam in">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="email" name="contactEmail" type="email" placeholder="E-mailadres" required data-validation-required-message="Vul a.u.b een e-mailadres in">

                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="contactMessage" id="contactMessage" placeholder="Uw bericht" required data-validation-required-message="Vul a.u.b een bericht in"></textarea>

                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Verstuur bericht</button>
                            </div>
                        </div>
                    </form>

                    <div id="message"></div>

                    <iframe name="contact" src="mail.php" id="contactIframe" onload="mail();"></iframe>
                    <hr class="my-4">
                    <div class="col-lg-12 text-center">
                        <h3 class="section-subheading text-muted">Of kom een keertje langs!<br><br></h3>
                    </div>
                    <div class="section-heading text-center" style="margin:auto; position:absolute;">
                        <p><strong>De Roef</strong><br>Zuiderzeepad 1<br>3844 JV Harderwijk</p>
                    </div>
                    <div class="section-heading text-center" style="margin:auto; position:absolute;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2437.8307614435207!2d5.60690031531079!3d52.33721625751214!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c6316035c49a25%3A0x253fdf15a0417bbd!2sMultifunctioneel+zalen-+en+vergadercentrum+&#39;de+Roef&#39;!5e0!3m2!1sen!2snl!4v1511981850025" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <?php
    require 'footer.php';
?>
