<?php

include("global.php");
require_login();

$date_of_creation = date("Y-m-d H:i:s");
$creator = $_SESSION['username'];
$faction = sanitize($_POST['selected_faction']);
$application_text = sanitize($_POST['application_text']);

$db->query("INSERT INTO leader_applications (`date_of_creation`, `creator`, `faction`, `application_text`, `status`) VALUES (?, ?, ?, ?, 1)", $date_of_creation, $creator, $faction, $application_text);
user_log("add_leader_application");
redirect("applications.php?status=5");

