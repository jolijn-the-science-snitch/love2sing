<?php
require '../includes/functions.php';
// controleer of gebruiker admin rechten heeft
if (!adminpage()) {
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Beheer</title>
        <!-- Bootstrap core CSS-->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin.css" rel="stylesheet">
        <link href="../css/editPassword.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <script src="../js/functions.js"></script>

    </head>

    <body class="fixed-nav sticky-footer bg-dark" id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <a class="navbar-brand" href="#">Love2Sing</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                        <a class="nav-link" href="home.php" target="iframe" onClick="viewName(this);">
                            <i class="fa fa-fw fa-home"></i>
                            <span class="nav-link-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                        <a class="nav-link" href="calendar.php" target="iframe" onClick="viewName(this);">
                            <i class="fa fa-fw fa fa-calendar"></i>
                            <span class="nav-link-text">Kalender</span>
                        </a>
                    </li>
                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseComponents" data-parent="#exampleAccordion" id="componentsParent">
                            <i class="fa fa-fw fa-wrench"></i>
                            <span class="nav-link-text">Onderdelen</span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="collapseComponents">
                            <li>
                                <a href="musicupload.php" target="iframe" onClick="viewName(this,'componentsParent');">Uploaden muziek</a>
                            </li>
                            <li>
                                <a href="adduser.php" target="iframe" onClick="viewName(this,'componentsParent');">Persoon toevoegen smoelenboek</a>
                            </li>
                            <li>
                                <a href="addphoto.php" target="iframe" onClick="viewName(this,'componentsParent');">Foto's toevoegen fotoalbum</a>
                            </li>
                            <li>
                                <a href="editPassword.php" target="iframe" onClick="viewName(this,'componentsParent');">Wachtwoord wijzigen</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
                        <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseMessages" data-parent="#exampleAccordion" id="messageParent">
                            <i class="fa fa-fw fa-envelope"></i>
                            <span class="nav-link-text">Berichten</span>
                        </a>
                        <ul class="sidenav-second-level collapse" id="collapseMessages">
                            <li>
                                <a href="guestbookposts.php" target="iframe" onClick="viewName(this,'messageParent');">Gastenboek</a>
                            </li>
                            <li>
                                <a href="contactformresults.php" target="iframe" onClick="viewName(this,'messageParent');">Contact formulier</a>
                            </li>
                        </ul>
                    </li>

                </ul>


                <!--
<ul class="navbar-nav sidenav-toggler">
<li class="nav-item">
<a class="nav-link text-center" id="sidenavToggler">
<i class="fa fa-fw fa-angle-left"></i>
</a>
</li>
</ul>
-->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                            <i class="fa fa-fw fa-sign-out"></i>Terug naar website</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb" id="pageName">
                    <li class="breadcrumb-item"><a href="home.php" target="iframe" onClick="viewName();" >Love2Sing</a></li>                    
                    <li class="breadcrumb-item active" ><i class="fa fa-fw fa-home"></i><span class="nav-link-text">Home</span></li>
                </ol>

                <script>
                    function viewName(element = null, parentid = null) {
                        var content = '<li class="breadcrumb-item"><a href="home.php" target="iframe"  onClick="viewName();" >Love2Sing</a></li>';
                        if (parentid != null) {
                            var parent = document.getElementById(parentid);
                            content += "<li class='breadcrumb-item'>" + parent.innerHTML + "</li>";
                        }
                        if (element != null) {
                            content += "<li class='breadcrumb-item'>" + element.innerHTML + "</li>";
                        }
                        else {
                            content += '<li class="breadcrumb-item"><i class="fa fa-fw fa-home"></i><span class="nav-link-text">Home</span></li>';
                        }
                        document.getElementById("pageName").innerHTML = content;
                    }
                </script>

                <iframe src="home.php" id="adminiframe" name="iframe"></iframe>

                <footer class="sticky-footer">
                    <div class="container">
                        <div class="text-center">
                            <small>Copyright © Great Minds&#153; 2017</small>
                        </div>
                    </div>
                </footer>
                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fa fa-angle-up"></i>
                </a>
                <!-- Logout Modal-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Terug naar de home page</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Klik op "keer terug" om weer naar de website te gaan.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuleren</button>
                                <a class="btn btn-primary" href="../">Keer terug</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bootstrap core JavaScript-->
                <script src="../vendor/jquery/jquery.min.js"></script>
                <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- Core plugin JavaScript-->
                <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
                <!-- Page level plugin JavaScript-->
                <script src="../vendor/chart.js/Chart.min.js"></script>
                <script src="../vendor/datatables/jquery.dataTables.js"></script>
                <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
                <!-- Custom scripts for all pages-->
                <script src="../js/sb-admin.min.js"></script>
                <!-- Custom scripts for this page-->
                <script src="../js/sb-admin-datatables.min.js"></script>
                <script src="../js/sb-admin-charts.min.js"></script>
            </div>
        </div>
    </body>

</html>
