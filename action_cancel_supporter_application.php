<?php

include("global.php");
require_login();

$username = $_SESSION['username'];
$db->query("DELETE FROM supporter_applications WHERE creator = ?", $username);
redirect("applications.php?status=3");
