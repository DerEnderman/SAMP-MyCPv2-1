<?php
$currentPage = "acp_log.php";
include("global.php");

require_admin();
$title = "Protokolle";
include_once("templates/header_acp.php");
define("ITEMS_PER_PAGE", 50);

$page = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;
if ($page < 1)
{
    $page = 1;
}
$first = ($page - 1) * ITEMS_PER_PAGE;
$last = $first + ITEMS_PER_PAGE - 1;

$allowed = array("username", "ip", "action");
$sql = "SELECT !username as username, `time`, `action`, l.ip, extra FROM user_log l JOIN !accounts a ON a.!id = l.user";
$countsql = "SELECT COUNT(*) as count FROM user_log l JOIN !accounts a ON a.!id = l.user ";
$where = false;
$currentUrl = "acp_log.php?";
$filter = array();
foreach ($_GET as $key => $value)
{
    $currentUrl .= "$key=$value&";
    if (in_array($key, $allowed))
    {
        $filter[$key] = $value;
        if (!$where)
        {
            $where = true;
            $sql .= " WHERE ";
            $countsql .= " WHERE ";
        }
        else
        {
            $sql .= " AND ";
            $countsql .= " AND ";
        }
        if ($key == "username")
        {
            $sql .= "!username = :username";
            $countsql .= "!username = :username";
        }
        else
        {
            $sql .= "$key  = :$key";
            $countsql .= "$key  = :$key";
        }
    }
}

$sql .= " ORDER BY `time` DESC LIMIT $first,$last";
$log = $db->getAll($sql, $filter);
$count = $db->getFirst($countsql, $filter);
$pages = ceil($count["count"] / ITEMS_PER_PAGE)+1;
if (sizeof($filter))
{
    ?>
    <div align="right">
        <button onclick="document.location='acp_log.php'" type="button" class="btn btn-primary" data-toggle="modal"
                data-target=".bs-example-modal-lg">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Filter entfernen
        </button>
    </div>
<?php
}
?>

    <h2>Filter:</h2>
    <form class="form-inline" role="form">
        <div class="form-group">
            <div class="input-group">
                <label for="username">Benutzername</label>
                <input name="username" type="text" class="form-control" id="username"
                       placeholder="Nach Benutzer filtern">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label for="username">IP-Adresse</label>
                <input name="ip" type="text" class="form-control" id="username" placeholder="Nach IP filtern">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <label for="username">Aktion</label>
                <input name="action" type="text" class="form-control" id="username" placeholder="Nach Aktion filtern">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <button style="padding:13px;margin-bottom:0;margin-left:15px;" type="submit" class="btn btn-primary">
                    Filtern
                </button>
            </div>
        </div>

    </form>
    <hr>
<?php
if (!sizeof($log))
{
    echo "<i class='glyphicon glyphicon-warning-sign'></i> Die Logs sind leer.";
}
else
{
    ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Datum</th>
            <th>Benutzer</th>
            <th>Aktion</th>
            <th>Information</th>
            <th>IP-Adresse</th>
        </tr>
        </thead>
        <tbody> <?php
        foreach ($log as $item)
        {
            ?>
            <tr>
                <td><?= date("d.m.Y - H:i", strtotime($item["time"])) ?></td>
                <td><a href="<?= $currentUrl ?>username=<?= $item["username"] ?>"><?= $item["username"] ?></a></td>
                <td><a href="<?= $currentUrl ?>action=<?= $item["action"] ?>"><?= $item["action"] ?></a></td>
                <td><?= $item["extra"] ?></td>
                <td><a href="<?= $currentUrl ?>ip=<?= $item["ip"] ?>"><?= $item["ip"] ?></a></td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <?php
    if ($pages > 1)
    {
        ?>
        <nav>
            <ul class="pagination pagination">
                <li class="<?= ($page - 1 < 1) ? "disabled" : "" ?>"><a
                        href="acp_log.php?page=<?= $page - 1 ?>"><span
                            aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                <?php
                for ($i = 1; $i < $pages; $i++)
                {
                    $active = ($i == $page) ? "active" : "";
                    echo '<li class="' . $active . '"><a href="'.$currentUrl.'page=' . $i . '">' . $i . '</a></li>';
                } ?>
                <li class="<?= ($page + 1 >= $pages) ? "disabled" : "" ?>"><a
                        href="<?= $currentUrl ?>page=<?= $page + 1 ?>"><span
                            aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
            </ul>
        </nav>
    <?php
    }
}
include_once("templates/footer_acp.php");