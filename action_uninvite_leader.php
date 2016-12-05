<?php
$title = "Aktion: Leader entlassen";
include("global.php");

require_admin();
if (isset($_GET["userId"])) {
    $id = (int)$_GET["userId"];
    user_log("uninvite_leader", "$id entlassen");
    if (!$db->query("UPDATE !accounts SET !faction = 0, !leader = 0 WHERE !id = ?", $id))
        redirect("error.php?errorid=4");
    redirect("acp_user.php?status=1");
}