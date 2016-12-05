<?php

include("global.php");
require_login();

$username = $_SESSION['username'];
$data2 = $db->getFirst("SELECT !leader, !faction FROM !accounts WHERE !username = ?", $username);

$user_leader = $data2["!leader"];


if ($user_leader == 0)
    redirect("error.php?errorid=3.php");

$id = (int)$_GET["Id"];
$db->query("UPDATE `faction_applications` SET `status`='2' WHERE id = ? AND faction = ?", $id, $data2["!faction"]);
user_log("reject_faction_application");
redirect("faction_listapplications.php?status=1");