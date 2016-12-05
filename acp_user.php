<?php
$currentPage = "acp_user.php";
include("global.php");
$config = getConfig();
require_admin();
$title = "Benutzer";
$factions = $db->getFirst("SELECT * FROM factions");
include_once("templates/header_acp.php");
if (isset($_GET["user"]))
    $users = $db->getAll("SELECT * FROM !accounts WHERE !username LIKE ?", $_GET["user"]."%");
else
    $users = $db->getAll("SELECT * FROM !accounts");

if (sizeof($users) == 1 && isset($_GET["user"])) {
    //Es wurde ein User angegeben und der Name ist eindeutig.
    $_SESSION["userId"] = $users[0][$config["data_id"]];
    redirect("useraccount.php?show_profile=true");
}
//Ansonsten sind mehrere User in der Liste
$banned = $db->getAll("SELECT * FROM !accounts WHERE !banned = 1");
$leader = $db->getAll("SELECT * FROM !accounts WHERE !leader != 0");
$config = getConfig();
if (isset($_GET["status"])) {
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>";
    if ($_GET["status"] == 1)
        echo "<strong>Hinweis:</strong> Dem Leader wurden erfolgreich die Rechte entzogen.";
    if ($_GET["status"] == 2)
        echo "<strong>Hinweis:</strong> Dem Benutzer wurden erfolgreich die TeamSpeak-Rechte entzogen.";
    if ($_GET["status"] == 3)
        echo "<strong>Hinweis:</strong> Du hast den Benutzer erfolgreich entbannt.";
    if ($_GET["status"] == 4)
        echo "<strong>Hinweis:</strong> Du hast den Benutzer erfolgreich gebannt, falls er TeamSpeak-Rechte hatte wurden diese nun entzogen.";
    if ($_GET["status"] == 5)
        echo "<strong>Hinweis:</strong> Du hast den Benutzeraccount erfolgreich gel&ouml;scht, falls er TeamSpeak-Rechte hatte wurden diese nun entzogen.";
    echo "</div>";
}
?>
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#all_users" data-toggle="tab"><span class="glyphicon glyphicon-user"></span>
                <?php if (!isset($_GET["user"]))
                    echo "Alle Benutzer";
                else
                    echo "Suchergebnisse: Name = ".$_GET["user"]."...";
                ?>
                <span
                    class="label label-default"><?= sizeof($users) ?></span></a></li>
        <li><a href="#banned_users" data-toggle="tab"><span class="glyphicon glyphicon-lock"></span> gebannte Benutzer
                <span
                    class="label label-default"><?= sizeof($banned) ?></span></a></li>
        <li><a href="#leader_users" data-toggle="tab"><span class="glyphicon glyphicon-briefcase"></span> Leader <span
                    class="label label-default"><?= sizeof($leader) ?></span></a></li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="all_users"><br/>
            <?php if (!sizeof($users)) {?>
                <div class='alert alert-danger' role='alert'>
                <strong>Hinweis:</strong> Keine Benutzer gefunden.
                </div>
            <?php } else {?>
            <table class='table table-bordered table-hover'>
            <thead>
                <tr>
                    <td><b>ID</b></td>
                    <td><b>Benutzername</b></td>
                    <td><b>E-Mail Adresse</b></td>
                    <td><b>Level</b></td>
                    <td><b>Fraktion</b></td>
                    <td><b>Leader</b></td>
                    <td><b>letzter Login</b></td>
                </tr>
            </thead>
                <?php foreach($users as $user) {?>
                    <tr>
                        <td><?= $user[$config["data_id"]] ?></td>
                        <td><?= $user[$config["data_username"]] ?></td>
                        <td><?= $user[$config["data_email"]] ?></td>
                        <td><?= $user[$config["data_level"]] ?></td>
                        <td>
                            <?php if ($user[$config["data_faction"]] == 0) echo ICON_NO;
                            else echo $factions["faction_".$user[$config["data_faction"]]];
                            ?>
                        </td>
                        <td><?php if ($user[$config["data_leader"]] == 0) echo ICON_NO;
                            else echo ICON_OK; ?>
                        </td>
                        <td><?= $user[$config["data_lastlogin"]] ?></td>
                        <td><a href="action_show_user.php?action=showUser&userId=<?= $user[$config["data_id"]] ?>"><button type='button' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> Bearbeiten</button></a></td>
                    </tr>
                <?php } //foreach
                ?>
            </table>
    <?php } //else ?>
        </div>
        <div class="tab-pane fade in" id="banned_users"><br/>
            <?php if (!sizeof($banned)) {?>
                <div class='alert alert-danger' role='alert'>
                    <strong>Hinweis:</strong> Keine Benutzer gefunden.
                </div>
            <?php } else {?>
                <table class='table table-bordered table-hover'>
                    <thead>
                    <tr>
                        <td><b>ID</b></td>
                        <td><b>Benutzername</b></td>
                        <td><b>E-Mail Adresse</b></td>
                        <td><b>Level</b></td>
                        <td><b>Fraktion</b></td>
                        <td><b>Leader</b></td>
                        <td><b>letzter Login</b></td>
                    </tr>
                    </thead>
                    <?php foreach($banned as $user) {?>
                        <tr>
                            <td><?= $user[$config["data_id"]] ?></td>
                            <td><?= $user[$config["data_username"]] ?></td>
                            <td><?= $user[$config["data_email"]] ?></td>
                            <td><?= $user[$config["data_level"]] ?></td>
                            <td>
                                <?php if ($user[$config["data_faction"]] == 0) echo ICON_NO;
                                else echo $factions["faction_".$user[$config["data_faction"]]];
                                ?>
                            </td>
                            <td><?php if ($user[$config["data_leader"]] == 0) echo ICON_NO;
                                else echo ICON_OK; ?>
                            </td>
                            <td><?= $user[$config["data_lastlogin"]] ?></td>
                            <td><a href="action_show_user.php?action=showUser&userId=<?= $user[$config["data_id"]] ?>"><button type='button' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> Bearbeiten</button></a></td>
                            <td><a href="action_edit_user_accstatus.php?action=0&userId=<?= $user[$config["data_id"]] ?>"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-paragraph'></span> Entbannen</button></a></td>
                        </tr>
                    <?php } //foreach
                    ?>
                </table>
            <?php } //else ?>
        </div>
    <div class="tab-pane fade in" id="leader_users"><br/>
        <?php if (!sizeof($leader)) {?>
            <div class='alert alert-danger' role='alert'>
                <strong>Hinweis:</strong> Keine Leader gefunden.
            </div>
        <?php } else {?>
            <table class='table table-bordered table-hover'>
                <thead>
                <tr>
                    <td><b>ID</b></td>
                    <td><b>Benutzername</b></td>
                    <td><b>E-Mail Adresse</b></td>
                    <td><b>Level</b></td>
                    <td><b>Fraktion</b></td>
                    <td><b>letzter Login</b></td>
                </tr>
                </thead>
                <?php foreach($leader as $user) {?>
                    <tr>
                        <td><?= $user[$config["data_id"]] ?></td>
                        <td><?= $user[$config["data_username"]] ?></td>
                        <td><?= $user[$config["data_email"]] ?></td>
                        <td><?= $user[$config["data_level"]] ?></td>
                        <td>
                            <?php if ($user[$config["data_faction"]] == 0) echo ICON_NO;
                            else echo $factions["faction_".$user[$config["data_faction"]]];
                            ?>
                        </td>
                        <td><?= $user[$config["data_lastlogin"]] ?></td>
                        <td><a href="action_show_user.php?action=showUser&userId=<?= $user[$config["data_id"]] ?>"><button type='button' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> Bearbeiten</button></a></td>
                        <td><a href="action_uninvite_leader.php?action=uninviteLeader&userId=<?= $user[$config["data_id"]] ?>"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-hazard'></span> Entlassen</button></a></td>
                    </tr>
                <?php } //foreach
                ?>
            </table>
        <?php } //else ?>
    </div>
<?php include_once("templates/footer_acp.php");