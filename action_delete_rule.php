<?php
$title = "Aktion: Regel löschen";
include("global.php");
require_admin();

$selected_object = (int)$_GET["ruleId"];
$action = mysql_real_escape_String($_GET["action"]);
$result = $db->query("DELETE FROM `rules` WHERE id = '$selected_object'") or die(mysql_error());
user_log("delete_rule", "Regel §$selected_object gelöscht");
redirect("acp_rules.php?status=2");
