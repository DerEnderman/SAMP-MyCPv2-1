<?php
$title = "Aktion: Leaderbewerbungen ablehnen";
include("global.php");
require_admin();

$id = (int)$_GET["Id"];
$db->query("UPDATE `leader_applications` SET `status`='2' WHERE id =" . $id . ";");
user_log("reject_leader", "Leader-Bewerbung $id abgelehnt.");
redirect("acp_applications.php?status=1");
