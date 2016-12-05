<?php
$title = "Aktion: Benutzeraccount überarbeiten";
include("global.php");
require_admin();
$selected_user = (isset($_GET["userId"])) ? $_GET["userId"] : 0;
user_log("edit_user", "Nutzer $selected_user bearbeitet.");
$allowed = array('level', 'leader', 'password', 'faction', 'email', 'rank', 'sex', 'age', 'cashmoney', 'bankmoney', 'ucp_adminrights',);
if (isset($db_config["data_coins"]) && !empty($db_config["data_coins"]))
    $allowed[] = "coins";
$filtered = filterInput($_POST, $allowed);
if (empty($filtered["password"]))
{
    unset($filtered["password"]);
}
else
{
    $filtered["password"] = getPasswordHash($filtered["password"]);
}
$newUser = array();
$config = getConfig();
foreach ($filtered as $key => $value)
{
    $newUser[$config["data_" . $key]] = $value;
}
$db->edit("accounts", $selected_user, $newUser, "!id");
redirect("useraccount.php?show_profile=true&status=1");