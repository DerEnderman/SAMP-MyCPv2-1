<?php
$title = "Aktion: TeamSpeak-Rechte eines Benutzers entziehen";
include("global.php");
require_admin();

$selected_user = $_GET["userId"];

$row = getConfig();
$ts_ipadress = $row['ts_ipadress'];
$ts_port = $row['ts_port'];
$ts_query_admin = $row['ts_query_admin'];
$ts_query_password = $row['ts_query_password'];
$ts_query_port = $row['ts_query_port'];
$ts_query_user_nick = $row['ts_query_user_nick'];

$TS_servergroupID = $row['TS_servergroupID'];


$data2 = $db->getFirst("SELECT * FROM !accounts WHERE !id = ?", $selected_user);
$TS_UID = $data2['TS_UID'];


require_once('TS3_Framework/libraries/TeamSpeak3/TeamSpeak3.php');
$server = array(
    "tsip" => $ts_ipadress,
    "tsport" => $ts_port,
    "ts_query_admin" => $ts_query_admin,
    "ts_query_password" => $ts_query_password,
    "ts_query_port" => $ts_query_port,
    "ts_query_user_nick" => $ts_query_user_nick
);

try
{
    TeamSpeak3::init();
    $ts3_VirtualServer = TeamSpeak3::factory("serverquery://" . $server["ts_query_admin"] . ":" . $server["ts_query_password"] . "@" . $server["tsip"] . ":" . $server["ts_query_port"] . "/?server_port=" . $server["tsport"] . "&nickname=" . $server["ts_query_user_nick"] . "");

    $client = $ts3_VirtualServer->clientFindDb($TS_UID, true);
    if ($ts3_VirtualServer->serverGroupClientDel($TS_servergroupID, $client[0]))
    {
        echo "";
    }

    $client2 = $ts3_VirtualServer->clientGetByUid($TS_UID);
    $properties = array("client_description" => "");
    if ($client2->modify($properties))
    {
        echo "";
    }

} catch (Exception $e)
{
    echo "Es ist ein Fehler aufgetreten!<br/>Fehler-Code: " . $e->getCode() . "</b> Beschreibung: <b>" . $e->getMessage() . "</b>";
}

$db->query("UPDATE `!accounts` SET `TS_UID`='nicht vohanden', `verified`='0' WHERE !id =" . htmlspecialchars($_GET["userId"]) . ";") or die(mysql_error());
redirect("acp_user.php?status=2");