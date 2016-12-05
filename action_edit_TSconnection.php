<?php
$title = "Aktion: TeamSpeak-Einstellungen überarbeiten";
include("global.php");
require_admin();

$allowed = array('ts_ipadress', 'ts_port', 'ts_query_admin', 'ts_query_password',  'ts_query_port', 'ts_query_user_nick', );
$config = filterInput($_POST, $allowed);
array_map('rawurlencode', $config);
saveConfig($config);
user_log("edit_ts");
redirect("acp_teamspeak.php?status=success");