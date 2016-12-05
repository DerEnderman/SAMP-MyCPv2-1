<?php
$title = "Aktion: Beschwerdefall schließen";
include("global.php");
require_admin();

$id = (int)$_GET["complaintId"];
$db->query("UPDATE `complaints` SET `status`='2' WHERE id =" . $id . ";");
user_log("close_complaint", "Beschwerde $id geschlossen.");
redirect("acp_complaints.php?complaint_status=1");