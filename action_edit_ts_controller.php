<?php
$title = "Aktion: TeamSpeak-Controller aktivieren / deaktivieren";
include("global.php");
require_admin();
try {
    $db->query("ALTER TABLE !accounts ADD COLUMN verified INT(11) AFTER !adminrights");
}
catch(Exception $e) {
}
try {
    $db->query("ALTER TABLE !accounts ADD COLUMN TS_UID VARCHAR(45) AFTER verified");
}
catch(Exception $e) {
}
saveConfig(array("status_ts_controller" => (int)$_POST["status_ts_controller"]));
user_log("toggle_ts3controller");
redirect("acp_teamspeak.php?status=success");