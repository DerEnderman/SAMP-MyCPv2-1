<?php
$title = "Aktion: Benutzeraccount löschen";
include("global.php");
require_admin();

$selected_user = (int)$_GET["userId"];
$action = $_GET["action"];

$row = getConfig();
$ts_ipadress = $row['ts_ipadress'];
$ts_port = $row['ts_port'];
$ts_query_admin = $row['ts_query_admin'];
$ts_query_password = $row['ts_query_password'];
$ts_query_port = $row['ts_query_port'];
$ts_query_user_nick = $row['ts_query_user_nick'];

$TS_servergroupID = $row['TS_servergroupID'];
$status_ts_controller = $row['status_ts_controller'];

$data2 = $db->getFirst("SELECT * FROM !accounts WHERE !id = ?", $selected_user);
user_log("delete_user", "Nutzer $selected_user gelöscht");

$TS_UID = $data2['TS_UID'];
$verified = $data2['verified'];


if ($status_ts_controller == 1) //way without TS
{
    $db->query("DELETE FROM !accounts WHERE !id = '$selected_user'") or die(mysql_error());
    redirect("acp_user.php?status=5");
}
if ($status_ts_controller == 0) //way with TS
{
    if ($verified == 0)
    {
        $db->query("DELETE FROM !accounts WHERE !id = '$selected_user'") or die(mysql_error());
        redirect("acp_user.php?status=5");
        }
        else
        {
            if ($verified == 1)
            {
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

                } catch (Exception $e)
                {
                    echo "Es ist ein Fehler aufgetreten!<br/>Fehler-Code: " . $e->getCode() . "</b> Beschreibung: <b>" . $e->getMessage() . "</b>";
                }

                $db->query("DELETE FROM !accounts WHERE !id = '$selected_user'") or die(mysql_error());
                redirect("acp_user.php?status=5");
            }
        }
    }


