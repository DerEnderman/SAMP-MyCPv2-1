<?php

include("global.php");
require_login();

$date_of_creation = date("Y-m-d H:i:s");
$creator = $_SESSION['username'];
$application_text = sanitize($_POST['application_text']);


$db->query("INSERT INTO supporter_applications (`date_of_creation`, `creator`, `application_text`, `status`) VALUES (?, ?, ?, 1)", $date_of_creation, $creator, $application_text);
user_log("add_supporter_application");
redirect("applications.php?status=6");
