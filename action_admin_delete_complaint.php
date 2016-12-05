<?php
$title = "Aktion: Beschwerdefall löschen";
include("global.php");
require_admin();

$id = (int)$_GET["complaintId"];
$db->query("DELETE FROM complaints WHERE id = ?", $id);
user_log("delete_complaint", "Beschwerde $id gelöscht.");
redirect("acp_complaints.php?complaint_status=2");
