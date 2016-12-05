<?php
$title = "Aktion: Benutzeraccount ansehen";
include("global.php");
require_admin();

$selected_user = htmlspecialchars($_GET["userId"]);
$_SESSION["userId"] = $selected_user;
redirect("useraccount.php?show_profile=true");