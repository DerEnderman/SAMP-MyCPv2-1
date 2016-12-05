<?php
if (file_exists("./installer/GO")) {
    if (file_exists("templates/header_general.php"))
        include_once("templates/header_general.php");
    echo "<h1>Installation im Gange</h1>";
    echo "<p>Das Control Panel ist vorrübergehend nicht verfügbar. Bitte versuchen Sie es in Kürze erneut.</p>";
    if (file_exists("templates/header_general.php"))
        include_once("templates/header_general.php");
    die();
}
include_once("config.php");
session_start();
error_reporting(0);
/* general */
function sanitize($string)
{
    return htmlspecialchars($string);
}

function getConfig($key = null) {
    global $_CONFIG;
    if (!isset($_CONFIG)) {
        if (file_exists(BASEDIR."/config.php"))
            include_once(BASEDIR."/config.php");
        else
            return array();
    }
    if ($key !== null) {
        if (!isset($_CONFIG[$key]))
            return null;
        return $_CONFIG[$key];
    }
    return $_CONFIG;
}

function saveConfig($data) {
    global $_CONFIG;
    $old = getConfig();
    $new = array_merge($old, $data);
    $_CONFIG = $new;
    foreach ($new as $key => $value)
        if (is_numeric($key))
            unset($new[$key]);
    $content = "<?php\n";
    $content .= '//Stand: '.date("r")."\n";
    $content .= '$_CONFIG = ';
    $content .= var_export($new, true);
    $content .= ";\n\n";
    $content .= $new["hashFunction"];
    file_put_contents("./config.php", $content);
}


/* get informations*/
function get_projectname()
{
    $config = getConfig();
    echo $config["projectname"];
}

function get_projectdescription()
{
    $config = getConfig();
    echo $config["projectdescription"];
}

function get_sampip()
{
    $config = getConfig();
    echo $config["samp_ipadress"];
}

function get_ts3ip()
{
    $config = getConfig();
    echo $config["ts3_ipadress"];
}

function get_username()
{
    $username = $_SESSION['username'];
    echo $username;
}

function get_footer3()
{
    $config = getConfig();
    echo "<p>" . $config["footer_content_3"] . "</p>";
}

function get_footer2()
{
    $config = getConfig();
    echo "<p>" . $config["footer_content_2"] . "</p>";
}


/* show informations */
function show_news_outside()
{
    global $db;
    $news = $db->getAll("SELECT * FROM news ORDER BY id DESC");
    foreach ($news as $output)
    {
        echo "<div class='well-lg'>";
        echo "<h3>" . $output['subject'] . '<br /></h3>';
        echo nl2br($output['news']) . '<br /> <br />';
        echo '<font size="1">angek&uuml;ndigt von ' . $output['postedby'];
        echo "&nbsp;|&nbsp;" . date('d.m.y', $output['date']) . '<br / ></font>';
        echo '</div> <br /> <hr />';
    }
}

function show_news_inside()
{
    global $db;
    $news = $db->getAll("SELECT * FROM news ORDER BY id DESC");
    foreach ($news as $output)
    {
        echo "<div class='well'>";
        echo "<h3>" . $output['subject'] . '<br /></h3>';
        echo nl2br($output['news']) . '<br /> <br />';
        echo '<font size="1">angek&uuml;ndigt von ' . $output['postedby'];
        echo "&nbsp;|&nbsp;" . date('d.m.y', $output['date']) . '<br / ></font>';
        echo '</div> <br />';
    }
}

function show_ticket_question($ticket_id)
{
    global $db;
    $ticket = $db->getFirst("SELECT * FROM support_tickets WHERE ticket_id = ?", $ticket_id);
    echo nl2br($ticket['question']);;
}

function show_ticket_answer($ticket_id)
{
    global $db;
    $ticket = $db->getFirst("SELECT * FROM support_tickets WHERE ticket_id = ?", $ticket_id);
    echo nl2br($ticket['answer']);;

}

function show_complaint($complaint_id)
{
    global $db;
    $complaint = $db->getFirst("SELECT * FROM complaints WHERE id = ?", $complaint_id);
    echo nl2br($complaint['info']);

}

function show_leader_application($application_id)
{
    global $db;
    $application = $db->getFirst("SELECT * FROM leader_applications WHERE id = ?", $application_id);
    $application = nl2br($application['application_text']);
    echo $application;
}

function show_supporter_application($application_id)
{
    global $db;
    $application = $db->getFirst("SELECT * FROM supporter_applications WHERE id = ?", $application_id);
    $application = nl2br($application['application_text']);
    echo $application;
}

function show_faction_application($application_id)
{
    global $db;
    $application = $db->getFirst("SELECT * FROM faction_applications WHERE id = ?", $application_id);
    $application = nl2br($application['application_text']);
    echo $application;

}

function show_faction_information($faction_id)
{
    global $db;
    $information = $db->getFirst("SELECT * FROM faction_informations WHERE faction_id = ?", $faction_id);
    if (!$information)
        $db->add("faction_informations", array("faction_id" => $faction_id));
    $text = nl2br($information['text']);
    echo $text;
}

function show_faction_logo($faction_id)
{
    global $db;
    $information = $db->getFirst("SELECT * FROM faction_informations WHERE faction_id = ?", $faction_id);
    $logo = nl2br($information['image']);
    echo $logo;
}

function show_rule_informations($faction_id)
{
    global $db;
    $information = $db->getFirst("SELECT * FROM faction_informations WHERE faction_id = ?", $faction_id);
    $text = nl2br($information['text']);
    echo $text;
}

function show_rules_tab3()
{
    global $db;
    $information = getConfig();
    $text = nl2br($information['rules_tab3']);
    echo $text;
}

function redirect($target)
{
    if (!headers_sent())
    {
        header("Location: $target");
    }
    else
    {
        echo '<meta http-equiv="refresh" content="1; URL=' . $target . '">';
    }
    die();
}

include_once("include/bauer_db.php");
$config = getConfig();
$db = new BauerDB($config["mysql_host"], $config["mysql_database"], $config["mysql_user"], $config["mysql_password"]);

register_shutdown_function("shutdown");
date_default_timezone_set("Europe/Berlin");

function shutdown()
{
    global $debug;
    $error = error_get_last();
    if ($error != null && isset($debug))
    {
        echo "<div style='z-index:1001;visibility:visible;left:0px;white-space: pre-wrap;position:absolute;width:100%;top:20%;background:black;color:white;padding-bottom:100px'><h1>Fehler</h1><code>";
        echo "{$error['message']} in  {$error['file']} on line {$error['line']}\n\nStack Trace:\n";
        debug_print_backtrace();
        echo "</code></div>";
    }
    else
    {
        if ($error != null && $error["type"] == E_ERROR)
        {
            echo "<h1>Ein Fehler ist aufgetreten!</h1>";
            echo "Bei der Ausführung des Skriptes ist leider ein Fehler aufgetreten. ";
            echo "Sollte dieser Fehler anhalten, setzen Sie sich bitte mit dem myCP2-Support in Verbindung. ";
        }
    }
}

define("ICON_OK", '<span class="glyphicon glyphicon-ok text-primary"> </span>');
define("ICON_NO", '<span class="glyphicon glyphicon-remove text-danger"> </span>');

function require_login()
{
    if (!isset($_SESSION["id"]))
    {
        redirect("index.php");
    }
}

function require_admin()
{
    require_login();
    $action = sizeof($_POST) ? "edit" : "show";
    require_permission($action);
    if (!check_permission("dashboard", "show")) {
        echo "<h1>Fehler: Kein Zugriff!";
        die();
    }
}

function check_permission($target, $action) {
    global $db;
    $permissions = $db->getAll("SELECT p.grant, g.name FROM mycp_permissions p JOIN mycp_adminranks g ON g.id = p.id JOIN !accounts ON (g.id = !accounts.!adminrights) WHERE !accounts.!id = ? AND p.permission_target = ? AND p.permission_type = ? AND p.is_admin_rank = 1", $_SESSION["id"], $target, $action);
    $permissions = array_merge($permissions, $db->getAll("SELECT p.grant, g.name FROM mycp_permissions p JOIN mycp_groups g ON g.id = p.id JOIN mycp_users_to_groups ug ON ug.group = g.id WHERE ug.user = ? AND p.permission_target = ? AND p.permission_type = ? AND p.is_admin_rank = 0", $_SESSION["id"], $target, $action));
    $grant = $forbidden = 0;
    foreach ($permissions as $permission) {
        $grant = $permission["grant"];
        if ($grant == 0)
            $forbidden = true;
    }
    return (!(!$grant || $forbidden));
}

function require_permission($action) {
    global $db, $currentPage;
    if (!isset($currentPage))
        $currentPage = trim($_SERVER['PHP_SELF'],"/");
    $target = explode(".", $currentPage);
    $target = $target[0];
    if (strpos($target, "/") !== 0) {
        $target = explode("/", $target);
        $target = $target[sizeof($target) - 1];
    }

    if (strpos($target, "action") === 0)
        $action = "execute";

    $permissions = $db->getAll("SELECT p.grant, g.name FROM mycp_permissions p JOIN mycp_adminranks g ON g.id = p.id JOIN !accounts ON (g.id = !accounts.!adminrights) WHERE !accounts.!id = ? AND p.permission_target = ? AND p.permission_type = ? AND p.is_admin_rank = 1", $_SESSION["id"], $target, $action);
    $permissions = array_merge($permissions, $db->getAll("SELECT p.grant, g.name FROM mycp_permissions p JOIN mycp_groups g ON g.id = p.id JOIN mycp_users_to_groups ug ON ug.group = g.id WHERE ug.user = ? AND p.permission_target = ? AND p.permission_type = ? AND p.is_admin_rank = 0", $_SESSION["id"], $target, $action));
    $text = array();
    $grant = $forbidden = 0;
    foreach ($permissions as $permission) {
        $description = "Ihre Mitgliedschaft in der Gruppe ". $permission["name"] . " ";
        $description .= ($permission["grant"] == 1) ? "erlaubt Ihnen" : "verbietet Ihnen explizit";
        $description .= " diese Aktion auszuführen.";
        $text[] = $description;
        $grant = $permission["grant"];
        if ($grant == 0)
            $forbidden = true;
    }
    if (!$grant || $forbidden) {
        include_once("templates/header_acp.php");
        echo "<h2>Aktion gesperrt</h2>";
        echo "Die Ausführung der aktuellen Aktion wurde gesperrt, da Sie nicht berechtigt sind, sie auszuführen.<br>";
        if (!sizeof($text)) {
            echo "Sie sind in keiner Gruppe Mitglied, die Zugriff auf diese Aktion besitzt.";
        }
        else {
            echo "Folgende Gruppeneinstellungen haben zu dieser Einstufung geführt:<ul>";
            foreach ($text as $t) {
                echo "<li>$t</li>";
            }
            echo "</ul>";
        }
        include_once("templates/footer_acp.php");
        die();
    }
}

function user_log($action, $comment = null)
{
    global $db;
    $entry = array();
    $entry["action"] = $action;
    $entry["user"] = isset($_SESSION["id"]) ? $_SESSION["id"] : 0;
    $entry["ip"] = $_SERVER['REMOTE_ADDR'];
    if ($comment !== NULL)
    {
        $entry["extra"] = $comment;
    }
    $db->add("user_log", $entry);
}

$need = array(
    "data_skin" => "Skin-Nummer",
    "data_date_of_registration" => "Registrierungsdatum",
    "data_level" => "Level",
    "data_age" => "Alter",
    "data_sex" => "Geschlecht",
    "data_wanteds" => "Wanteds",
    "data_passport" => "Ausweis",
    "data_car_license" => "Autoführerschein",
    "data_plane_license" => "Flugschein",
    "data_boat_license" => "Bootsführerschein",
    "data_LKW_license" => "LKW-Führerschein",
    "data_bike_license" => "Motorradschein",
    "data_weapon_license" => "Waffenschein",
    "data_faction" => "Fraktion",
    "data_rank" => "Fraktionsrang",
    "data_job" => "Job",
    "data_respect" => "Respektpunkte",
    "data_bankaccount" => "Bankkonto",
    "data_bankmoney" => "Kontoguthaben",
    "data_cashmoney" => "Bargeld",
    "data_house" => "Haus",
    "data_business" => "Business",
    "data_donatorrank" => "Donator",
    "data_carslots" => "Carslots",
    "data_coins" => "Coins",
    "data_lastlogin" => "letzter Login",
    "data_email" => "E-Mail",
    "data_baned" => "Bannstatus",
    "data_leader" => "Leader",
    "data_id" => "ID",
    "data_username" => "Benutzername",
    "data_password" => "Passwort",
    "data_adminrights" => "Admin",
);

$updateserver = "http://downloadarena.bauerj.eu/";
$version = "2.4.3";
/**
 * @param string $message Nachricht die ausgegeben werden soll
 * @param string $level {danger, warning, info, success}
 */
function showMessage($message, $level = "warning")
{
    switch ($level)
    {
        case "error":
            $level = "danger";
        case "danger":
            $description = "Fehler:";
            break;
        case "warning":
            $description = "Achtung!";
            break;
        case "info":
            $description = "Bitte beachten:";
            break;
        case "success":
        default:
            $description = "Alles klar!";
            break;

    }
    echo "<div class='alert alert-$level fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>";
    echo "<strong>$description</strong> $message";
    echo "</div>";
}

function newConversationID()
{
    global $db;
    $next = $db->getFirst("SELECT MIN(t1.conversation + 1) AS nextID
    FROM conversations t1
      LEFT JOIN conversations t2
           ON t1.conversation + 1 = t2.conversation
    WHERE t2.conversation IS NULL");
    return (int)$next["nextID"];
}

function filterInput($input, $whitelist)
{
    return array_intersect_key($input, array_flip($whitelist));
}

function TeamspeakRemoveUserFromGroup($UUID, $groupID)
{
    require_once('TS3_Framework/libraries/TeamSpeak3/TeamSpeak3.php');
    $server = getConfig();

    try
    {
        TeamSpeak3::init();
        $ts3_VirtualServer = TeamSpeak3::factory("serverquery://" . $server["ts_query_admin"] . ":" . $server["ts_query_password"] . "@" . $server["tsip"] . ":" . $server["ts_query_port"] . "/?server_port=" . $server["tsport"] . "&nickname=" . $server["ts_query_user_nick"] . "");

        $client = $ts3_VirtualServer->clientFindDb($UUID, true);
        if ($ts3_VirtualServer->serverGroupClientDel($groupID, $client[0]))
        {
            echo "";
        }

    } catch (Exception $e)
    {
        echo "Es ist ein Fehler aufgetreten!<br/>Fehler-Code: " . $e->getCode() . "</b> Beschreibung: <b>" . $e->getMessage() . "</b>";
    }
}

function checkCronjobKey() {
    if (($key = getConfig("cronjob_key")) != null) {
        if (isset($_GET["cronjob_key"]) && $_GET["cronjob_key"] == $key)
            return;
        echo "<h1>Zugriff verweigert</h1>Um den Cronjob auszulösen, muss der <pre>cronjob_key</pre> angegeben werden.";
        die();
    }
    if ($key === false)
        die("Cronjobs sind deaktiviert");
    echo "<h1>Potenzielle Sicherheitsl&uuml;cke!</h1>Im Dashboard wurde kein <pre>cronjob_key</pre> hinterlegt. Der Cronjob kann daher von jedem
    gestartet werden! Das kann m&ouml;glicherweise dazu verwendet werden, um den Webserver, oder den Datenbankserver zu &uuml;berlasten.";
}

function generateRandomString($length)
{
    $key = "";
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }
    return $key;
}

function printNavigationLink($target, $name, $icon = "glyphicon-inbox", $count = false) {
    global $currentPage;
    $page = explode(".", $target);
    $page = $page[0];
    $active = ($currentPage == $target) ? "class='active'" : "";
    $disabled = (!check_permission($page, "show"))?"class=\"disabled\"":"";
    $count = ($count !== false) ? "<span class=\"label label-default\">$count</span>" : "";
    echo "<li $active $disabled><a href=\"$target\"><span class=\"glyphicon $icon\"></span> $name $count</a></li>";
}
