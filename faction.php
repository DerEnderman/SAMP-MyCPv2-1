<?php
$currentPage = "faction.php";
include("global.php");
require_once("config.php");
require_login();
$title = "Fraktion";
include_once("templates/header_general.php");
?>

    <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="start.php"><?php get_projectname(); ?></a>
            </div>
            <div class="collapse navbar-collapse">
                <?php include("navigation/nav_2.php"); ?>
            </div>
            <!-- /.nav-collapse -->
        </div>
        <!-- /.container -->
    </div><!-- /.navbar -->

    <br/>
<div class="container">
<div class="row row-offcanvas row-offcanvas-right">
<div class="col-xs-12 col-sm-9">
<p class="pull-right visible-xs">
    <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
</p>
<br/>
<?php
$factions = $db->getFirst("SELECT * FROM factions");

$row = getConfig();
$data_faction = $row['data_faction'];
$data_leader = $row['data_leader'];
$data_sex = $row['data_sex'];

$username = $_SESSION["username"];
$data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");
$faction = $data2[$data_faction];
$leader = $data2[$data_leader];
$sex = $data2[$data_sex];

?>
<h3>Fraktion
    <small><?= $factions["faction_$faction"]; ?></small>
</h3>
<br/>
<?php
if ($_GET["status"] == 1) //success for changing settings
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Die Informationen wurden erfolgreich geändert.";
    echo "</div>";
}

if ($faction == 0 && $leader == 0)
{
    echo "<div class='alert alert-danger'>";
    echo "<strong>Hinweis:</strong> Du bist in keiner Fraktion Mitglied.";
    echo "</div>";
}
else
{

    ?>
    <div class="row">
    <div class="col-md-8">
        <div class="jumbotron" style="width: auto; height: 535px;">
            <h4>Informationen</h4>
            <?php show_faction_information($faction); ?>
        </div>
    </div>
    <div class="col-md-4">
    <div class="thumbnail">
    <br/>
    <img src="<?php show_faction_logo($faction); ?>" height="200" width="242px"/>

    <div class="caption">
    <h3><?= $factions["faction_$faction"]; ?></h3>

    <p>
    <table class="table table-striped">
        <tr>
            <td><b>Mitglieder</b></td>
            <td>
                <b><?php
                    $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE $data_faction = '$faction'");
                    $count = $queryHandle["count"];
                    echo $count; ?></b></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;davon Leader</td>
            <td><?php
                $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE $data_faction = '$faction' AND $data_leader != 0");
                $count = $queryHandle["count"];
                echo $count; ?></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;davon männlich</td>
            <td><?php
                $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE $data_faction = '$faction' AND $data_sex = 1");
                $count = $queryHandle["count"];
                echo $count; ?></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;davon weiblich</td>
            <td><?php
                $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE $data_faction = '$faction' AND $data_sex = 2");
                $count = $queryHandle["count"];
                echo $count; ?></td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;davon Teammitglieder</td>
            <td><?php
                $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE $data_faction = '$faction' AND !ucp_adminrights != 0");
                $count = $queryHandle["count"];
                echo $count; ?></td>
        </tr>
    </table>
    </p>
    <?php
    if ($leader != 0)
    {
        echo '<hr/><p><a href="#" class="btn btn-success btn-sm" role="button" data-toggle="modal" data-target=".bs-example-modal-lg"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Informationen bearbeiten</a></p>';
    }
    ?>
    <!-- Modal start -->
    <script type="text/javascript">
        <!--
        function insert(aTag, eTag) {
            var input = document.forms['formular'].elements['selected_object'];
            input.focus();
            /* f�r Internet Explorer */
            if (typeof document.selection != 'undefined') {
                /* Einf�gen des Formatierungscodes */
                var range = document.selection.createRange();
                var insText = range.text;
                range.text = aTag + insText + eTag;
                /* Anpassen der Cursorposition */
                range = document.selection.createRange();
                if (insText.length == 0) {
                    range.move('character', -eTag.length);
                } else {
                    range.moveStart('character', aTag.length + insText.length + eTag.length);
                }
                range.select();
            }
            /* f�r neuere auf Gecko basierende Browser */
            else if (typeof input.selectionStart != 'undefined') {
                /* Einf�gen des Formatierungscodes */
                var start = input.selectionStart;
                var end = input.selectionEnd;
                var insText = input.value.substring(start, end);
                input.value = input.value.substr(0, start) + aTag + insText + eTag + input.value.substr(end);
                /* Anpassen der Cursorposition */
                var pos;
                if (insText.length == 0) {
                    pos = start + aTag.length;
                } else {
                    pos = start + aTag.length + insText.length + eTag.length;
                }
                input.selectionStart = pos;
                input.selectionEnd = pos;
            }
            /* f�r die �brigen Browser */
            else {
                /* Abfrage der Einf�geposition */
                var pos;
                var re = new RegExp('^[0-9]{0,3}$');
                while (!re.test(pos)) {
                    pos = prompt("Einf�gen an Position (0.." + input.value.length + "):", "0");
                }
                if (pos > input.value.length) {
                    pos = input.value.length;
                }
                /* Einf�gen des Formatierungscodes */
                var insText = prompt("Bitte geben Sie den zu formatierenden Text ein:");
                input.value = input.value.substr(0, pos) + aTag + insText + eTag + input.value.substr(pos);
            }
        }
        //-->
    </script>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Schließen</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel"><span
                            class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Informationen bearbeiten</h4>
                </div>
                <div class="modal-body">
                    <!-- toolbar -->
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<b>", "</b>")' title="fett"><span
                            class='glyphicon glyphicon-bold'></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<i>", "</i>")' title="kursiv"><span
                            class='glyphicon glyphicon-italic'></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<font size=\"1pt\">", "</font>")'
                            title="Schriftgr&ouml;&szlig;e"><span
                            class="glyphicon glyphicon-text-height"></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<font color=\"red\">", "</font>")'
                            title="Schriftfarbe"><span
                            class="glyphicon glyphicon-tint"></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<hr />", "")' title="horizontale Linie">
                        <span class="glyphicon glyphicon-resize-horizontal"></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<ul><li>", "</li></ul>")' title="Liste">
                        <span class="glyphicon glyphicon-list"></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<img src=\"Bild-URL\" width=\"750px\" height=\"500px\" />", "")'
                            title="Bild"><span
                            class="glyphicon glyphicon-picture"></span></button>
                    <button type='button' class='btn btn-default btn-sm'
                            onClick='insert("<a href=\"URL-Ziel\">", "</a>")'
                            title="Link"><span class="glyphicon glyphicon-link"></span>
                    </button>
                    <br/> <br/>

                    <form name='formular' role='form' method='post'
                          action='action_edit_faction_information.php?faction=<?php echo $faction; ?>'>
                        <textarea name='selected_object' class='form-control' rows='8'
                                  placeholder='Text' maxlength="1250" required
                                  style='width: 870px; height: auto;'><?php show_faction_information($faction); ?></textarea><br/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Abbrechen
                    </button>
                    <input name='submit' type='submit' class='btn btn-success'
                           value='speichern'/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
    </div>
    </div>
    </div>
    </div>
<?php
}
?>
</div>
<?php
if ($faction == 0 && $leader == 0)
{
    //
}
else
{
    ?>
    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
        <br/><br/><br/><br/><br/>

        <div class="list-group">
            <a href="faction.php" class="list-group-item active">Allgmein</a>
            <a href="faction_member.php" class="list-group-item">Mitglieder</a>
            <?php
            if ($leader != 0)
            {
                echo "<a href='faction_listapplications.php' class='list-group-item'>Bewerbungen</a>";
            }
            ?>
        </div>
    </div>
<?php
}
?>
<!--/span-->
</div>
<!--/row-->

<hr/>
<footer>
    <?php get_footer2(); ?>
</footer>
<?php include_once("templates/footer_general.php");