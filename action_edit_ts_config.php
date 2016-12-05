<?php
$title = "Aktion: Reiter 'Konfiguration' der TeamSpeak-Einstellungen überarbeiten";
include("global.php");
require_admin();

$allowed = array("TS_servergroupname", "TS_servergroupID", "TS_verifydescription");
$config = filterInput($_POST, $allowed);
saveConfig($config);

user_log("edit_ts");
redirect("acp_teamspeak.php?status=success");
