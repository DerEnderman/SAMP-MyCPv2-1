<?php
$currentPage = "acp_permissions.php";
include("global.php");
require_admin();
$title = "Berechtigungen";
include_once("templates/header_acp.php");
if (isset($_POST["create"])) {
    if (isset($_POST["admin"]) && $_POST["admin"])
        $success = $db->add("mycp_adminranks", array("id" => (int) $_POST["id"], "name" => $_POST["name"]));
    else
        $success = $db->add("mycp_groups", array("name" => $_POST["name"]));
    if ($success)
        showMessage("Erfolgreich erstellt", "success");
    else
        showMessage("Es gab einen Fehler beim Erstellen");
}
if (isset($_POST["edit_permissions"]) && isset($_GET["group"])) {
    $db->query("DELETE FROM mycp_permissions WHERE id = ? AND is_admin_rank = ?", $_GET["group"], (isset($_GET["admin"]) && $_GET["admin"])? 1 : 0);
    showMessage("Die neuen Berechtigungen wurden übernommen", "success");
}
if (isset($_POST["grant"]) && isset($_GET["group"])) {
    foreach ($_POST["grant"] as $target => $permissions) {
        foreach ($permissions as $permission => $grant)
            $db->query("INSERT INTO mycp_permissions (id, is_admin_rank, permission_target, permission_type, `grant`) VALUES (?, ?, ?, ?, ?)", $_GET["group"], (isset($_GET["admin"]) && $_GET["admin"])? 1 : 0, $target, $permission, 1);
    }
}
if (isset($_POST["deny"]) && isset($_GET["group"])) {
    foreach ($_POST["deny"] as $target => $permissions) {
        foreach ($permissions as $permission => $grant)
            $db->query("INSERT INTO mycp_permissions (id, is_admin_rank, permission_target, permission_type, `grant`) VALUES (?, ?, ?, ?, ?)", $_GET["group"], (isset($_GET["admin"]) && $_GET["admin"])? 1 : 0, $target, $permission, 0);
    }
}
if (isset($_POST["add-user"]) && isset($_GET["group"])) {
    if ($db->query("INSERT INTO mycp_users_to_groups (`user`, `group`) VALUES ((SELECT !id FROM !accounts WHERE !username = ?), ?)", $_POST["username"], $_GET["group"]))
        showMessage("Benutzer erfolgreich hinzugefügt", "success");
    else
        showMessage("Dieser Benutzer existiert nicht");
}
if (isset($_POST["delete-user"]) && isset($_GET["group"])) {
    if ($db->query("DELETE FROM mycp_users_to_groups WHERE `user` = ? AND `group` = ? ", $_POST["user"], $_GET["group"]))
        showMessage("Benutzer erfolgreich entfernt", "success");
    else
        showMessage("Dieser Benutzer existiert nicht");
}
if (isset($_POST["delete-group"]) && isset($_GET["group"]) && isset($_GET["admin"])) {
    if (isset($_GET["admin"]) && $_GET["admin"])
        $success = $db->query("DELETE FROM mycp_adminranks WHERE id = ?", $_GET["group"]);
    else
        $success = $db->query("DELETE FROM mycp_groups WHERE id = ?", $_GET["group"]) + $db->query("DELETE FROM mycp_users_to_groups WHERE `group` = ?", $_GET["group"]);
    if ($success)
        showMessage("Erfolgreich gelöscht", "success");
    else
        showMessage("Es gab einen Fehler beim Löschen");
}
if (isset($_GET["group"]) && isset($_GET["permissions"])) {
    $permissions = $db->getAll("SELECT CONCAT(permission_target,'@' ,permission_type, ':', `grant`) as action  FROM mycp_permissions WHERE id = ? AND is_admin_rank = ?", $_GET["group"], (isset($_GET["admin"]) && $_GET["admin"])? 1 : 0);
    $new = array();
    foreach ($permissions as $permission) {
        $new[$permission["action"]] = 1;
    }
    $permissions = $new;
    unset($new);
    $targets = array();
    $name_override = array("show" => "Anzeigen", "edit" => "Bearbeiten", "execute" => "Ausführen");
    $possible = array();
    $files = array_merge(glob("navigation/*.php"), glob("*.php"));
    //TODO: Cachen, wenn das zu lange dauert
    foreach ($files as $file) {
        if ($file == 'global.php')
            continue;
        $handle = fopen($file, "r");
        if ($handle)
        {
            $file = explode(".", $file);
            $file = $file[0];
            $targets[$file] = array();
            $targets[$file]["permissions"] = array();
            $targets[$file]["name"] = "Unbenannte Seite";
            while (!feof($handle))
            {
                $buffer = fgets($handle);
                if(strpos($buffer, "r"."equire_permission(") !== false) {
                    $permission = explode("r"."equire_permission(", $buffer);
                    $permission = $permission[1];
                    $permission = trim($permission, "'\" ");
                    $targets[$file]["permissions"][] = $permission;
                    if (!in_array($permission, $possible))
                        $possible[] = $permission;
                }
                if(strpos($buffer, "r"."equire_admin()") !== false) {
                    $targets[$file]["permissions"][] = "show";
                    $targets[$file]["permissions"][] = "edit";
                    if (!in_array("show", $possible))
                        $possible[] = "show";
                    if (!in_array("edit", $possible))
                        $possible[] = "edit";
                }
                if(strpos($buffer, "c"."heck_permission(") !== false) {
                    $inner = explode("c"."heck_permission(", $buffer);
                    $inner = $inner[1];
                    $args = explode(",", $inner);
                    $target = trim($args[0], "); '\"\r\n");
                    $action = trim($args[1], "); '\"\r\n");
                    $targets[$target]["permissions"][] = $action;
                    $targets[$target]["name"] = ucfirst($target);
                }
                if(strpos($buffer, '$title =') !== false) {
                    $name = explode("=", $buffer);
                    $name = $name[1];
                    $name = trim($name, "'\" ;\n\r");
                    $targets[$file]["name"] = $name;
                }

            }
            if (strpos($file, "action_") === 0 && in_array("show", $targets[$file]["permissions"])) {
                $targets[$file]["permissions"] = array("execute");
                if (!in_array("execute", $possible))
                    $possible[] = "execute";
            }
            if (!sizeof($targets[$file]["permissions"]))
                unset($targets[$file]);
            fclose($handle);
        }
    }
    $targets["acp_permissions"]["name"] = $title;
    if ((isset($_GET["admin"]) && $_GET["admin"]))
        $group = $db->getFirst("SELECT name FROM mycp_adminranks WHERE id = ?", $_GET["group"]);
    else
        $group = $db->getFirst("SELECT name FROM mycp_groups WHERE id = ?", $_GET["group"]);

    ?>
    <h2>Berechtigungen für <?= (isset($_GET["admin"]) && $_GET["admin"]) ? "Adminrang" : "Gruppe" ?> <?= $group["name"] ?></h2>
    <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Für alle Seiten anwenden
            <span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="menu1">
            <?php foreach ($possible as $p) { ?>
            <li role="presentation"><a onclick="$('.p-<?= $p ?>').prop('checked', true);" role="menuitem" tabindex="-1" href="#"><?= (isset($name_override[$p]))? $name_override[$p] : $p  ?> erlauben</a></li>
            <?php } ?>
            <li role="presentation" class="divider"></li>
            <?php foreach ($possible as $p) { ?>
                <li role="presentation"><a onclick="$('.n-<?= $p ?>').prop('checked', true);" role="menuitem" tabindex="-1" href="#"><?= (isset($name_override[$p]))? $name_override[$p] : $p ?> verbieten</a></li>
            <?php } ?>
        </ul>
    </div>
    <form method="POST">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Seite</th>
            <th>Erlauben</th>
            <th>Verbieten</th>
        </tr>
        <?php foreach ($targets as $file => $target) { ?>
        <tr>
            <td><a href="<?= $file ?>.php"><?= $target["name"]?></a></td>
            <td><?php foreach($target["permissions"] as $permission) { ?>
                <input type="checkbox" class="p-<?= $permission ?>" name="grant[<?= $file ?>][<?= $permission ?>]" <?php if (isset($permissions[$file . "@" . $permission . ":1"])) echo "checked" ?>> <?= (isset($name_override[$permission]))? $name_override[$permission] : $permission ?><br>
                <?php } ?></td>
            <td><?php foreach($target["permissions"] as $permission) { ?>
                    <input type="checkbox" class="n-<?= $permission ?>" name="deny[<?= $file ?>][<?= $permission ?>]" <?php if (isset($permissions[$file . "@" . $permission . ":0"])) echo "checked" ?>> <?= (isset($name_override[$permission]))? $name_override[$permission] : $permission ?><br>
                <?php } ?></td>
        </tr>
     <?php } ?>
    </table>
    <button class="btn btn-primary" name="edit_permissions">Speichern</button>
    </form>

    <?php
}
else if (isset($_GET["faq"])) { ?>
<h2>FAQ</h2>
    <h3>Was ist der Unterschied zwischen Gruppen und Adminrängen?</h3>
    Zu Gruppen kannst du Nutzer über myCP hinzufügen. Der Adminrang ist der Wert, der in der Tabelle
    mit den Spielerdaten im Adminfeld steht. Üblicherweise gibt es auf SAMP-Servern eine Rangordnung,
    Rang 1 sind Supporter, Rang 4 Admins oder so ähnlich. Wenn du einem Ingame-Adminrang Rechte in myCP
    geben willst, fügst du den Adminrang einfach hinzu und gibst ihm dann die Rechte.<br>
    Die Gruppenzugehörigkeit hingegen hat nichts mit dem Adminrang zu tun. So könntest du etwa
    bestimmten Nutzern Rechte geben, die Statistiken einzusehen.
    <h3>Was bedeutet "Erlauben" und "Verbieten"</h3>
    Verbieten hat immer Vorrang vor Erlauben. Wenn also in Nutzer in 10 Gruppen ist und 9 davon ihm den Zugriff auf eine bestimmte Seite
    gewähren, die 10. ihn aber verbietet, kann er die Seite nicht aufrufen. Es reicht allerdings, wenn in einer Gruppe
    der Zugriff erlaubt wird, das muss nicht in jeder Gruppe geschehen.
    <h3>Was ist die Gruppe <i>Vollzugriff?</i></h3>
    Diese Gruppe wurde während der Installation erstellt, auch der erste Nutzer wurde dann eingetragen.<br>
    Die Gruppe sorgt dafür, dass nach dem Einrichten der unkomplizierte Zugriff auf das Dashboard möglich ist.
<?php }
else if (isset($_GET["create"])) { ?>
<h2><?= (isset($_GET["admin"]) && $_GET["admin"]) ? "Adminrang hinzufügen" : "Gruppe erstellen" ?></h2>
    <form method="post" action="acp_permissions.php">
        Name: <input tabindex="1" class="input" type="text" name="name"/>
        <?php if (isset($_GET["admin"]) && $_GET["admin"]) {?>
        <br>ID: <input tabindex="2" class="input" type="text" name="id">
        <?php } ?>
        <input type="hidden" name="admin" value="<?=  $_GET["admin"]?>">
        <button class="btn btn-primary" name="create">Erstellen</button>
    </form>
<?php }
else if (isset($_GET["users"]) && isset($_GET["group"]) && isset($_GET["admin"])) {
    if (isset($_GET["admin"]) && $_GET["admin"]) {
        $group = $db->getFirst("SELECT mycp_adminranks.name FROM mycp_adminranks WHERE id = ?", $_GET["group"]);
        $group = $group["name"];
        $users = $db->getAll("SELECT !id, !username FROM !accounts a WHERE a.!adminrights = ?", $_GET["group"]);
    }
    else
    {
        $group = $db->getFirst("SELECT mycp_groups.name FROM mycp_groups WHERE id = ?", $_GET["group"]);
        $group = $group["name"];
        $users = $db->getAll("SELECT !id, !username FROM !accounts a RIGHT JOIN mycp_users_to_groups ug ON ug.user = a.id WHERE ug.group = ?", $_GET["group"]);
    }
        ?>
<h2>Benutzer <?= (isset($_GET["admin"]) && $_GET["admin"]) ? "mit" : "in" ?> <i><?=  $group ?></i></h2>
<table class="table table-bordered">
    <?php foreach($users as $user) {?>
    <tr>
        <td>
            <?= $user["!username"] ?>
        </td>
        <?php if(! (isset($_GET["admin"]) && $_GET["admin"])) { ?>
        <td>
            <form method="post">
                <button class="btn btn-secondary" name="delete-user">Löschen</button>
                <input type="hidden" name="user" value="<?= $user["!id"] ?>">
            </form>
        </td>
            <?php } ?>
    </tr>
        <?php } ?>
</table>
    <?php if(! (isset($_GET["admin"]) && $_GET["admin"])) { ?>
    <form method="post">
        <h3>Benutzer hinzufügen</h3>
        Benutzername: <input type="text" name="username" id="adduser"><br>
        <ul id="adduser-data" class="autocomplete-data panel-footer"></ul>
        <button class="btn btn-secondary" name="add-user">Hinzufügen</button>
    </form>
        <script>new BauerAutoComplete().addAutocomplete(document.getElementById("adduser"), document.getElementById("adduser-data"))</script>
    <?php } else { ?>
        Adminränge müssen im Spiel zugewiesen werden.
    <?php } ?>
<?php }
else if (isset($_GET["delete"]) && isset($_GET["group"])) { ?>
<h2>Gruppe löschen</h2>
    Möchtest du die Gruppe wirklich löschen? Die Aktion kann nicht rückgängig gemacht werden.<br>
    <form method="post" action="acp_permissions.php?group=<?= $_GET["group"] ?>&admin=<?= $_GET["admin"] ?>">
        <button class="btn-primary" name="delete-group">Löschen</button>
    </form>
<?php }
else {
    $groups = $db->getAll("SELECT * FROM mycp_groups");
    $ranks = $db->getAll("SELECT * FROM mycp_adminranks");
    ?>
<style>
    tr[onclick]:hover {
        cursor: pointer;
    }
</style>
    Überfordert? In den <a href="acp_permissions.php?faq">FAQ</a> findest du sicher Antworten auf deine Fragen.
<h2>Gruppen<a href="acp_permissions.php?create&admin=0" class="pull-right btn btn-primary">Gruppe erstellen</a> </h2>

<table class="table table-striped table-hover">
    <tr>
        <th>Gruppe</th>
        <th>Name</th>
        <th><span class="pull-right">Aktionen</span></th>
    </tr>
    <?php foreach ($groups as $group) {?>
    <tr>
        <td><?= $group["id"] ?></td>
        <td><?= $group["name"] ?></td>
        <td>
            <a class="btn btn-secondary pull-right" href="acp_permissions.php?group=<?= $group["id"] ?>&admin=0&delete"><i class="fa fa-trash-o"></i> Löschen</a>
            <a class="btn btn-secondary pull-right" href="acp_permissions.php?group=<?= $group["id"] ?>&admin=0&users"><i class="fa fa-users"></i> Benutzer</a>
            <a class="btn btn-secondary pull-right" href="acp_permissions.php?group=<?= $group["id"] ?>&admin=0&permissions"><i class="fa fa-key"></i> Berechtigungen</a>
        </td>
    </tr>
        <?php } ?>
</table>
<h2>Adminränge<a href="acp_permissions.php?create&admin=1" class="pull-right btn btn-primary">Adminrang hinzufügen</a></h2>

<table class="table table-striped table-hover">
    <tr>
        <th>Rang</th>
        <th>Name</th>
        <th><span class="pull-right">Aktionen</span></th>
    </tr>
    <?php foreach ($ranks as $group) {?>
        <tr>
            <td><?= $group["id"] ?></td>
            <td><?= $group["name"] ?></td>
            <td>
                <a class="btn btn-secondary pull-right" href="acp_permissions.php?group=<?= $group["id"] ?>&admin=1&delete"><i class="fa fa-trash-o"></i> Löschen</a>
                <a class="btn btn-secondary pull-right" href="acp_permissions.php?group=<?= $group["id"] ?>&admin=1&users"><i class="fa fa-users"></i> Benutzer</a>
                <a class="btn btn-secondary pull-right" href="acp_permissions.php?group=<?= $group["id"] ?>&admin=1&permissions"><i class="fa fa-key"></i> Berechtigungen</a>
            </td>
        </tr>
    <?php } ?>
</table>
<?php }

include_once("templates/footer_acp.php");