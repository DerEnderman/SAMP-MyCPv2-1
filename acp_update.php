<?php
$currentPage = "acp_update.php";
include_once("global.php");

require_admin();
$title = "myCP Updates";
include_once("templates/header_acp.php");

if (sizeof($_POST)) {
    $license = $_POST["license"];
    file_put_contents("mycp2.tar.gz", fopen("http://downloadarena.bauerj.eu/download.php?license=$license", 'r'));
    foreach ($http_response_header as $header) {
        if (strpos($header, "X-Error:") === 0) {
            $error = explode(":",$header);
            $error = $error[1];
        }
    }
    if (!isset($error)) {
        try {
            $p = new PharData("mycp2.tar.gz");
            $p->decompress();

            $phar = new PharData("mycp2.tar");
            $phar->extractTo('.', null, true);
        } catch (Exception $e) {
            showMessage($e);
        }
        unset($phar);
        @unlink('mycp2.tar.gz');@unlink('mycp2.tar');
        if (file_exists("installer"))
            redirect("installer/");
        else showMessage("Die Installation kann nicht durchgeführt werden. Der Download ist fehlgeschlagen.");
        die();
    }
    else {
        showMessage($error);
    }

}


$config = getConfig();
saveConfig(array("last_updatecheck" => time()));
flush();
$response = @file_get_contents($updateserver . "/versions/?version=" . $version);
$response = json_decode($response);
if ($response->code == "UPGRADE_SUGGESTED")
{
    $config["update_available"] = "Es ist ein Update auf " . $response->version . " verfügbar.\n<br>";
    $config["update_available"] .= "Folgende Änderungen sind in der Version enthalten: \n";
    $config["update_available"] .= nl2br($response->changes);
}
elseif ($response->code == "NO_UPDATE")
{
    $config["update_available"] = "myCP ist auf der allerneuesten Version $version.";
}
else
{
    $config["update_available"] = "Es konnte keine Verbindung zum Updateserver hergestellt werden.";
}
saveConfig(array("update_available" => $config["update_available"]));

?>


<?= $config["update_available"] ?>
<form method="POST">
    <div class="form-group">
        <label >myCP 2 Lizenzschlüssel</label>
        <input type="text" name="license" class="form-control"  placeholder="1234-1234-1234-1234">
    </div>
    <button class="btn btn-warning">Update durchführen</button>
</form><hr>
<?php showMessage("Sollte das Update nicht funktionieren, laden Sie im Downloadbereich die aktuellste Version herunter
und überschreiben Sie die Daten von myCP mit denen der aktuellsten Version.","info");?>

<?php include_once("templates/footer_acp.php");