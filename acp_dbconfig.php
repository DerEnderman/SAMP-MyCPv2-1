<?php
$currentPage = "acp_dbconfig.php";
include("global.php");
require_admin();



$config = getConfig();

$tables = $db->getAll("select TABLE_NAME from information_schema.tables WHERE TABLE_SCHEMA = ?", $config["mysql_database"]);
$columns = $db->getAll("select COLUMN_NAME from information_schema.columns WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?", $config["mysql_database"], $config["data_accounts"]);

$title = "Datenbankkonfiguration";
include_once("templates/header_acp.php");


if (sizeof($_POST))
{
    foreach ($_POST as $key => $value) {
        if (strpos($key, "data_") !== FALSE)
            $config[$key] = $value;
    }
    saveConfig($config);
    showMessage('Die Einstellungen wurden erfolgreich aktualisiert.', 'success'); 
}
?>
<style>
    form#dbconfig .form-group {
        font-size: 15px;
        padding:40px;
    }
    .form-group label {
        padding-top:5px;
        text-align: right;
    }
</style>
    <p>Die Datenbank Konfiguration ist die Basis f&uuml;r
        die Dynamik deines User Control Panels.</p>
    <p>Hier hast du die M&ouml;glichkeit, detailierte Angaben zu deiner Datenbank zu machen. <br>
        Beachte, dass du die Datenbank Konfiguration nur ausfüllen solltest, wenn du dich bereits problemlos in dein System
        einloggen kannst.
        <br>In den meisten F&auml;llen, sollte man so ohne gro&szlig;en Aufwand seine MySQL-Datenbank problemlos in das UCP einbinden können.<br><br>
        <b>Außerdem:</b> Sollte der <a href="acp_teamspeak.php">TeamSpeak-Controller</a> aktiviert sein, werden
        automatisch zwei weitere Spalten <kbd>'verified'</kbd> sowie <kbd>'TS_UID'</kbd> hinzugef&uuml;gt.
        <br>
    </p>
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Achtung:</span> Da das Login offensichtlich funktioniert hat, gibt es keinen Grund.
        diesen Wert zu verändern. Solltest du hier eine falsche Einstellung treffen, funktioniert myCP eventuell nicht mehr wie erwartet.
    </div>
    <form role="form" method="post" id="dbconfig">
        <div class="form-group">
            <label for="selectAccounts" class="col-sm-2 control-label">Benutzertabelle</label>
            <div class="col-sm-10">
                <select name="data_accounts" class="form-control">
                    <?php foreach ($tables as $table) { ?>
                    <option><?= $table["TABLE_NAME"]?></option>
                        <?php } ?>
                </select>
            </div>
        </div>
        <?php foreach ($need as $item => $description){?>
            <div class="form-group">
                <label for="select<?= $item ?>" class="col-sm-2 control-label"><?= $description?></label>
                <div class="col-sm-10">
                    <select name="<?= $item ?>" lass="form-control">
                        <option></option>
                        <?php foreach ($columns as $column) { ?>
                        <option <?php if ($config[$item] == $column["COLUMN_NAME"]) echo "selected"?>><?= $column["COLUMN_NAME"]?></option>
                            <?php } ?>
                    </select>
                </div>
            </div>

        <?php } ?>
        <button type="submit" class="btn btn-success">Speichern</button>
    </form>
<?php include_once("templates/footer_acp.php");