<?php
$currentPage = "acp_applications.php";
include("global.php");
require_once("config.php");
session_start();
error_reporting(0);

if (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    $user = $db->getFirst("SELECT !adminrights as admin FROM !accounts WHERE !username = ?", $username);
    if (!$user["admin"])
    {
        redirect("error.php?errorid=2.php");
    }
}
else redirect("index.php");

$title = "Bewerbungen";
include_once("templates/header_acp.php");
?>
    <style>
        h6 b {
            padding-left: 30px;
        }

        .btn {
            margin-right: 10px;
        }
    </style>
<?php
if (isset($_GET["show_application"]) && isset($_SESSION["object_id"]))
{
    $selected_object = $_SESSION["object_id"];
    $application = $db->getFirst("SELECT * FROM supporter_applications WHERE id = ?", $selected_object);
    $id = $application['id'];
    $date_of_creation = $application['date_of_creation'];
    $creator = $application['creator'];
    $status = $application['status'];
    $current_status = "?";
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
    echo "<table>";
    echo "<tr>";
    echo "<td><a href='acp_applications.php'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck</button></a>";
    echo "</tr>";
    echo "</table> <br /><br />";
    echo "<div class='well' style='height: auto; width: auto;'>";
    echo "<h6 id='size'><b>Bewerbungs-ID:</b> $id<b>Erstelldatum:</b> $date_of_creation<b>Bewerber:</b> $creator<b>Status:</b> $current_status </h6><hr />";
    show_supporter_application($selected_object);
    echo "</div>";
    if ($status = 1)
    {
        echo "<a href='acp_applications.php'><button type='button' class='btn btn-success'>beibehalten</button></a>";
    }
    if ($status != 2)
    {
        echo "<a href='action_admin_reject_supporter_appliaction.php?action=rejectApplication&Id=$selected_object'><button type='button' class='btn btn-danger'>Ablehnen</button></a>";
    }
}
include_once("templates/footer_acp.php");