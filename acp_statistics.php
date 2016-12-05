<?php
$currentPage = "acp_statistics.php";
include("global.php");
require_admin();
$title = "Statistiken";
include_once("templates/header_acp.php");
$players = $db->getFirst("SELECT count(*) as count FROM !accounts")["count"];
$banned = $db->getFirst("SELECT count(*) as count FROM !accounts WHERE !banned = 1")["count"];
$male = $db->getFirst("SELECT count(*) as count FROM !accounts WHERE !sex = 1")["count"];
$female = $players - $male;
$admins = $db->getFirst("SELECT count(*) as count FROM !accounts WHERE !adminrights > 0")["count"];
$idle = $db->getFirst("SELECT count(*) as count FROM !accounts WHERE !job = 0")["count"];
$employed = $players - $idle;
$civil = $db->getFirst("SELECT count(*) as count FROM !accounts WHERE !faction = 0")["count"];
$leader = $db->getFirst("SELECT count(*) as count FROM !accounts WHERE !leader > 0")["count"];
$coins = (getConfig("data_coins") == null)?0:$db->getFirst("SELECT sum(!coins) as count FROM !accounts")["count"];
$wanteds = $db->getFirst("SELECT sum(!wanteds) as count FROM !accounts")["count"];
$respect = $db->getFirst("SELECT sum(!respect) as count FROM !accounts")["count"];
$house = (getConfig("data_house") == null)?0:$db->getFirst("SELECT count(*) as count FROM !accounts WHERE !house > 0")["count"];
$business = (getConfig("data_business") == null)?0:$db->getFirst("SELECT count(*) as count FROM !accounts WHERE !business > 0")["count"];
$cash = $db->getFirst("SELECT sum(!cashmoney) as count FROM !accounts")["count"];
$bankmoney = $db->getFirst("SELECT sum(!bankmoney) as count FROM !accounts")["count"];
$totalmoney = $cash + $bankmoney;
$supporter_applications = $db->getFirst("SELECT count(*) as count FROM supporter_applications")["count"];
$leader_applications = $db->getFirst("SELECT count(*) as count FROM leader_applications")["count"];
$supports = $db->getFirst("SELECT count(*) as count FROM support_tickets")["count"];
$supports_open = $db->getFirst("SELECT count(*) as count FROM support_tickets WHERE status < 2")["count"];
$supports_closed = $supports - $supports_open;
$complaints = $db->getFirst("SELECT count(*) as count FROM complaints")["count"];
$complaints_solved = $db->getFirst("SELECT count(*) as count FROM complaints WHERE status = 2")["count"];
?>
    <table border="0" class="table-bordered">
    <tr>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-user"></span> Spieler</b></h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>registrierte Spieler:</b></td>
                    <td><?= $players ?></td>
                </tr>
                <tr>
                    <td><b>gebannte Spieler:</b></td>
                    <td><?= $banned ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der m&auml;nnlichen Spieler:</b></td>
                    <td><?= $male ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der weiblichen Spieler:</b></td>
                    <td><?= $female ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der Teammitglieder:</b></td>
                    <td><?= $admins ?></td>
                </tr>
            </table>
        </td>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-lock"></span> Jobs</b></h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Anzahl aller Arbeitslosen:</b></td>
                    <td><?= $idle ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl aller Arbeitnehmer:</b></td>
                    <td><?= $employed ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-list-alt"></span> Fraktionen</b>
            </h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Anzahl aller Zivilisten:</b></td>
                    <td><?= $civil ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl aller Leader:</b></td>
                    <td><?= $leader ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-asterisk"></span> Allgemein</b>
            </h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Premiumcoins im Umlauf:</b></td>
                    <td><?= $coins ?></td>
                </tr>
                <tr>
                    <td><b>Wanteds insgesamt:</b></td>
                    <td><?= $wanteds?></td>
                </tr>
                <tr>
                    <td><b>Respektpunkte insgesamt:</b></td>
                    <td><?= $respect ?></td>
                </tr>
                <tr>
                    <td><b>Hausbesitzer insgesamt:</b></td>
                    <td><?= $house ?></td>
                </tr>
                <tr>
                    <td><b>Unternehmensbesitzer insgesamt:</b></td>
                    <td><?= $business ?></td>
                </tr>
            </table>
        </td>
        <td align="center"><a style="font-size:100px;" class="glyphicon-stats glyphicon"></a>
        </td>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-usd"></span> Finanzen</b></h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Bargeld im Umlauf:</b></td>
                    <td><?= $cash . ",00 SA$" ?></td>
                </tr>
                <tr>
                    <td><b>Geld auf Konten:</b></td>
                    <td><?= $bankmoney . ",00 SA$" ?></td>
                </tr>
                <tr>
                    <td><b>Gesamtgeld im Umlauf:</b></td>
                    <td><?= $totalmoney . ",00 SA$" ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-folder-open"></span> 
                    Bewerbungen</b></h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Anzahl der Leader-Bewerbungen:</b></td>
                    <td><?= $leader_applications ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der Supporter-Bewerbungen:</b></td>
                    <td> <?= $supporter_applications ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-comment"></span> Support</b></h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Anzahl der offenen Supporttickets:</b></td>
                    <td><?= $supports_open ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der geschlossenen Supporttickets:</b></td>
                    <td><?= $supports_closed?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der Supporttickets:</b></td>
                    <td><?= $supports ?></td>
                </tr>
            </table>
        </td>
        <td><h4 class="sub-header" align="center"><b><span class="glyphicon glyphicon-bullhorn"></span> Beschwerden</b>
            </h4>
            <table class="table table-striped" id="optimize" align="center">
                <tr>
                    <td><b>Anzahl der Beschwerden:</b></td>
                    <td><?= $complaints ?></td>
                </tr>
                <tr>
                    <td><b>Anzahl der abgeschlossenen F&auml;lle:</b></td>
                    <td><?= $complaints ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php include_once("templates/footer_acp.php");