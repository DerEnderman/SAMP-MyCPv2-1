<?php

include("global.php");
require_login();


$user = $db->getFirst("SELECT !leader, !faction FROM !accounts WHERE !id = ?", $_SESSION["id"]);

$leader = $user["!leader"];
$faction = $user["!faction"];
if ($leader == 0) {
    redirect("error.php?errorid=3");
}

$id = (int)$_GET["Id"];
$data = $db->getFirst("SELECT * FROM faction_applications WHERE id = ? AND faction = ?;", $id, $faction);
$creator = $data['creator'];
$faction = $data['faction'];

$result2 = $db->query("UPDATE !accounts SET !faction = ? WHERE !username = ?", $faction, $creator);
user_log("faction_invite", "Nutzer $creator in Fraktion $faction eingeladen.");
$result = $db->query("DELETE FROM `faction_applications` WHERE id = ?", $id);
redirect("faction_listapplications.php?status=2");

