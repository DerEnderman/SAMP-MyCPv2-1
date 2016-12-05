<?php

include("global.php");
require_login();


$username = $_SESSION['username'];
$data2 = $db->getFirst("SELECT !leader, !faction FROM !accounts WHERE !username = ?", $username);
$user_leader = $data2["!leader"];
$faction = $data2["!faction"];


$id = (int)$_GET["Id"];
$data3 = $db->getFirst("SELECT * FROM faction_applications WHERE id = ? AND faction = ?;", $id, $faction);

if (!is_array($data3)) {
    redirect("error.php?errorid=3.php");
}

$selected_object = (int)$_GET["Id"];
$_SESSION["object_id"] = $selected_object;
redirect("faction_application.php?show_application=true");