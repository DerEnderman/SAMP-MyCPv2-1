<?php
$currentPage = "acp_rules.php";
include("global.php");
require_admin();
$title = "Regel bearbeiten";
include_once("templates/header_acp.php");

$selected_id = (int)$_GET["ruleId"];

$data = $db->getFirst("SELECT * FROM rules WHERE id = '$selected_id'");
$id = $data["id"];
$headline = $data["headline"];
$text = $data["text"];
$type = $data["type"];

?>
<a href='acp_rules.php'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck</button></a>&nbsp;&nbsp;&nbsp;&nbsp;
<br /> <br />
<form role="form" method="post" action="#">
    <select class="form-control" name="type" size="1" style="width: 870px;">
        <option value='1' <?php if($type == 1){echo "selected";}?>>allgemeine Regel</option>
        <option value='2' <?php if($type == 2){echo "selected";}?>>TeamSpeak-Regel</option>
    </select>
    <br />
    <div class="row">
        <div class="col-md-1"><input name="paragraph" type="number" class="form-control" placeholder="§" style="width: 60px;" value="<?= $id; ?>" disabled/></div>
        <div class="col-md-2"><input name="headline" type="text" class="form-control" placeholder="Titel des Paragraphen" style="width: 765px;" value="<?= $headline; ?>" required/></div>
    </div>
    <textarea name='text' class='form-control' rows='3' placeholder='detailierte Beschreibung der Regelung' required style='width: 870px; height: auto;'><?= $text; ?></textarea>
    <br />
    <input name='submit' type='submit' class='btn btn-success' value='speichern'/>
</form>

<?php
if (!empty($_POST['submit']))
{
    $new_id = $_GET["ruleId"];
    $new_headline = $_POST['headline'];
    $new_text = $_POST['text'];
    $new_type = $_POST['type'];

    user_log("edit_rule");
    echo "<br /> Einen Augenblick bitte...";

    $db->query("UPDATE rules SET type = '$new_type', id = '$new_id', headline = '$new_headline', text = '$new_text' WHERE id = '$id'");
    redirect("acp_rules.php?status=4");
}

?>

<?php include_once("templates/footer_acp.php");