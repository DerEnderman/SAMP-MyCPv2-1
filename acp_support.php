<?php
$currentPage = "acp_support.php";
include("global.php");

require_admin();
$title = "Supportbereich";
include_once("templates/header_acp.php");
$query = "SELECT *, !username FROM support_tickets s JOIN !accounts a ON a.id = s.creator";
$vars = array();
if (!isset($_GET["status"]))
    $_GET["status"] = "Unbeantwortet";
if (sizeof($_GET)) {
    $query .= " WHERE ";
    if (!empty($_GET["status"]) && $_GET["status"] != "Egal") {
        $query .= " status = :status AND ";
        switch ($_GET["status"]) {
            default:
            case "Unbeantwortet":
                $vars["status"] = 0;
                break;
            case "Beantwortet":
                $vars["status"] = 1;
                break;
            case "Geschlossen":
                $vars["status"] = 2;
                break;
        }
    }
    if (isset($_GET["creator"]) && !empty($_GET["creator"])) {
        $query .= " !username = :creator AND ";
        $vars["creator"] = $_GET["creator"];
    }
    if (isset($_GET["topic"]) && !empty($_GET["topic"])) {
        $query .= " topic LIKE :topic AND ";
        $vars["topic"] = "%".$_GET["topic"]."%";
    }
    $query = rtrim($query, "AND ");
    $query = rtrim($query, "WHERE ");
}
$supports = $db->getAll($query, $vars);
?>
<style type="text/css">
        tr[onclick]:hover {
            cursor: pointer;
        }
    .filter span {
        float:left;
        font-size: 25px;
        font-weight: bold;
    }
    .filter span, .filter div.form-group {
        border-right: 1px solid black;
        padding:5px;
    }
    .filter {
        border: 1px solid black;
        border-radius: 5px;
        background: #f9f9f9;
    }
</style>
    <div class="filter">
    <form class="form-inline" role="form">
        <div class="form-group">
            <div class="input-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" id="status">
                    <option <?php if(isset($_GET["status"]) && $_GET["status"]=="Egal") echo "selected"?>>Egal</option>
                    <option <?php if(isset($_GET["status"]) && $_GET["status"]=="Unbeantwortet") echo "selected"?>>Unbeantwortet</option>
                    <option <?php if(isset($_GET["status"]) && $_GET["status"]=="Beantwortet") echo "selected"?>>Beantwortet</option>
                    <option <?php if(isset($_GET["status"]) && $_GET["status"]=="Geschlossen") echo "selected"?>>Geschlossen</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label for="username">Ersteller</label>
                <input name="creator" type="text" class="form-control" id="username" placeholder="Benutzername" <?php if (isset($_GET["creator"])) echo "value='".$_GET["creator"]."'"?>>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label for="username">Thema</label>
                <input name="topic" type="text" class="form-control" id="username" placeholder="Thema enthält" <?php if (isset($_GET["topic"])) echo "value='".$_GET["topic"]."'"?>>
            </div>
        </div>

            <div class="input-group">
                <button style="padding:13px;margin-bottom:0;margin-left:15px;" type="submit" class="btn btn-primary">
                    Filtern
                </button>

        </div></form></div>

    <hr>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="list_tickets"><br/>
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <th>#</th>
                    <th>Thema</th>
                    <th>Status</th>
                    <th>Erstellt</th>
                </tr>
                <?php
                foreach ($supports as $support) {
                    switch ($support["status"]) {
                        case 0:
                            $status = "Warte auf Antwort";
                            break;
                        case 1:
                            $status = "Neue Antwort";
                            break;
                        case 2:
                            $status = "Geschlossen";
                            break;
                    }

                    ?>
                    <tr onclick="document.location='adminticket.php?id=<?= $support["ticket_id"]?>'">
                        <td><?= $support["ticket_id"] ?></td>
                        <td><?= $support["topic"]?></td>
                        <td><?= $status ?></td>
                        <td>am <?= date("d.m.Y - H:i", strtotime($support["date_of_creation"])) ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

    </div>

    </div><?php include_once("templates/footer_acp.php");