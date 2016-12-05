<?php
$title = "Aktion: Supporterbewerbung ablehnen";
include("global.php");
require_admin();

$id = (int)$_GET["Id"];
$result = $db->query("UPDATE `supporter_applications` SET `status`='2' WHERE id =" . $id . ";");
user_log("reject_leader", "Supporter-Bewerbung $id abgelehnt.");
redirect("acp_applications.php?status=3");
