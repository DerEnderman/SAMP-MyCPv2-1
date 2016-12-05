<?php
$title = "Aktion: Reiter 'Strafen / Sanktionen' im Regelwerk überarbeiten";
include("global.php");
require_admin();
saveConfig(array("rules_tab3" => $_POST["selected_object2"]));
user_log("edit_rule");
redirect("acp_rules.php?status=3");