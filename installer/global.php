<?php

function getConfig() {
    global $_CONFIG;
    if (!isset($_CONFIG)) {
        if (file_exists(BASEDIR."/../config.php"))
            include_once(BASEDIR."/../config.php");
        else
            return array();
    }
    if (!isset($_CONFIG) ||$_CONFIG === null)
        return array();
    return $_CONFIG;
}

function saveConfig($data) {
    $old = getConfig();
    $new = array_merge($old, $data);
    $content = "<?php\n";
    $content .= '//Stand: '.date("r")."\n";
    $content .= '$_CONFIG = ';
    $content .= var_export($new, true);
    $content .= ";\n\n";
    $content .= $new["hashFunction"];
    file_put_contents(BASEDIR."/../config.php", $content);
}

$need = array(
    "data_skin" => "Skin-Nummer",
    "data_date_of_registration" => "Registrierungsdatum",
    "data_level" => "Level",
    "data_age" => "Alter",
    "data_sex" => "Geschlecht",
    "data_wanteds" => "Wanteds",
    "data_car_license" => "Autoführerschein",
    "data_plane_license" => "Flugschein",
    "data_boat_license" => "Bootsführerschein",
    "data_bike_license" => "Motorradschein",
    "data_weapon_license" => "Waffenschein",
    "data_faction" => "Fraktion",
    "data_rank" => "Fraktionsrang",
    "data_job" => "Job",
    "data_respect" => "Respektpunkte",
    "data_bankmoney" => "Kontoguthaben",
    "data_cashmoney" => "Bargeld",
    "data_lastlogin" => "letzter Login",
    "data_email" => "E-Mail",
    "data_banned" => "Bannstatus",
    "data_leader" => "Leader",
    "data_id" => "ID",
    "data_username" => "Benutzername",
    "data_password" => "Passwort",
    "data_adminrights" => "Ingame-Adminrang",
    "data_ucp_adminrights" => "Dashboard-Zugang (0/1)",
);

$optional = array(
    "data_donatorrank" => "Donator",
    "data_coins" => "Coins",
    "data_house" => "Haus",
    "data_business" => "Business",
    "data_passport" => "Ausweis",
    "data_LKW_license" => "LKW-Führerschein",
);