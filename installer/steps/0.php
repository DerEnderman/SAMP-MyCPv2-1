<?php
define("PHP_RELEASES", "http://php.net/releases/index.php?serialize=1&version=5&max=800");
$title = "Willkommen bei der Installation von myCP $installVersion!";
$missing = false;
$php = array();
$php["name"] = "PHP";
$php["version"] = PHP_VERSION;
$php["version_needed"] = "5.1.0";
$php["status"] = version_compare(PHP_VERSION, $php["version_needed"], ">=");
$php["comment"] = "myCP $installVersion benötigt PHP Version " . $php["version_needed"]. " und Version ". $php["version"]. " ist installiert.\n";
if ($releases = @file_get_contents(PHP_RELEASES)) {
    $releases = unserialize($releases);
    if (isset($releases[PHP_VERSION]["source"][0]["date"]))
    {
        $date = $releases[PHP_VERSION]["source"][0]["date"];
        if (time() - strtotime($date) > 4*7*24*60*60) {
            $php["comment"] .= "Die installierte Version " .$php["version"] ." wurde am $date veröffentlicht und ist <b>nicht mehr aktuell!</b>
            Aktuellere Versionen sind eventuell <b>schneller</b> und <b>sicherer</b>. ";
            foreach ($releases as $key => $value) {
                $date = $value["source"][0]["date"];
                $php["comment"] .= "Wir empfehlen, PHP $key vom $date zu installieren.";
                break;
            }
        }
    }
}

$config = getConfig();
if (isset($config["mysql_user"]))
    $_SESSION["MySQLuser"] = $config["mysql_user"];
if (isset($config["mysql_password"]))
    $_SESSION["MySQLpassword"] = $config["mysql_password"];
if (isset($config["mysql_host"]))
    $_SESSION["MySQLhost"] = $config["mysql_host"];
if (isset($config["mysql_database"]))
    $_SESSION["MySQLdatabase"] = $config["mysql_database"];
foreach ($config as $key => $value)
    $_SESSION[$key] = $value;


$mysql = array();
$mysql["name"] = "MySQL Erweiterung";
$mysql["status"] = in_array("mysql", PDO::getAvailableDrivers() );
if (!$mysql["status"]) {
    $mysql["comment"] = "Die MySQL-Erweiterung ist nicht verfügbar. Genau die wird aber benötigt.";
}

$permissions = array();
$permissions["name"] = "Schreibrechte im aktuellen Verzeichnis";
$permissions["status"] = is_writable(getcwd());
if (!$permissions["status"]) {
    $permissions["comment"] = "Der Benutzer <kbd>".get_current_user()."</kbd> muss Schreibrechte im Verzeichnis <kbd>". getcwd() . "</kbd> besitzen.";
}

$dependencies[] = $php;
$dependencies[] = $mysql;
$dependencies[] = $permissions;

if ($missing)
    $statusText = "Die Abhängigkeiten für myCP $installVersion werden nicht erfüllt. Die Installation kann nicht fortfahren.";
else
    $statusText = "Hervorragend! myCP $installVersion ist zur Installation bereit.";

