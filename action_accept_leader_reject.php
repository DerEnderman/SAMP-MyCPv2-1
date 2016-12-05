<?php

include("global.php");
require_login();

if ($db->query("DELETE FROM leader_applications WHERE creator = ?", $_SESSION["username"]))
{
    redirect("applications.php");
}
