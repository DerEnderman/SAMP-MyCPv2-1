<?php

include("global.php");

if (isset($_POST['submit']))
{
    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $user = $db->getFirst("SELECT !id, !username, !password, !banned FROM !accounts WHERE !username = ?", array($_POST["username"]));
        $password = $_POST["password"];
        $username = $_POST["username"];
        if ($user)
        {
            $dbusername = $user["!username"];
            $dbpassword = $user["!password"];
            $banned = $user["!banned"];
            if (strtoupper(getPasswordHash($password)) == strtoupper($dbpassword))
            {
                if ($banned)
                {
                    echo json_encode(array("error" => true, "message" => "Dieser Benutzeraccount ist gebannt. Du kannst dich nicht einloggen."));
                }
                else
                {
                    $_SESSION['username'] = $dbusername;
                    $_SESSION["id"] = $user["!id"];
                    user_log("login");

                    $time = date("Y-m-d H:i:s");
                    $db->query("UPDATE !accounts SET !lastlogin = ? WHERE !username = ?", array($time, $username));
                    echo json_encode(array("error" => false));
                }
            }
            else
            {
                echo json_encode(array("error" => true, "message" => "Das eingegebene Passwort ist inkorrekt."));
            }
        }
        else
        {
            echo json_encode(array("error" => true, "message" => "Dieser Benutzeraccount existiert nicht."));
        }
    }
}            