<?php
include("adminpageheader.php"); 

if (isset($_POST["action"]) && isset($_POST["id"])) {
    $status = filter_input(INPUT_POST, "action");
    $id = filter_input(INPUT_POST, "id");
    if ($status == 2) {
        $stmt = $db->prepare("DELETE FROM contact WHERE contactid = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            message("success","Er is een contact bericht verwijderd","Succesvol verwijderd");
            header('Location: contactformposts.php');
        }
        else {
            message("danger","Verwijderen mislukt","Er is een technische fout opgetreden");
        }
    }
    else {
        $stmt = $db->prepare("UPDATE contact SET contactRead = :status WHERE contactid = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            message("success","De status van dit bericht is succesvol bijgewerkt","");
        }
        else {
            message("danger","Updaten mislukt","Er is een technische fout opgetreden");
        }
    }
}


$tablestyle = "";
$viewmail = "";
$table = "";
$mail = "";
$postedid = null;

if (isset($_GET["id"])) {
    $id = filter_input(INPUT_GET, "id");
    $tablestyle = "style = 'display: none'";
    $viewmail = "style = 'display: block'";

    $stmt = $db->prepare("SELECT * FROM contact WHERE contactid = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    while ($row = $stmt->fetch()) {
        $mail .= '<div class="mailback"><a href="contactformposts.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Terug</a></div><br>'; 
        $mail .= '<h1>Van '.$row["name"].'</h1>';
        $mail .= ' <p>';
        $mail .= '<b>Antwoord naar: </b>'.$row["email"].'';
        $mail .= '<br>';
        $mail .= '<b>Ontvangen op: </b>'.$row["date"].'';
        $mail .= '</p>';
        $mail .= '<h2>Bericht:</h2>';
        $mail .= '<p>';
        $mail .= $row["message"];
        $mail .= '</p><br><br><br>';
        $mail .= '<div class="footermail">';
        $mail .= '<form method="post"><input type="hidden" name="id" value="'.$row["contactid"].'">';
        $mail .= '<a href="mailto:'.$row["email"].'?Subject=Love2sing%20contactformulier" target="_top" class="btn btn-info">Reageer</a> ';
        $mail .= '<button type="submit" name="action" value="2" class="btn btn-danger">Verwijderen</button>';
        $mail .= "</form></div>";
    }

    $stmt = $db->prepare("UPDATE contact SET contactRead = 1 WHERE contactid = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
else {
    $stmt = $db->prepare("SELECT * FROM contact ORDER BY date DESC");
    $stmt->execute();
    $table = "";
    while ($row = $stmt->fetch()) {
        if ($row["contactid"] == $postedid && $row["contactRead"] == 0) {
            $table .= '<tr style="font-weight: 800;" onclick="window.location.href = \'contactformposts.php?id='.$row["contactid"].'\'; ">';
        }
        elseif ($row["contactRead"] == 0) {
            $table .= '<tr style="font-weight: bold;" onclick="window.location.href = \'contactformposts.php?id='.$row["contactid"].'\';">';
        }
        else {
            $table .= '<tr onclick="window.location.href = \'contactformposts.php?id='.$row["contactid"].'\';">';
        }

        $messagetext = $row["message"];
        if (strlen($row["message"]) > 250) {
            $messagetext = substr($row["message"], 0, 250). "... <span class='small text-info'>klik voor volledig bericht</span>";
        }
        $table .= '<td>'.$row["name"].'</td>';
        $table .= '<td class="messagetext">'.$messagetext.'</td>';
        $table .= '<td class="date">'.date_format(date_create($row["date"]), "d-m-Y H:i:s").'</td>';   
        $table .= '<td class="email">'.$row["email"].'</td>';

        if ($row["contactRead"] == 0) {
            $table .= '<td class="actioncontact">';
            $table .= '<form method="post"><input type="hidden" name="id" value="'.$row["contactid"].'">';
            $table .= '<a href="mailto:'.$row["email"].'?Subject=Love2sing%20contactformulier" target="_top" class="btn btn-info">Reageer</a> ';
            $table .= '<button type="submit" name="action" value="1" class="btn btn-success">Gelezen</button> ';
            $table .= '<button type="submit" name="action" value="2" class="btn btn-danger">Verwijderen</button>';
            $table .= '</form>';
            $table .= '</td>';
        }
        else {
            $table .= '<td class="actioncontact">';
            $table .= '<form method="post"><input type="hidden" name="id" value="'.$row["contactid"].'">';
            $table .= '<a href="mailto:'.$row["email"].'?Subject=Love2sing%20contactformulier" target="_top" class="btn btn-info">Reageer</a> ';
            $table .= '<button type="submit" name="action" value="0" class="btn btn-warning">Ongelezen</button> ';
            $table .= '<button type="submit" name="action" value="2" class="btn btn-danger">Verwijderen</button>';
            $table .= '</form>';
            $table .= '</td>';
        }
        $table .= '</tr>';
    }
}
?>
<style>
    .btn {
        margin-bottom: 5px;
    }
    tr {
        cursor: pointer;
        transition: .2s all;
    }
    tr:hover {
        background: #f4f5f5;
    }
</style>
<h2 <?= $tablestyle ?> >Contact formulier</h2>
<div id="message"></div>
<div class="table-responsive" id="contactTable" <?= $tablestyle ?> >
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th class="from">Van</th>
                <th class="messagetext">Bericht</th>
                <th class="date">Datum</th>
                <th class="email">E-mailadres</th>
                <th class="actioncontact">Actie</th>
            </tr>
        </thead>

        <tbody>

            <?= $table ?>

        </tbody>
    </table>
</div>
<div class="container" id="viewmail" <?= $viewmail ?> >
    <?= $mail ?>
</div>

<?= $message ?>

<?php
    include("adminpagefooter.php");
?>