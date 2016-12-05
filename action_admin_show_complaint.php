<?php
$title = "Aktion: Beschwerdefall ansehen";
include("global.php");
require_admin();

$selected_object = htmlspecialchars($_GET["complaintId"]);
$_SESSION["complaint_id"] = $selected_object;

redirect("admincomplaint.php?show_complaint=true");
