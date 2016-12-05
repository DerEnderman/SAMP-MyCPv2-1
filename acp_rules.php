<?php
$currentPage = "acp_rules.php";
include("global.php");

require_admin();

$title = "Regeln";
include_once("templates/header_acp.php");

if (isset($_GET["status"])) {
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>";
    if ($_GET["status"] == 1) //success for creating a rule
        echo "<strong>Hinweis:</strong> Die Regel wurde erfolgreich erstellt.";
    elseif ($_GET["status"] == 2) //success for deleting a rule
        echo "<strong>Hinweis:</strong> Die Regel wurde erfolgreich gelöscht.";
    elseif ($_GET["status"] == 3) //success for editing content on tab 3
            echo "<strong>Hinweis:</strong> Der Inhalt wurde erfolgreich aktualisiert.";
    echo "</div>";
}

$rules1 = $db->getAll("SELECT * FROM rules WHERE type = 1 ORDER BY id");
$rules2 = $db->getAll("SELECT * FROM rules WHERE type = 2 ORDER BY id");
?>
    <ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#general_rules" data-toggle="tab"><span
                    class="glyphicon glyphicon-book"></span> allgemeine Spielregeln</a></li>
        <li><a href="#ts_rules" data-toggle="tab"><span class="glyphicon glyphicon-headphones"></span> TeamSpeak
                Regeln</a></li>
        <li><a href="#punishment" data-toggle="tab"><span class="glyphicon glyphicon-flash"></span> Strafen /
                Sanktionen</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="general_rules"><br/>

            <div align="right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Regel hinzufügen
                </button>
            </div>
            <?php
            if (!sizeof($rules1))
            {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<strong>Hinweis:</strong> Derzeit gibt es keine Regeln.";
                echo "</div>";
            }
            else
            {
                $i=1;
                foreach ($rules1 as $result)
                {
                    $row = (object) $result;
                    echo "<tr>";
                    echo "<td><kbd>&sect; ", $i, "</kbd></td>";
                    echo "<td><b> ", $row->headline, "</b></td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<br /><td><p> ", $row->text, "</p></td>";
                    echo "<td><a href=\"edit_rule.php?action=editRule&ruleId=" . $row->id . "\"><button type='button' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> bearbeiten</button></a></td>";
                    echo "<td><a href=\"action_delete_rule.php?action=deleteRule&ruleId=" . $row->id . "\"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span> Löschen</button></a></td>";
                    echo "</tr><hr />";
                    $i++;
                }
                echo "</table>";
            }
            ?>
        </div>
        <div class="tab-pane fade" id="ts_rules"><br/>

            <div align="right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Regel hinzufügen
                </button>
            </div>
            <?php
            if (!sizeof($rules2))
            {
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<strong>Hinweis:</strong> Derzeit gibt es keine Regeln.";
                echo "</div>";
            }
            else
            {
                $i = 1;
                foreach ($rules2 as $result)
                {
                    $row = (object) $result;
                    echo "<tr>";
                    echo "<td><kbd>&sect; ", $i, "</kbd></td>";
                    echo "<td><b> ", $row->headline, "</b></td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<br /><td><p> ", $row->text, "</p></td>";
                    echo "<td><a href=\"edit_rule.php?action=editRule&ruleId=" . $row->id . "\"><button type='button' class='btn btn-success btn-xs'><span class='glyphicon glyphicon-pencil'></span> bearbeiten</button></a></td>";
                    echo "<td><a href=\"action_delete_rule.php?action=deleteRule&ruleId=" . $row->id . "\"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span> Löschen</button></a></td>";
                    echo "</tr><hr />";
                    $i++;
                }
                echo "</table>";
            }
            ?>
        </div>
        <div class="tab-pane fade" id="punishment"><br/>

            <div align="right">
                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target=".bs-example-modal-lg2"><span class="glyphicon glyphicon-edit"
                                                                  aria-hidden="true"></span> Inhalt bearbeiten
                </button>
            </div>
            <?php show_rules_tab3(); ?>
        </div>
    </div>
    <script>
        $(function () {
            $('#myTab li:eq(0) a').tab('show');
        });
    </script>
    <!-- Modal start -->
    <script type="text/javascript">
        <!--
        function insert(aTag, eTag) {
            var input = document.forms['formular'].elements['selected_object2'];
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
    <div class="modal fade bs-example-modal-lg2" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Schließen</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel"><span
                            class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        Inhalt bearbeiten</h4>
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
                          action='action_edit_rule_information.php'>
                        <textarea name='selected_object2' class='form-control' rows='8'
                                  placeholder='Text' required
                                  style='width: 870px; height: auto;'><?php show_rules_tab3(); ?></textarea><br/>
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
    <!-- Modal start -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Schließen</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel"><span
                            class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Regel hinzufügen</h4>
                </div>
                <form name='formular' role='form' method='post' action='action_add_rule.php'>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <td><b>Typ:</b></td>
                                <td>
                                    <select class="form-control" name="type" size="1">
                                        <option value='1' selected>allgemeine Regel
                                        </option>
                                        <option value='2'>TeamSpeak-Regel
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <input name="headline" type="text" class="form-control"
                               placeholder="Titel des Paragraphen" required/>
                        <br/><br/>

                        <textarea name='text' class='form-control' rows='3'
                                  placeholder='detailierte Beschreibung der Regelung' required
                                  style='width: 870px; height: auto;'></textarea><br/>
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
<?php include_once("templates/footer_acp.php");