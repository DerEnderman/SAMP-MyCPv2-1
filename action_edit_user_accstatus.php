<?php
$title = "Aktion: Benutzeraccount bannen / entbannen";
include("global.php");
require_admin();
$selected_user = (int) $_GET["userId"];
$action = (int)$_GET["action"];


if ($action === 0) { //0 = entbannen
    $db->query("UPDATE !accounts SET !banned=0 WHERE !id = ?", $selected_user);
    user_log("unban_user", "Nutzer $selected_user entbannt.");
    redirect("acp_user.php?status=3");
}
elseif ($action === 1) {
    $db->query("UPDATE !accounts SET !banned=1 WHERE !id = ?", $selected_user);
    user_log("ban_user", "Nutzer $selected_user gebannt.");
    $user = $db->getFirst("SELECT verified, TS_UID FROM !accounts WHERE !id = ?", $selected_user);
    if (getConfig("status_ts_controller" && $user["verified"])) {
        TeamspeakRemoveUserFromGroup($user["TS_UID"], getConfig("TS_servergroupID"));
    }
    redirect("acp_user.php?status=4");
}
