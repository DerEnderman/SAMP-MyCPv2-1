<?php
$currentPage = "acp_complaints.php";
include("global.php");

require_admin();
$title = "Beschwerden";
include_once("templates/header_acp.php");


if ($_GET["complaint_status"] == 1) //success for closing a complaint
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlieen</span></button>";
    echo "<strong>Hinweis:</strong> Die Beschwerde wurde erfolgreich als geschlossen markiert. Damit ist der Fall beendet.";
    echo "</div>";
}
else if ($_GET["complaint_status"] == 2) //success for deleting a complaint
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Die Beschwerde wurde erfolgreich gel&ouml;scht.";
    echo "</div>";
}

$active = $db->getAll("SELECT * FROM complaints WHERE status != '2'");
$inactive = $db->getAll("SELECT * FROM complaints WHERE status = '2'");
?>
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#list_tickets" data-toggle="tab"><span
                    class="glyphicon glyphicon-th-list"></span> &Uuml;bersicht <span
                    class="label label-default"><?= sizeof($active) ?></span></a></li>
        <li><a href="#old_ticket" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span> abgeschlossene F&auml;lle
                <span
                    class="label label-default"><?= sizeof($inactive) ?></span></a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="list_tickets"><br/>
            <?php
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Beschwerden-ID</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Erstelldatum</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Opfer</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Beschuldigter</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Vergehen</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Status</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "</tr>";
            echo "</thead>";

            foreach ($active as $row)
            {
                echo "<tr>";
                echo "<td>", $row["id"], "</td>";
                echo "<td>", $row["date_of_creation"], "</td>";
                echo "<td>", $row["creator"], "</td>";
                echo "<td>", $row["perpetrator"], "</td>";
                echo "<td>", $row["case"], "</td>";
                echo "<td>";
                if ($row->status == 0) {
                    echo "<p class='text-danger'>unbearbeitet</p>";
                }
                else if ($row["status"] == 1)
                {
                    echo "<p class='text-success'>bearbeitet</p>";
                }
                else if ($row["status"] == 2)
                {
                    echo "<p class='text-default'>abgeschlossen</p>";
                }
                echo "</td>";
                echo "<td>";
                if ($row["status"] == 0)
                {
                    echo "<a href=\"action_admin_show_complaint.php?action=showComplaint&complaintId=" . $row["id"] . "\"><button type='button' class='btn btn-success btn-xs'>bearbeiten</button></a></td>";
                } else {
                    echo "<a href=\"action_admin_show_complaint.php?action=showComplaint&complaintId=" . $row["id"] . "\"><button type='button' class='btn btn-default btn-xs'>Anzeigen</button></a></td>";
                }
                echo "</td>";
                echo "<td>";
                if ($row["status"] != 2)
                {
                    echo "<a href=\"action_admin_close_complaint.php?action=closeComplaint&complaintId=" . $row["id"] . "\"><button type='button' class='btn btn-danger btn-xs'>Schlie&szlig;en</button></a></td>";
                }
                echo "</td>";
                echo "<td><a href=\"action_admin_delete_complaint.php?action=deleteComplaint&complaintId=" . $row["id"] . "\"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span> L&ouml;schen</button></a></td>";
                echo "</tr>";
            }
            echo "</table>";
            ?>
        </div>
        <div class="tab-pane fade" id="old_ticket"><br/>
            <?php

            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Beschwerden-ID</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Erstelldatum</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Opfer</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Beschuldigter</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Vergehen</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "<th>&nbsp;&nbsp;&nbsp;<b>Status</b>&nbsp;&nbsp;&nbsp;</th>";
            echo "</tr>";
            echo "</thead>";
            foreach ($inactive as $row)
            {
                $row = (object)$row;
                echo "<tr>";
                echo "<td>", $row->id, "</td>";
                echo "<td>", $row->date_of_creation, "</td>";
                echo "<td>", $row->creator, "</td>";
                echo "<td>", $row->perpetrator, "</td>";
                echo "<td>", $row->case, "</td>";
                echo "<td>";
                if ($row->status == 0) {
                    echo "<p class='text-danger'>unbearbeitet</p>";
                } else if ($row->status == 1) {
                    echo "<p class='text-success'>bearbeitet</p>";
                } else if ($row->status == 2) {
                    echo "<p class='text-default'>abgeschlossen</p>";
                }
                echo "</td>";
                echo "<td>";
                if ($row->status == 0) {
                    echo "<a href=\"action_admin_show_complaint.php?action=showComplaint&complaintId=" . $row->id . "\"><button type='button' class='btn btn-success btn-xs'>bearbeiten</button></a></td>";
                } else {
                    echo "<a href=\"action_admin_show_complaint.php?action=showComplaint&complaintId=" . $row->id . "\"><button type='button' class='btn btn-default btn-xs'>Anzeigen</button></a></td>";
                }
                echo "</td>";
                echo "<td><a href=\"action_admin_delete_complaint.php?action=deleteComplaint&complaintId=" . $row->id . "\"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span> L&ouml;schen</button></a></td>";
                echo "</tr>";
            }
            echo "</table>";

            ?>
        </div>
    </div>
    <script>
        $(function () {
            $('#myTab li:eq(0) a').tab('show');
        });
    </script>
<?php include_once("templates/footer_acp.php");