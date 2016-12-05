<?php
$currentPage = "acp_multiaccounts.php";
include("global.php");

require_admin();
$title = "Multiaccounts aufspüren";
include_once("templates/header_acp.php");
flush();
$logins = $db->getAll("SELECT !username as username, `action`, l.ip  FROM user_log l JOIN !accounts a ON a.id= l.user WHERE action='login'");
$IPs = array();

foreach ($logins as $login) {
    if ($login["ip"] == "127.0.0.1" ||$login["ip"] == "::1")
        continue;
    if (!isset($IPs[$login["ip"]]))
        $IPs[$login["ip"]] = array();
    if (!in_array($login["username"], $IPs[$login["ip"]]))
        $IPs[$login["ip"]][] = $login["username"];
}
unset($logins);

$multis = array();
foreach($IPs as $ip => $accounts) {
    if (sizeof($accounts) < 2)
        continue;
    sort($accounts);
    $accountsString = implode(", ", $accounts);
    if (!isset($multis[$accountsString]))
        $multis[$accountsString] = array();
    $multis[$accountsString][] = $ip;
}
unset($IPs);
 ?>
<style>
    .suspect {
        border: solid 1px red;
        border-radius: 5px;
        padding:10px;
    }
</style>
<?php
if (!sizeof($multis)) { ?>
    <div class='alert alert-success fade in' role='alert'>
        <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>
        <strong>Hinweis: </strong>Es wurden keine Multiaccounts entdeckt.
    </div>
<?php } else { ?>
    <div class='alert alert-warning fade in' role='alert'>
        <button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>
        <strong>Hinweis: </strong>Diese Suche basiert einzig auf der IP-Adresse und sollte nur ein Indikator, keinesfalls aber ein Beweis
        für einen Multiaccount sein.
    </div>
    <?php
    foreach ($multis as $accounts => $IPs) { ?>
        <div class="suspect">
            <h5>Verdacht: <?= $accounts?></h5>
            Die Benutzer waren mit <?= sizeof($IPs)>1?" folgenden IP-Adressen ":"folgender IP-Adresse "?> gleichzeitig angemeldet:<hr>
            <ul>
                <?php foreach ($IPs as $ip) { ?>
                    <li><?= $ip?> (<?= gethostbyaddr($ip)?>)</li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
<?php }

include_once("templates/footer_acp.php");