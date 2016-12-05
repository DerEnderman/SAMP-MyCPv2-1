<?php
require_once("config.php");
include("global.php");
session_start();
error_reporting(0);

if (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    $db->query("DELETE FROM online_list WHERE username = ?", array($username));
    session_destroy();
}
redirect("index.php");
