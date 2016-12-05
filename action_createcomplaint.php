<?php

include("global.php");
require_login();

$date_of_creation = date("Y-m-d H:i:s");
$creator = $_SESSION['username'];
$perpetrator = sanitize($_POST['complaint_perpetrator']);
$case = sanitize($_POST['complaint_case']);
$info = sanitize($_POST['complaint_info']);
$screen_1 = str_replace("'","", sanitize($_POST['complaint_screen_1']));
$screen_2 = str_replace("'","", sanitize($_POST['complaint_screen_2']));
$screen_3 = str_replace("'","", sanitize($_POST['complaint_screen_3']));


$db->query("INSERT INTO complaints (`date_of_creation`, `creator`, `perpetrator`, `case`, `info`, `screen_1`, `screen_2`, `screen_3` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", $date_of_creation,$creator, $perpetrator, $case, $info, $screen_1, $screen_2, $screen_3);
user_log("create_complaint", "Beschwerde gegen $perpetrator geschrieben.");
redirect("support.php?complaint_status=1");

