<?php

include("global.php");
require_login();


$username = $_SESSION['username'];
$data2 = $db->getFirst("SELECT !leader, !faction, !id FROM !accounts WHERE !username = ?", $username);
$user_leader = $data2["!leader"];
$user_faction = $data2["!faction"];
$user_id = $data2["!id"];

if ($user_leader == 0) {
    redirect("error.php?errorid=3");
}
$id = (int)$_GET["userId"];
if ($id == $user_id)
{
    redirect("faction_member.php?status=2");
}
else
{
    $data2 = $db->getFirst("SELECT !leader, !id, !faction FROM !accounts WHERE !id = '$id'");
    $selected_user_faction = $data2["!leader"];
    $selected_user_id = $data2["!id"];
    $selected_user_faction = $data2["!faction"];

    if ($selected_user_faction == $user_faction)
    {
        $db->query("UPDATE !accounts SET !faction = '0', !rank = '0' WHERE !id = ?", $id);
        user_log("uninvite_member", "$id entlassen");
        redirect("faction_member.php?status=1");
    }
    else
    {
        redirect("error.php?errorid=4");
    }
}