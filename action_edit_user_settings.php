<?php
include("global.php");
require_login();
$allowed = array('email', 'password', 'sex', 'age',);
$filtered = filterInput($_POST, $allowed);
if (empty($filtered["password"]))
    unset($filtered["password"]);
else
    $filtered["password"] = getPasswordHash($filtered["password"]);
user_log("user_edit_settings");
$newUser = array();
$config = getConfig();
foreach ($filtered as $key => $value){
    $newUser[$config["data_".$key]] = $value;
}
if ($db->edit("accounts", $_SESSION["id"], $newUser, "!id"))
    redirect("user_settings.php?status=success");
redirect("error.php");