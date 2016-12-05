<?php
$title = "Aktion: Leaderbewerbungen annehmen";
include("global.php");
require_admin();

$id = (int)$_GET["Id"];
$data = $db->getFirst("SELECT * FROM leader_applications WHERE id = ?", $id);

$creator = $data['creator'];
$faction = $data['faction'];

$db->query("UPDATE !accounts SET `!leader` ='$faction', `!faction`='$faction' WHERE !username = ?", $creator);
$db->query("DELETE FROM leader_applications WHERE id = ?", $id);
user_log("make_leader", "Nutzer $creator in Fraktion $faction zum Leader gemacht.");
redirect("acp_applications.php?status=2");
