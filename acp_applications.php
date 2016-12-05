<?php
$currentPage = "acp_applications.php";
include("global.php");
require_admin();

$factions = $db->getFirst("SELECT * FROM factions");
//Workaround für 5.3:
$supporter_count = $db->getFirst("SELECT COUNT(*) as count FROM supporter_applications WHERE status = 1");
$supporter_count = $supporter_count["count"];
$leader_count = $db->getFirst("SELECT COUNT(*) as count FROM leader_applications WHERE status = 1");
$leader_count = $leader_count["count"];

$leader_applications = $db->getAll("SELECT * FROM leader_applications WHERE status = 1");
$supporter_applications = $db->getAll("SELECT * FROM supporter_applications WHERE status = 1");
$title = "Bewerbungen";
include_once("templates/header_acp.php");

if (isset($_GET["status"])) {
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>";
    if ($_GET["status"] == 1) //success for reject an leader application
        echo "<strong>Hinweis:</strong> Die Leader-Bewerbung wurde erfolgreich abgelehnt.";
    if ($_GET["status"] == 2) //success for accept an leader application
         echo "<strong>Hinweis:</strong> Die Leader-Bewerbung wurde erfolgreich angenommen, der Benutzer hat seine Leaderrechte erhalten.";
    if ($_GET["status"] == 3) //success for reject a supporter application
         echo "<strong>Hinweis:</strong> Die Supporter-Bewerbung wurde erfolgreich abgelehnt.";
    echo "</div>";
}
?>
    <ul id="myTab" class="nav nav-tabs" tole="tablist">
        <li class="active"><a href="#leader_applications" data-toggle="tab"><span
                    class="glyphicon glyphicon-briefcase"></span> Leader-Bewerbungen <span
                    class="label label-default"><?= $leader_count?></span></a></li>
        <li><a href="#supporter_applications" data-toggle="tab"><span class="glyphicon glyphicon-flag"></span>
                Supporter-Bewerbungen <span
                    class="label label-default"><?= $supporter_count ?></span></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="leader_applications">
            <table class='table'>
            <thead>
            <tr>
                <th><b>Bewerbungs-ID</b></th>
                <th><b>Erstelldatum</b></th>
                <th><b>Bewerber</b></th>
                <th><b>Fraktion</b></th>
                <th><b>Status</b></th>
            </tr>
            </thead><?php
                foreach ($leader_applications as $application) {?>
                    <tr>
                        <td><?= $application["id"]?></td>
                        <td><?= $application["date_of_creation"]?></td>
                        <td><?= $application["creator"]?></td>
                        <td><?= isset($factions["faction_".$application["faction"]])?$factions["faction_".$application["faction"]]:"keine Fraktion" ?></td>
                        <td><?php if ($application["status"] == 1):?><a href="action_admin_show_leader_application.php?action=showApplication&Id=<?= $application["id"]?>"><button type='button' class='btn btn-default btn-xs'>Anzeigen</button></a><?php endif;?></td>
                        <td><?php if ($application["status"] == 1):?><a href="action_admin_accept_leader_application.php?action=acceptApplication&Id=<?= $application["id"]?>"><button type='button' class='btn btn-default btn-xs'>Annehmen</button></a><?php endif;?></td>
                        <td><?php if ($application["status"] != 2):?><a href="action_admin_reject_leader_appliaction.php?action=rejectApplication&Id=<?= $application["id"]?>"><button type='button' class='btn btn-danger btn-xs'>Ablehnen</button></a><?php endif;?></td>
                    </tr>
                <?php }?>
                </table>
        </div>
        <div role="tabpanel" class="tab-pane fade in" id="supporter_applications">
            <table class='table'>
                <thead>
                <tr>
                    <th><b>Bewerbungs-ID</b></th>
                    <th><b>Erstelldatum</b></th>
                    <th><b>Bewerber</b></th>
                    <th><b>Status</b></th>
                </tr>
                </thead><?php
                foreach ($supporter_applications as $application) {?>
                    <tr>
                        <td><?= $application["id"]?></td>
                        <td><?= $application["date_of_creation"]?></td>
                        <td><?= $application["creator"]?></td>
                        <td><?php if ($application["status"] == 1):?><a href="action_admin_show_supporter_application.php?action=showApplication&Id=<?= $application["id"]?>"><button type='button' class='btn btn-default btn-xs'>Anzeigen</button></a><?php endif;?></td>
                        <td><?php if ($application["status"] != 2):?><a href="action_admin_reject_supporter_appliaction.php?action=rejectApplication&Id=<?= $application["id"]?>"><button type='button' class='btn btn-danger btn-xs'>Ablehnen</button></a><?php endif;?></td>
                    </tr>
                <?php }?>
                </table>
        </div>

    </div>
<?php include_once("templates/footer_acp.php");