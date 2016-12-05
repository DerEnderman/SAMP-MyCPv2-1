<?php
include("global.php");
require_login();

if ($db->query("DELETE FROM supporter_applications WHERE creator = ?", $_SESSION["username"]))
{
    redirect("applications.php");
}
redirect("error.php");
