<?php
include_once("global.php");
require_once("config.php");
header("Content-Type: applications/json");
if (!isset($_SESSION['username']))
    die();
if (!isset($_GET["username"]) || strlen($_GET["username"]) < 3)
    die();
$username = $_GET["username"] . "%";

$users = $db->getAll("SELECT !username FROM !accounts WHERE !username LIKE ? LIMIT 0,3", $username);
$names = array();
foreach ($users as $user)
    $names[] = $user["!username"];
echo json_encode($names);