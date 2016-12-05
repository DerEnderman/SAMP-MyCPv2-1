<?php

include("global.php");
require_login();

$username = $_SESSION['username'];
$db->query("DELETE FROM leader_applications WHERE creator = ?", $username);
redirect("applications.php?status=2");

