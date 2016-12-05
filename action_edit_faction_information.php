<?php

include("global.php");
require_login();
$user = $db->getFirst("SELECT !leader as leader, !faction as faction FROM !accounts WHERE !id = ?", $_SESSION["id"]);
if (!$user["leader"] || !$user["faction"])
    redirect("error.php?errorid=3");
$selected_faction = (int)(isset($_GET["faction"]))?$_GET["faction"]:0;
if ($selected_faction == $user["faction"] && isset($_POST["selected_object"])) {
    $text = strip_tags($_POST["selected_object"], "<b><i><font><hr><ul><li><img><a>");
    $db->query("UPDATE faction_informations SET text = ? WHERE faction_id = ?", $text, $selected_faction);
    user_log("edit_faction_informations", "Fraktionsbeschreibung geändert: $text");
    redirect("faction.php?status=1");
}
redirect("index.php");
