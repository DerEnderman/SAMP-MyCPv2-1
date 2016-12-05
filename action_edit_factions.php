<?php
$title = "Aktion: Fraktionen überarbeiten";
include("global.php");

require_admin();
if (isset($_POST["faction_logo"]))
{
    foreach ($_POST["faction_logo"] as $key => $value)
    {
        $db->query("UPDATE faction_informations SET image = ? WHERE faction_id = ?", $value, $key);
    }
}

for ($i=1;$i<21;$i++) {
    $db->query("UPDATE factions SET faction_$i = ?", $_POST["faction_$i"]);
}


redirect("acp_factions.php?status=success");