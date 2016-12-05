<?php
$title = "Aktion: Leaderbewerbungen ansehen";
include("global.php");
require_admin();

$selected_object = $_GET["Id"];
$_SESSION["object_id"] = $selected_object;
redirect("leader_application.php?show_application=true");

