<?php
$currentPage = "acp_applications.php";
include("global.php");
require_admin();
$title = "Bewerbungen";
include_once("templates/header_acp.php");
?>
    <!-- navigation -->
<?php include("navigation/nav_1.php"); ?>

<?php
if ($_GET["show_application"] == true)
{
    $selected_object = $_SESSION["object_id"];

    $query2 = $db->getFirst("SELECT * FROM leader_applications WHERE id = '$selected_object'") or die(mysql_error());
    $id = $query2['id'];
    $date_of_creation = $query2['date_of_creation'];
    $creator = $query2['creator'];
    $faction = $query2['faction'];
    $status = $query2['status'];


    if ($status == 0)
    {
        $current_status = "fehlerhaft";
    }
    else
    {
        if ($status == 1)
        {
            $current_status = "neu eingegangen";
        }
    }

    $factions = $db->getFirst("SELECT * FROM factions");
    $selected_faction = $factions["faction_".$faction];
    echo "<table>";
    echo "<tr>";
    echo "<td><a href='acp_applications.php'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck</button></a>&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "</tr>";
    echo "</table> <br /><br />";
    echo "<div class='well' style='height: auto; width: auto;'>";
    echo "<h6 id='size'><b>Bewerbungs-ID:</b> $id &nbsp;&nbsp;&nbsp;&nbsp; <b>Erstelldatum:</b> $date_of_creation &nbsp;&nbsp;&nbsp;&nbsp; <b>Bewerber:</b> $creator &nbsp;&nbsp;&nbsp;&nbsp; <b>Fraktion:</b> $selected_faction &nbsp;&nbsp;&nbsp;&nbsp; <b>Status:</b> $current_status </h6><hr />";
    show_leader_application($selected_object);
    echo "</div>";
    if ($status = 1)
    {
        echo "<a href='action_admin_accept_leader_application.php?action=acceptApplication&Id=$selected_object'><button type='button' class='btn btn-success'>Annehmen</button></a>";
    }
    if ($status != 2)
    {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='action_admin_reject_leader_appliaction.php?action=rejectApplication&Id=$selected_object'><button type='button' class='btn btn-danger'>Ablehnen</button></a>";
    }
}
?>
<?php include_once("templates/footer_acp.php");