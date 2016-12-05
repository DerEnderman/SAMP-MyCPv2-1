<?php
chdir("..");
include_once("global.php");
checkCronjobKey();
include_once("include/SAMP_Query_API.php");
echo("In den Einstellungen ist '" . getConfig("samp_ipadress") . "' als Server hinterlegt.<br>");

$query = new SampQueryAPI(getConfig("samp_ipadress"));
$players = (int)$online = $query->isOnline();
if ($online) {
    $players = $query->getInfo();
    $players = $players["players"];
}
echo "Der Server ist ";
echo ($online) ? "online" : "offline<br>";
$db->add("server_monitor", array("date" => date('Y-m-d H:i:s'), "online" => $online, "player_online" => $players));