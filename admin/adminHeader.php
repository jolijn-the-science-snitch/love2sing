<?php
require '../includes/functions.php';
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
                        <a class="nav-link" href="charts.php" target="iframe" onClick="viewName(this);">
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
                                <a href="cards.php" target="iframe" onClick="viewName(this,'componentsParent');">Persoon toevoegen smoelenboek</a>
                            </li>
                            <li>
                                <a href="cards.php" target="iframe" onClick="viewName(this,'componentsParent');">Foto's toevoegen fotoalbum</a>
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