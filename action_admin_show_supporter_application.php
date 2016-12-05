<?php
require_once("config.php");
include("global.php");
session_start();
error_reporting(0);

if (isset($_SESSION['username']))
{
    $id = $_SESSION["id"];
    $user = $db->getFirst("SELECT !adminrights as admin FROM !accounts WHERE !id = ?", $id);
    if (!$user["admin"])
    {
        redirect("error.php?errorid=1.php");
    }
    $selected_object = $_GET["Id"];
    $_SESSION["object_id"] = $selected_object;
    redirect("supporter_application.php?show_application=true");
}
redirect("index.php");