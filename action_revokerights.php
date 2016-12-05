<?php

include("global.php");
require_login();

//Aktion
    $row = getConfig();
    $ts_ipadress = $row['ts_ipadress'];
    $ts_port = $row['ts_port'];
    $ts_query_admin = $row['ts_query_admin'];
    $ts_query_password = $row['ts_query_password'];
    $ts_query_port = $row['ts_query_port'];
    $ts_query_user_nick = $row['ts_query_user_nick'];

    $TS_servergroupID = $row['TS_servergroupID'];

$username = $_SESSION["username"];
$data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = ?", $username);
user_log("teamspeak_revoke_access");
$TS_UID = $data2['TS_UID'];


//Teamspeak
    require_once('TS3_Framework/libraries/TeamSpeak3/TeamSpeak3.php');
    $server = array(
        "tsip" => $ts_ipadress,
        "tsport" => $ts_port,
        "ts_query_admin" => $ts_query_admin,
        "ts_query_password" => $ts_query_password,
        "ts_query_port" => $ts_query_port,
        "ts_query_user_nick" => $ts_query_user_nick
    );

    try {
        TeamSpeak3::init();
        $ts3_VirtualServer = TeamSpeak3::factory("serverquery://" . $server["ts_query_admin"] . ":" . $server["ts_query_password"] . "@" . $server["tsip"] . ":" . $server["ts_query_port"] . "/?server_port=" . $server["tsport"] . "&nickname=" . $server["ts_query_user_nick"] . "");

        $client = $ts3_VirtualServer->clientFindDb($TS_UID, true);
        if ($ts3_VirtualServer->serverGroupClientDel($TS_servergroupID, $client[0])) {
            echo "";
        }

        $client2 = $ts3_VirtualServer->clientGetByUid($TS_UID);
        $properties = array("client_description" => "");
        if ($client2->modify($properties)) {
            echo "";
        }

        $db->query("UPDATE !accounts SET verified = '0', TS_UID = 'nicht vorhanden' WHERE !username = ?", $username);
        redirect("user_ts_settings.php?status=2");


    } catch (Exception $e) {
        echo "Es ist ein Fehler aufgetreten!<br/>Fehler-Code: " . $e->getCode() . "</b> Beschreibung: <b>" . $e->getMessage() . "</b>";
    }