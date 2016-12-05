<?php
$currentPage = "acp_teamspeak.php";
include("global.php");

require_admin();
$title = "TeamSpeak";
include_once("templates/header_acp.php");


if ($_GET["status"] == "success") //success for editing ts-controller status (on/off)
{
    showMessage('Die Einstellungen wurden erfolgreich aktualisiert.', 'success'); 
}
?>
    <p>Der TeamSpeak-Controller hilft dir bei der Organisation von Mitgliedern einer bestimmten Servergruppe. Du kannst
        in den Einstellungen festlegen ob sich Benutzer
        über das UCP selbstständig TeamSpeak-Rechte erteilen dürfen. Ebenso hast du auch die Kontrolle ihnen die Rechte
        jederzeit zu entziehen. Weitere Informationen zu dem
        verwendeten Framework findest du auch <a href="https://docs.planetteamspeak.com/ts3/php/framework/index.html"
                                                 target="_blank">hier</a>.</p>
    <p><b>Tipp:</b> Damit eine reibungslose Verbindung zwischen myCP und deinem TeamSpeak-Server stattfinden kann,
        solltest du einen Eintrag in die TeamSpeak-Whitelist
        in Erwägung ziehen. Anderenfalls kann es zu Problemen bei dem vermehrten Zugriff auf den TeamSpeak-Server
        kommen.</p> <br/>
    <style type="text/css"> #size_2 {
            width: 800px;
        }

        #size_1 {
            width: 150px;
        }</style>
    <form role="form" method="post" action="action_edit_ts_controller.php">
        <?php
        $row = getConfig();
        $status_ts_controller = $row['status_ts_controller'];

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
        <br/>
        <input type="submit" name="submit" class="btn btn-success" value="&auml;ndern"/>
    </form>
    <br/><br/>
<?php
$row = getConfig();
$ts_servername = $row['ts_servername'];
$ts_ipadress = $row['ts_ipadress'];
$ts_port = $row['ts_port'];
$ts_query_admin = $row['ts_query_admin'];
$ts_query_password = $row['ts_query_password'];
$ts_query_port = $row['ts_query_port'];
$ts_query_user_nick = $row['ts_query_user_nick'];

$TS_servergroupname = $row['TS_servergroupname'];
$TS_servergroupID = $row['TS_servergroupID'];
$TS_verifydescription = $row['TS_verifydescription'];

?>
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#connection" data-toggle="tab"><span class="glyphicon glyphicon-signal"></span>
                Verbindungsinformationen </a></li>
        <li><a href="#config" data-toggle="tab"><span class="glyphicon glyphicon-cog"></span> Konfiguration </a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="connection"><br/>

            <form class="form-signin" role="form" action="action_edit_TSconnection.php" method="post">
                <table>
                    <tr>
                        <td><b>IP-Adresse &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <td><input name="ts_ipadress" type="tel" class="form-control"
                                   placeholder="nur Zahlen; Eingabe ohne den Port" size="40px"
                                   value='<?= htmlspecialchars($ts_ipadress) ?>'/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Port &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <td><input name="ts_port" type="tel" class="form-control" placeholder="Port der IP-Adresse"
                                   size="40px" value='<?= htmlspecialchars($ts_port) ?>'/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Name des Query-Admins &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <td><input name="ts_query_admin" type="text" class="form-control" placeholder="z.B admin"
                                   size="40px" value='<?= htmlspecialchars($ts_query_admin) ?>'/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Passwort des Query-Admin &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <td><input name="ts_query_password" type="password" class="form-control" size="40px"
                                   value='<?= htmlspecialchars($ts_query_password) ?>'/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Query-Port &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <td><input name="ts_query_port" type="tel" class="form-control" placeholder="meistens 10011"
                                   size="40px" value='<?= htmlspecialchars($ts_query_port) ?>'/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><b>Nickname des Servers &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                        <td><input name="ts_query_user_nick" type="text" class="form-control"
                                   placeholder="z.B TeamSpeak-Controller" size="40px"
                                   value='<?= htmlspecialchars($ts_query_user_nick) ?>'/></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><font color="#808080" size="1pt">*Im besten Fall sollten Nickname des Servers <br/> und der
                                Query-Admin Name identisch sein.</font></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><br/><input type="submit" name="submit" class="btn btn-success" value="speichern"/></td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="tab-pane fade" id="config"><br/>

            <form class="form-signin" role="form" action="action_edit_ts_config.php" method="post">
                <table>
                    <tr>
                        <td></td>
                        <td><input type="text" name="TS_servergroupname" class="form-control"
                                   placeholder="Name der Servergruppe"
                                   value="<?= htmlspecialchars($TS_servergroupname) ?>"/></td>
                        <td></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<kbd>Beschreibung</kbd>
                            Der Name der Servergruppe, z.B "Mitglied", "Member".
                        </td>
                    </tr>
                    <tr>
                        <td><br/><br/></td>
                        <td><br/><br/></td>
                        <td><br/><br/></td>
                        <td><br/><br/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="text" name="TS_servergroupID" class="form-control"
                                   placeholder="ID der Servergruppe"
                                   value="<?= htmlspecialchars($TS_servergroupID) ?>"/></td>
                        <td></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<kbd>Beschreibung</kbd>
                            Du findest die Servergruppen-ID unter "Rechte -> Servergruppen" in der Klammer neben dem
                            Namen.
                        </td>
                    </tr>
                    <tr>
                        <td><br/><br/></td>
                        <td><br/><br/></td>
                        <td><br/><br/></td>
                        <td><br/><br/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="text" name="TS_verifydescription" class="form-control"
                                   placeholder="Verifizierungsmerkmal"
                                   value="<?= htmlspecialchars($TS_verifydescription) ?>"/></td>
                        <td></td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<kbd>Beschreibung</kbd>
                            Das ist der Text der bei der Rechtevergabe in die Beschreibung kommt. Lasse es leer f&uuml;r
                            keinen Text.
                        </td>
                    </tr>
                </table>
                <br/> <br/>
                <input type="submit" name="submit" class="btn btn-success" value="speichern"/>
            </form>
        </div>
    </div>
    <script>
        $(function () {
            $('#myTab li:eq(0) a').tab('show');
        });
    </script>
<?php include_once("templates/footer_acp.php");