<?php

$currentPage = "acp_settings.php";
include("global.php");

require_admin();
$title = "Einstellungen";
include_once("templates/header_acp.php");
?>

<?php
if (isset($_GET["status"]) && $_GET["status"] == "success") //success for editing the settings
{
    showMessage('Die Einstellungen wurden erfolgreich aktualisiert.', 'success'); 
}
?>
    <p>Passe dein UCP an wie es dir gef&auml;llt und individualisiere das Nutzererlebnis.</p> <br/>
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#general" data-toggle="tab"><span class="glyphicon glyphicon-asterisk"></span>
                Allgemein</a></li>
        <li><a href="#colors" data-toggle="tab"><span class="glyphicon glyphicon-tint"></span>Farbschema</a></li>
        <li><a href="acp_dbconfig.php"><span class="glyphicon glyphicon-cloud-upload"></span> Datenbankkonfiguration</a></li>
    </ul>
    <style type="text/css"> #size_2 {
            width: 800px;
        }

        #size_1 {
            width: 150px;
        }</style>
    <form class="form-signin" role="form" action="action_edit_settings.php" method="post">
    <div id="myTabContent" class="tab-content">

    <div class="tab-pane fade in active" id="general"><br/>
    <?php
    $row = getConfig();
    $status_ts_controller = $row['status_ts_controller'];
    $status_supporter_application = $row['status_supporter_application'];
    $status_leader_application = $row['status_leader_application'];
    $status_whosonline_list = $row['status_whosonline_list'];
    $project_name = $row['projectname'];
    $project_description = $row['projectdescription'];
    $login_background = $row['login_background'];
    $login_logo = $row['login_logo'];
    $samp_ip = $row['samp_ipadress'];
    $status_forum = $row['status_forum'];
    $href_forum = $row['href_forum'];
    $status_finances = $row['status_finances'];
    $ts3_ip = $row['ts3_ipadress'];

    $factions = $db->getFirst("SELECT * FROM factions");
    if (!$factions) {
        //Das liegt an deiner "Datenstruktur"...
        $db->add("factions");
    }
    ?>
    Projektname:
    <input type="text" name="projectname" class="form-control" placeholder="Projektname"
           value="<?= htmlspecialchars($project_name) ?>" style="width: 350px;"/><br/>
    IP des SA:MP-Servers:
    <input type="text" name="samp_ipadress" class="form-control" placeholder="SA:MP-IP mit Port"
           value="<?= htmlspecialchars($samp_ip) ?>" style="width: 350px;"/><br/>
    IP des TeamSpeak-Servers:
    <input type="text" name="ts3_ipadress" class="form-control" placeholder="TeamSpeak-IP mit Port"
           value="<?= htmlspecialchars($ts3_ip) ?>" style="width: 350px;"/><br/>
    Slogan, Motto, Kurzbeschreibung:
    <textarea class="form-control" name="projectdescription" rows="2" placeholder="kurz und knapp"
              style="width: 800px;"><?= htmlspecialchars($project_description) ?></textarea>
    <br/>

    <h2 class="sub-header">&Uuml;berblick</h2>
    <br/>
    <table class="table table-hover table-condensed">
        <tr>
            <?php if ($status_ts_controller == 1)
            {
                echo "<td class='danger'>";
            }
            else
            {
                echo "<td class='success'>";
            } ?><b>TeamSpeak-Controller</b></td>
            <td>
                <?php
                if ($status_ts_controller == 1)
                {
                    echo "<select class='form-control' name='status_ts_controller' size='1' id='size_1'>";
                    echo "<option value='0'>aktivieren</option>";
                    echo "<option value='1' selected>deaktivieren</option>";
                    echo "</select>";
                }
                else
                {
                    echo "<select class='form-control' name='status_ts_controller' size='1' id='size_1'>";
                    echo "<option value='0' selected>aktivieren</option>";
                    echo "<option value='1'>deaktivieren</option>";
                    echo "</select>";
                }
                ?>
            </td>
            <td>Aktiviere oder Deaktiviere den <a href="acp_teamspeak.php">TeamSpeak-Controller</a></td>
        </tr>
        <tr>
            <?php if ($status_supporter_application == 1)
            {
                echo "<td class='danger'>";
            }
            else
            {
                echo "<td class='success'>";
            } ?><b>Supporter-Bewerbungen</b></td>
            <td>
                <?php
                if ($status_supporter_application == 1)
                {
                    echo "<select class='form-control' name='status_supporter_application' size='1' id='size_1'>";
                    echo "<option value='0'>aktivieren</option>";
                    echo "<option value='1' selected>deaktivieren</option>";
                    echo "</select>";
                }
                else
                {
                    echo "<select class='form-control' name='status_supporter_application' size='1' id='size_1'>";
                    echo "<option value='0' selected>aktivieren</option>";
                    echo "<option value='1'>deaktivieren</option>";
                    echo "</select>";
                }
                ?>
            </td>
            <td>Aktiviere oder Deaktiviere die <a href="#">Supporter-Bewerbungen</a></td>
        </tr>
        <tr>
            <?php if ($status_leader_application == 1)
            {
                echo "<td class='danger'>";
            }
            else
            {
                echo "<td class='success'>";
            } ?><b>Leader-Bewerbungen</b></td>
            <td>
                <?php
                if ($status_leader_application == 1)
                {
                    echo "<select class='form-control' name='status_leader_application' size='1' id='size_1'>";
                    echo "<option value='0'>aktivieren</option>";
                    echo "<option value='1' selected>deaktivieren</option>";
                    echo "</select>";
                }
                else
                {
                    echo "<select class='form-control' name='status_leader_application' size='1' id='size_1'>";
                    echo "<option value='0' selected>aktivieren</option>";
                    echo "<option value='1'>deaktivieren</option>";
                    echo "</select>";
                }
                ?>
            </td>
            <td>Aktiviere oder Deaktiviere die <a href="#">Leader-Bewerbungen</a></td>
        </tr>
        <tr>
            <?php if ($status_whosonline_list == 1)
            {
                echo "<td class='danger'>";
            }
            else
            {
                echo "<td class='success'>";
            } ?><b>"Wer ist Online?"-Liste</b></td>
            <td>
                <?php
                if ($status_whosonline_list == 1)
                {
                    echo "<select class='form-control' name='status_whosonline_list' size='1' id='size_1'>";
                    echo "<option value='0'>aktivieren</option>";
                    echo "<option value='1' selected>deaktivieren</option>";
                    echo "</select>";
                }
                else
                {
                    echo "<select class='form-control' name='status_whosonline_list' size='1' id='size_1'>";
                    echo "<option value='0' selected>aktivieren</option>";
                    echo "<option value='1'>deaktivieren</option>";
                    echo "</select>";
                }
                ?>
            </td>
            <td>Aktiviere oder Deaktiviere die <a href="#">"Wer ist Online?"-Liste</a> auf der Informationsseite
            </td>
        </tr>
        <tr>
            <?php if ($status_finances == 1)
            {
                echo "<td class='danger'>";
            }
            else
            {
                echo "<td class='success'>";
            } ?><b>Finanzen: Überweisungen etc.</b></td>
            <td>
                <?php
                if ($status_finances == 1)
                {
                    echo "<select class='form-control' name='status_finances' size='1' id='size_1'>";
                    echo "<option value='0'>aktivieren</option>";
                    echo "<option value='1' selected>deaktivieren</option>";
                    echo "</select>";
                }
                else
                {
                    echo "<select class='form-control' name='status_finances' size='1' id='size_1'>";
                    echo "<option value='0' selected>aktivieren</option>";
                    echo "<option value='1'>deaktivieren</option>";
                    echo "</select>";
                }
                ?>
            </td>
            <td>Aktiviere oder Deaktiviere die <a href="finances.php">Finanzen</a>, welche die Möglichkeit
                bieten Überweisungen an Mitspieler zu verschicken
            </td>
        </tr>
        <tr>
            <?php if ($status_forum == 1)
            {
                echo "<td class='danger'>";
            }
            else
            {
                echo "<td class='success'>";
            } ?><b>Menüpunkt "Forum" (Loginmaske)</b></td>
            <td>
                <?php
                if ($status_forum == 1)
                {
                    echo "<select class='form-control' name='status_forum' size='1' id='size_1'>";
                    echo "<option value='0'>aktivieren</option>";
                    echo "<option value='1' selected>deaktivieren</option>";
                    echo "</select>";
                }
                else
                {
                    echo "<select class='form-control' name='status_forum' size='1' id='size_1'>";
                    echo "<option value='0' selected>aktivieren</option>";
                    echo "<option value='1'>deaktivieren</option>";
                    echo "</select>";
                }
                ?>
            </td>
            <td><input type="text" name="href_forum" class="form-control"
                       placeholder="Weiterleitung: Link zum Forum"
                       value="<?= htmlspecialchars($href_forum) ?>" style="width: 350px;" required/>
            </td>
        </tr>
    </table>
    <br/>
    <input type="submit" name="submit" class="btn btn-success" value="speichern"/>
    </div>
    </form>
    <div class="tab-pane fade" id="colors">
        <?php include_once("acp_colors.php")?>
    </div>
    <script>
        $(function () {
            $('#myTab li:eq(0) a').tab('show');
        });
    </script>
<?php include_once("templates/footer_acp.php");