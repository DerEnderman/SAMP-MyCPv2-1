<?php
include("global.php");
if (isset($_POST["cronjob_key"])) {
    saveConfig(array("cronjob_key" => generateRandomString(12)));
}
// Einige der Queries könnten recht lange dauern, weshalb sie asynchron berechnet werden
if (isset($_GET["json"])) {
    switch($_GET["for"]) {
        case "playercount":
            //Wir brauchen auf keinen Fall mehr als 900 Einträge, denn so viele Pixel haben wir gar nicht
            $count = $db->getFirst("SELECT count(*) as count FROM server_monitor");
            $count = $count["count"];
            $ratio = $count / 900;
            $value = $db->getAll("SELECT date, player_online FROM server_monitor");
            if ($ratio > 1) {
                $ratio = floor($ratio);
                $result = array();
                $i = 0;
                // Jedes $ratio-te Element soll ausgegeben werden
                // Man glaubt es kaum, aber das geht schneller, als MySQL mitzählen zu lassen
                foreach($value as $element) {
                    if ($i++ % $ratio == 0) {
                        $result[] = $element;
                    }
                }
                $value = $result;
            }
            break;
        case "uptime":
            $value = $db->getFirst("SELECT SUM(online) as online, COUNT(*) as total FROM server_monitor");
            break;
        case "dayofweek":
            $value = $db->getFirst("SELECT DAYOFWEEK(date) as dayofweek FROM server_monitor GROUP BY DAYOFWEEK(date) ORDER BY AVG(player_online) DESC LIMIT 1");
            break;
        case "hour":
            $value = $db->getFirst("SELECT HOUR(date) AS hour, MINUTE(date) AS minute FROM server_monitor GROUP BY HOUR(date), MINUTE(date) ORDER BY AVG(player_online) DESC LIMIT 1");
            break;
        case "record":
            $value = $db->getFirst("SELECT date, player_online FROM server_monitor WHERE online=1 ORDER BY player_online DESC LIMIT 1");
            break;
    }
    echo json_encode($value);
    die();
}
$firstRows = $db->getAll("SELECT MINUTE(date) AS minute, date FROM server_monitor ORDER BY date DESC LIMIT 2");
$hasData = is_array($firstRows);
$duration = 15;
if (sizeof($firstRows) == 2) {
    if ($firstRows[0]["minute"] > $firstRows[1]["minute"])
        $firstRows[1]["minute"] -= 60;
    $duration = $firstRows[0]["minute"] - $firstRows[1]["minute"];
    $lastRun = strtotime($firstRows[0]["date"]) * 1000;
    $duration = $duration % 60;
}

$currentPage = "acp_server_monitor.php";
require_admin();
$title = "Server-Monitor";
include_once("templates/header_acp.php");
if (getConfig("cronjob_key") !== false && $hasData) {
?>
    <div class="pull-right"><input type="checkbox" id="autoRefresh" onchange="setRefresh(this.checked)"> Neue Daten
        holen in <span id="duration"></span></div>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<h2>Spieleranzahl</h2>
<div id="playercount" style="height: 250px;">
    <h3>Einen Moment bitte...</h3>
    <div class="progress progress-striped active" style="height:50px">
        <div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
        </div>
    </div>
</div>
<br>
<div class="row serverinfo">
    <div class="col-lg-3 col-md-6" id="uptime"><div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bolt fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h3> </h3>
                     </div>
                </div>
            </div>
                <div class="panel-footer">
                    <span class="pull-left"><b>Uptime (gesamt)</b></span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6" id="dayofweek"><div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-calendar fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h3><small>am</small> </h3>
                     </div>
                </div>
            </div>
                <div class="panel-footer">
                    <span class="pull-left"><b>sind durchschnittlich am Meisten Spieler online</b></span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6" id="hour"><div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-clock-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h3></h3>
                     </div>
                </div>
            </div>
                <div class="panel-footer">
                    <span class="pull-left"><b>sind durchschnittlich am Meisten Spieler online</b></span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6" id="record"><div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-trophy fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <h3></h3>
                     </div>
                </div>
            </div>
                <div class="panel-footer">
                    <span class="pull-left"><b>War der Spielerrekord am <span id="record-date"></span></b></span>
                    <div class="clearfix"></div>
                </div>
        </div>
    </div>
</div>
<script>
    function dayOfWeekAsString(dayIndex) {
        return ["Sonntag", "Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag"][dayIndex-1];
    }
    function refreshEnabled() {
        return localStorage.getItem("refresh") !== "false";
    }
    function setRefresh(x) {
        localStorage.setItem("refresh", x);
    }
    function tick() {
        var remaining = refreshAt - Date.now();
        remaining /= 1000;
        remaining = Math.round(remaining);
        if (remaining < 1) {
            refreshAt = Date.now() + (duration * 60 * 1000) + 1500;
            if (refreshEnabled())
                getData();
        }
        if (remaining < 61) {
            $("#duration").html(remaining + " Sekunden");
        }
        else {
            remaining /= 60;
            remaining = Math.round(remaining);
            $("#duration").html(remaining + " Minuten");
        }
    }
    function getData() {
        $.getJSON(window.location + "?json&for=uptime", function (json) { // callback function which gets called when your request completes.
            var uptime = json.online / json.total;
            uptime *= 100;
            uptime = uptime.toFixed(2);;
            uptime = uptime + "%";
            $("#uptime").show(450);
            $("#uptime h3").html(uptime);
        });
        $.getJSON(window.location + "?json&for=dayofweek", function (json) { // callback function which gets called when your request completes.
            $("#dayofweek").show(250);
            $("#dayofweek h3").html("<small>am</small> "+dayOfWeekAsString(json.dayofweek));
        });
        $.getJSON(window.location + "?json&for=hour", function (json) { // callback function which gets called when your request completes.

            $("#hour").show(250);
            $("#hour h3").html("<small>ca.</small> " + json.hour + ":" + json.minute);
        });
        $.getJSON(window.location + "?json&for=record", function (json) { // callback function which gets called when your request completes.
            var d = new Date(json.date), date = "";
            date = d.getDate() + ".";
            date += d.getMonth()+1 +".";
            date += d.getFullYear()+"";
            $("#record").show(250);
            $("#record h3").html(json.player_online);
            $("#record #record-date").html(date);
        });
        $.getJSON(window.location + "?json&for=playercount", function (json) { // callback function which gets called when your request completes.
            $("#playercount").html("");
            Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'playercount',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: json,
                // The name of the data record attribute that contains x-values.
                xkey: 'date',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['player_online'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Spieler online'],
                hideHover : true,
                pointSize : 0
            });
        });
    }
    duration = <?= $duration ?>;
    interval = refreshAt = 0;
    <?php if (!isset($lastRun)) { ?>
    refreshAt = Date.now() + (duration * 60 * 1000);
    <?php } else { ?>
    refreshAt = <?= $lastRun ?>;
    var i = 0;
    while (refreshAt < Date.now()) {
        refreshAt += (duration * 60 * 1000) + 1000;
        i++;
        if (i > 5) {
            refreshAt = Date.now() + (duration * 60 * 1000) + 1500;
            break;
        }
    }
    if (refreshAt < Date.now())
        refreshAt = Date.now() + (duration * 60 * 1000) + 1500;
    <?php } ?>
    interval = window.setInterval(tick, 1000);
    $("#autoRefresh")[0].checked = refreshEnabled();
    tick();
    getData();
</script>
<style>
    .serverinfo h3, .serverinfo small {
        color:#ffffff;
    }
    #dayofweek, #hour, #record, #uptime{
        display:none;
    }
</style>
<?php
} elseif (($key = getConfig("cronjob_key")) !== false && !$hasData) {

    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url = str_replace("acp_server_monitor.php", "cronjobs/server_monitor.php?cronjob_key=$key", $url);
    ?>
    Um die Daten periodisch vom Server abzufragen, muss ein sogenannter Cronjob aktiviert werden.
    Die Cronjobs wurden mit dem Schlüssel <kbd><?= $key ?></kbd> freigeschaltet. Bitte rufe
    <a href="<?= $url ?>"><?= $url ?></a> auf, um zu überprüfen, dass keine Fehler angezeigt werden.<br>
    <h3>Einrichtung des Cronjobs</h3>
    Der Cronjob sollte alle 5 - 15 Minuten <i><?= $url ?></i> aufrufen. Wir empfehlen 10 Minuten als Intervall.
    <h4>Methode 1: Dein Server</h4>
    Falls du bereits weißt, wie du einen Cronjob einrichtest, solltest du es auf dem Server einrichten, auf dem auch das CP läuft.
    <br>
    Die entsprechende Zeile im Crontab könnte so lauten:<br>
    <pre><code>*/10 * * * * wget <?= $url ?> -O /dev/null > /dev/null 2>&1</code></pre>
    <h4>Methode 2: Online-Dienst</h4>
    Falls dir das alles nichts sagt, kannst du einen kostenlosen Online-Dienst dafür verwenden, etwa <a
        href="https://cron-job.org/de/">cron-job.org</a>.
    Dort zum Beispiel "alle 5 Minuten" oder "alle 10 Minuten" einstellen.
<?php } else { ?>
    Der Server-Monitor ist aktuell nicht aktiviert.<br>
    Im Server-Monitor hast du deinen SAMP-Server immer genau im Blick. Die Einrichtung dauert nur ein paar Minuten.
    Wenn du ihn aktivieren willst, klicke
    <form method="POST">
        <button name="cronjob_key" class="btn">hier</button>
        .
    </form>
<?php }

include_once("templates/footer_acp.php");