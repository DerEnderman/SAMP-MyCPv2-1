<?php
$currentPage = "acp_news.php";
include("global.php");

require_admin();
$title = "Beitr&auml;ge";
include_once("templates/header_acp.php");

if (isset($_POST['submit']))
{
    if (empty($_POST['postedby']))
    {
        die('<div class="alert alert-error">Bitte gebe einen Autornamen an.</div>');
    }
    else
    {
        if (empty($_POST['subject']))
        {
            die('<div class="alert alert-error">Bitte gebe einen Titel f&uuml;r deinen Newseintrag an.</div>');
        }
        else
        {
            if (empty($_POST['news']))
            {
                die('<div class="alert alert-error">Bitte schreibe einen l&auml;ngeren Newseintrag.</div>');
            }
        }
    }
    $_POST["date"] = mktime();
    if ($db->add("news", $_POST, array("postedby", "news", "subject", "date")))
        echo '<br /> <div class="alert alert-success fade in" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Schlie&szlig;en</span></button><strong>Hinweis:</strong> Der Newsbeitrag wurde erfolgreich ver&ouml;ffentlicht.</div>';
}

if (isset($_POST['delete']))
{
    $id = (int)$_POST['delete'];
    if ($db->query("DELETE FROM news WHERE id = $id LIMIT 1"))
        echo "<div class='alert alert-success'> Der Newseintrag wurde erfolgreich gel&ouml;scht. </div>";
}

$news = $db->getAll('SELECT * FROM news ORDER BY id DESC');
?>

    <!-- Modal start -->
    <script type="text/javascript">
        <!--
        function insert(aTag, eTag) {
            var input = document.forms['formular'].elements['news'];
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
    <div class="row">
        <div class="col-md-6">
            <h4><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> Beitrag posten</h4> <br/> <br/>

            <form name="formular" method="post" action="#">
                <input class="form-control" name="postedby" id="postedby" type="Text" value='<?php get_username(); ?>'
                       placeholder="Autor" style="width: 200px;"/>
                <br/>
                <input class="form-control" name="subject" id="subject" type="Text" placeholder="&Uuml;berschrift"
                       style="width: 500px;"/>
                <br/>
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
                <br/><br/>
                <textarea class="form-control" name="news" id="news" cols="50" rows="7" placeholder="Beitragstext"
                          style="width: 500px;"></textarea>
                <br/>
                <button class="btn btn-primary" type="Submit" name="submit" id="submit" value="Enter News">&nbsp;ver&ouml;ffentlichen&nbsp;</button>
                <br/>
            </form>
        </div>
        <div class="col-md-6">
            <h4><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Beitr&auml;ge l&ouml;schen</h4>
            <?php
            foreach ($news as $output)
            echo "<div id='news-". $output["id"] ."'><b>Newseintrag: </b>" . $output['subject'] . ' &raquo; <a href="#" onclick="check(' . $output['id'] . '); return false;"><input type="submit" name="submit" value="L&ouml;schen" class="btn btn-danger"/></a><br /> <br /> <hr /></div>';
            ?>

            <script type="text/javascript">
                function check(id) {
                    if (confirm("Bist du sicher, dass du den ausgewaehlten Newseintrag löschen willst?")) {
                        $.post(document.location.href, {delete: id});
                        $("#news-"+id).hide(500);
                    }
                }</script>

        </div>
    </div>
<?php include_once("templates/footer_acp.php");