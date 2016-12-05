<?php
$currentPage = "acp_contents.php";
include("global.php");

require_admin();
$title = "Inhalte";
include_once("templates/header_acp.php");


if ($_GET["status"] == "success") //success for changing settings
{
    showMessage('Die Einstellungen wurden erfolgreich aktualisiert.', 'success'); 
}
?>
    <style type="text/css"> #size_2 {
            width: 800px;
        }

        #size_1 {
            width: 150px;
        }</style>
<script>
    function toggleMessage(e) {
        document.getElementsByName("login_message")[0].disabled = e.value != 0;
    }
</script>
    <form role="form" method="post" action="action_edit_contents.php">
        <h4>individuelle Nachricht beim Login</h4>
        <br/>
        <?php
        $row = getConfig();
        $status_loginmessage = $row['status_loginmessage'];
        $login_message = $row['login_message'];
        $footer_content_3 = $row['footer_content_3'];
        $footer_content_2 = $row['footer_content_2'];

        $header_img1 = $row['header_img1'];
        $header_img2 = $row['header_img2'];
        $header_img3 = $row['header_img3'];
        $header_headline1 = $row['header_headline1'];
        $header_headline2 = $row['header_headline2'];
        $header_headline3 = $row['header_headline3'];
        $header_text1 = $row['header_text1'];
        $header_text2 = $row['header_text2'];
        $header_text3 = $row['header_text3'];

        $start_img1 = $row['start_img1'];
        $start_img2 = $row['start_img2'];
        $start_img3 = $row['start_img3'];
        $start_headline1 = $row['start_headline1'];
        $start_headline2 = $row['start_headline2'];
        $start_headline3 = $row['start_headline3'];
        $start_text1 = $row['start_text1'];
        $start_text2 = $row['start_text2'];
        $start_text3 = $row['start_text3'];


        if ($status_loginmessage == 1)
        {
            echo "<select class='form-control' name='status_loginmessage' size='1' id='size_1' onchange='toggleMessage(this)'>";
            echo "<option value='0'>aktivieren</option>";
            echo "<option value='1' selected>deaktivieren</option>";
            echo "</select>";
        }
        else
        {
            echo "<select class='form-control' name='status_loginmessage' size='1' id='size_1' onchange='toggleMessage(this)'>";
            echo "<option value='0' selected>aktivieren</option>";
            echo "<option value='1'>deaktivieren</option>";
            echo "</select>";
        }
        ?>
        <br/>
        <textarea name="login_message" class="form-control" id="size_2" rows="3"
                  placeholder="Tippe hier den Text, der dem Benutzer beim Login in einer speziellen Box angezeigt werden soll." <?php if ($status_loginmessage == 1)
        {
            echo "disabled";
        } ?>><?= htmlspecialchars($login_message) ?></textarea>
        <br/>

        <h4>"Informationen" auf der Loginmaske</h4><br/>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-picture"
                                                                       aria-hidden="true"></span> Kopfbereich der
                    Loginmaske</a></li>
            <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-align-center"
                                                        aria-hidden="true"></span> Inhalte der Textkörper</a></li>
        </ul>
        <style type="text/css"> #tab1, #tab2 {
                width: 400px;
            }</style>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="tab1"><br/>

                <div class="input-group">
                    <div class="input-group-addon"><h4><span class="glyphicon glyphicon-picture"
                                                             aria-hidden="true"></span></h4></div>
                    <input name="header_img1" type="text" class="form-control"
                           placeholder="Quelle von Bild 1 -  (Bild-URL)" value="<?= htmlspecialchars($header_img1) ?>"
                           style="width: 600px; text-align: center;"/>
                    <input name="header_img2" type="text" class="form-control"
                           placeholder="Quelle von Bild 2 -  (Bild-URL)" value="<?= htmlspecialchars($header_img2) ?>"
                           style="width: 600px; text-align: center;"/>
                    <input name="header_img3" type="text" class="form-control"
                           placeholder="Quelle von Bild 3 -  (Bild-URL)" value="<?= htmlspecialchars($header_img3) ?>"
                           style="width: 600px; text-align: center;"/>
                </div>
                <br/>

                <div class="input-group">
                    <div class="input-group-addon"><h4><span class="glyphicon glyphicon-list-alt"
                                                             aria-hidden="true"></span></h4></div>
                    <input name="header_headline1" type="text" class="form-control" placeholder="Überschrift von Bild 1"
                           value="<?= htmlspecialchars($header_headline1) ?>"
                           style="width: 600px; text-align: center;"/>
                    <input name="header_headline2" type="text" class="form-control" placeholder="Überschrift von Bild 2"
                           value="<?= htmlspecialchars($header_headline2) ?>"
                           style="width: 600px; text-align: center;"/>
                    <input name="header_headline3" type="text" class="form-control" placeholder="Überschrift von Bild 3"
                           value="<?= htmlspecialchars($header_headline3) ?>"
                           style="width: 600px; text-align: center;"/>
                </div>
                <br/>

                <div class="input-group">
                    <div class="input-group-addon"><h4><span class="glyphicon glyphicon-info-sign"
                                                             aria-hidden="true"></span></h4></div>
                    <textarea name="header_text1" class="form-control" id="size_2" rows="2"
                              placeholder="Tippe hier den Text der unter der Überschrift von Bild 1 erscheinen soll."><?= htmlspecialchars($header_text1) ?></textarea>
                    <textarea name="header_text2" class="form-control" id="size_2" rows="2"
                              placeholder="Tippe hier den Text der unter der Überschrift von Bild 2 erscheinen soll."><?= htmlspecialchars($header_text2) ?></textarea>
                    <textarea name="header_text3" class="form-control" id="size_2" rows="2"
                              placeholder="Tippe hier den Text der unter der Überschrift von Bild 3 erscheinen soll."><?= htmlspecialchars($header_text3) ?></textarea>
                </div>
            </div>
            <div class="tab-pane fade" id="tab2">
                <div class="tab-pane fade in active" id="tab1"><br/>

                    <div class="input-group">
                        <div class="input-group-addon"><h4><span class="glyphicon glyphicon-picture"
                                                                 aria-hidden="true"></span></h4></div>
                        <input name="start_img1" type="text" class="form-control"
                               placeholder="Quelle von Bild 1 -  (Bild-URL)"
                               value="<?= htmlspecialchars($start_img1) ?>" style="width: 600px; text-align: center;"/>
                        <input name="start_img2" type="text" class="form-control"
                               placeholder="Quelle von Bild 2 -  (Bild-URL)"
                               value="<?= htmlspecialchars($start_img2) ?>" style="width: 600px; text-align: center;"/>
                        <input name="start_img3" type="text" class="form-control"
                               placeholder="Quelle von Bild 3 -  (Bild-URL)"
                               value="<?= htmlspecialchars($start_img3) ?>" style="width: 600px; text-align: center;"/>
                    </div>
                    <br/>

                    <div class="input-group">
                        <div class="input-group-addon"><h4><span class="glyphicon glyphicon-list-alt"
                                                                 aria-hidden="true"></span></h4></div>
                        <input name="start_headline1" type="text" class="form-control"
                               placeholder="Überschrift von Bild 1" value="<?= htmlspecialchars($start_headline1) ?>"
                               style="width: 600px; text-align: center;"/>
                        <input name="start_headline2" type="text" class="form-control"
                               placeholder="Überschrift von Bild 2" value="<?= htmlspecialchars($start_headline2) ?>"
                               style="width: 600px; text-align: center;"/>
                        <input name="start_headline3" type="text" class="form-control"
                               placeholder="Überschrift von Bild 3" value="<?= htmlspecialchars($start_headline3) ?>"
                               style="width: 600px; text-align: center;"/>
                    </div>
                    <br/>

                    <div class="input-group">
                        <div class="input-group-addon"><h4><span class="glyphicon glyphicon-info-sign"
                                                                 aria-hidden="true"></span></h4></div>
                        <textarea name="start_text1" class="form-control" id="size_2" rows="2"
                                  placeholder="Tippe hier den Text der unter der Überschrift von Bild 1 erscheinen soll."><?= htmlspecialchars($start_text1) ?></textarea>
                        <textarea name="start_text2" class="form-control" id="size_2" rows="2"
                                  placeholder="Tippe hier den Text der unter der Überschrift von Bild 2 erscheinen soll."><?= htmlspecialchars($start_text2) ?></textarea>
                        <textarea name="start_text3" class="form-control" id="size_2" rows="2"
                                  placeholder="Tippe hier den Text der unter der Überschrift von Bild 3 erscheinen soll."><?= htmlspecialchars($start_text3) ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function () {
                $('#myTab li:eq(0) a').tab('show');
            });
        </script>

        <h2 class="sub-header">Footer</h2>

        <p>Insgesamt gibt es zwei Footer, einen auf der Startseite (sichtbar f&uuml;r jeden Besucher der Internetseite)
            und einen Footer im gesicherten Loginbereich (sichtbar nur f&uuml;r eingeloggte Benutzer).</p>
        <br/>
        <h4>Footer auf der Loginmaske</h4><br/>
        <textarea name="footer_content_3" class="form-control" id="size_2" rows="1"
                  placeholder="Hier kannst du auch <html>-Tags benutzen. z.B <b>, <a>, <font>"><?= htmlspecialchars($footer_content_3) ?></textarea>
        <br/>
        <h4>Footer im internen Bereich</h4><br/>
        <textarea name="footer_content_2" class="form-control" id="size_2" rows="1"
                  placeholder="Hier kannst du auch <html>-Tags benutzen. z.B <b>, <a>, <font>"><?= htmlspecialchars($footer_content_2) ?></textarea>
        <br/>
        <input type="submit" name="submit" class="btn btn-success" value="speichern"/>
    </form>
<?php include_once("templates/footer_acp.php");