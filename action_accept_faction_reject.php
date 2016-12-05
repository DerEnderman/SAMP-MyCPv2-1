<?php

include("global.php");
require_login();

if ($db->query("DELETE FROM faction_applications WHERE creator = ?", $_SESSION["username"]))
{
    redirect("applications.php");
}