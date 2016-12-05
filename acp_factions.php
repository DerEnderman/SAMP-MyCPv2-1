<?php
$currentPage = "acp_factions.php";
include("global.php");

require_admin();
$title = "Fraktionen & Leader";
include_once("templates/header_acp.php");

$row = getConfig();
$factions = $db->getFirst("SELECT * FROM factions");
if (!$factions) {
    //Das liegt an deiner "Datenstruktur"...
    $db->add("factions");
}
if (isset($_GET["status"]) && $_GET["status"] == "success") //success for editing the settings
{
    showMessage('Die Einstellungen wurden erfolgreich aktualisiert.', 'success');
}
?>
    <form class="form-signin" role="form" action="action_edit_factions.php" method="post">
        <div class="alert alert-info" role="alert">
            <strong>Hinweis:</strong> Es k&ouml;nnen bis zu 20 Fraktionen angegeben werden. Nutze einfach den
            entsprechenden Slot. <br/>
            Soll beispielsweise die Fraktion LSPD die Fraktions-ID 1 erhalten so lege den Fraktionsnamen auch auf
            Slot 1.
        </div>
        <table class="table-hover">
            <?php
            for ($i = 1; $i <= 20; $i++)
            {
                $image = $db->getFirst("SELECT image FROM faction_informations WHERE faction_id = ?", $i);
                if (!$image)
                    $db->add("faction_informations", array("faction_id" => $i, "image" => " "));
                ?>
                <tr>
                <td><kbd>Slot: <?= $i ?></kbd>&nbsp;<b>Fraktionsname:</b>&nbsp;&nbsp;</td>
                <td><input type="text" name="faction_<?= $i ?>" class="form-control"
                           placeholder="Name der Fraktion - Slot <?= $i ?>"
                           value="<?= htmlspecialchars($factions["faction_" . $i]) ?>"
                           style="width: 350px;" title="Slot <?= $i ?>"/></td>
                <td><b>Logo:</b>&nbsp;&nbsp;</td>
                <td><input type="text" name="faction_logo[<?= $i ?>]" class="form-control"
                           placeholder="Logo der Fraktion - Slot <?= $i ?>"
                           value="<?= $image["image"] ?>"
                           style="width: 350px;" title="Slot <?= $i ?>"/></td>
                </tr><?php } ?>
        </table>
        <br/>
        <input type="submit" name="submit" class="btn btn-success" value="speichern"/>
    </form>
    <br/> <br/>

    <h2 class="sub-header">Leader-&Uuml;bersicht</h2>
<?php

$row = getConfig();
$data_leader = $row['data_leader'];
$data_faction = $row["data_faction"];
$data_lastlogin = $row['data_lastlogin'];


$queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE !leader != 0");
$count = $queryHandle["count"];
if ($count == 0)
{
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<strong>Hinweis:</strong> Derzeit gibt es keine Leader.";
    echo "</div>";
}
else
{
    $result = $db->getAll("SELECT !username, !faction, !lastlogin, !id FROM !accounts WHERE !leader != 0");
    echo "<table class='table table-bordered table-hover'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>&nbsp;&nbsp;&nbsp;<b>Benutzername</b>&nbsp;&nbsp;&nbsp;</td>";
    echo "<td>&nbsp;&nbsp;&nbsp;<b>Leader der Fraktion</b>&nbsp;&nbsp;&nbsp;</td>";
    echo "<td>&nbsp;&nbsp;&nbsp;<b>letztes Login</b>&nbsp;&nbsp;&nbsp;</td>";
    echo "</tr>";
    echo "</thead>";
    foreach ($result as $row)
    {
        echo "</tbody>";
        echo "<tr>";
        echo "<td>", $row["!username"], "</td>";
        echo "<td>";
        echo isset($factions["!faction_" . $row["!faction"]]);
        echo "</td>";
        echo "<td>", $row["!lastlogin"], "</td>";
        echo "<td><a href=\"action_uninvite_leader.php?action=uninviteLeader&userId=" . $row["id"] . "\"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-ban-circle'></span> Leader entlassen</button></a></td>";
        echo "</tr>";
        echo "</tbody>";
    }
    echo "</table>";
}
?>
<?php include_once("templates/footer_acp.php");
