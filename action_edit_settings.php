<?php
$title = "Aktion: Einstellungen überarbeiten";
include("global.php");
require_admin();
$allowed = array('projectname', 'samp_ipadress', 'projectdescription', 'status_ts_controller', 'status_supporter_application', 'status_leader_application', 'status_whosonline_list', 'login_background', 'login_logo', 'status_forum', 'href_forum', 'status_finances', 'ts3_ipadress');
$config = filterInput($_POST, $allowed);
saveConfig($config);
user_log("edit_settings");
redirect("acp_settings.php?status=success");