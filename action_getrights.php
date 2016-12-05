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
    $TS_verifydescription = $row['TS_verifydescription'];


    $TS_UID = $_POST["TS_UID"];


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
        if ($ts3_VirtualServer->serverGroupClientAdd($TS_servergroupID, $client[0])) {
            echo "";
        }

        $client2 = $ts3_VirtualServer->clientGetByUid($TS_UID);
        $properties = array("client_description" => $TS_verifydescription);
        if ($client2->modify($properties)) {
            echo "";
        }

        $username = $_SESSION["username"];
        $db->query("UPDATE !accounts SET `verified`= '1', `TS_UID`= ? WHERE !username = ?", $TS_UID, $username);
        user_log("teamspeak_verify");
        redirect("user_ts_settings.php?status=1");


    } catch (Exception $e) {
        echo "Es ist ein Fehler aufgetreten!<br/>Fehler-Code: " . $e->getCode() . "</b> Beschreibung: <b>" . $e->getMessage() . "</b>";
    }