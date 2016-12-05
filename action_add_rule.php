<?php
$title = "Aktion: Regel hinufügen";
include("global.php");
require_admin();

$type = sanitize($_POST['type']);
$headline = sanitize($_POST['headline']);
$text = sanitize($_POST['text']);

if ($type == 0)
{
    redirect("error.php?errorid=1");
}
else
{
    user_log("add_rule", "Regel " . $headline . " hinzugefügt.");
    $db->query("INSERT INTO rules (type, headline, text) VALUES (?, ?, ?)", $type, $headline, $text);
    redirect("acp_rules.php?status=1");
}