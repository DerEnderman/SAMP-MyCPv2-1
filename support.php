<?php
$currentPage = "support.php";
include_once("global.php");

require_login();
$title = "Support";
include_once("templates/header_general.php");
$added = 0;
if (isset($_POST["topic"]) && isset($_POST["content"])) {
    $conversation = newConversationID();
    $db->add("support_tickets", array("conversation_id" => $conversation, "creator" => $_SESSION["id"], "topic" => strip_tags($_POST["topic"])));
    $added = $db->add("conversations", array("conversation" => $conversation, "author" => $_SESSION["id"], "content" => strip_tags($_POST["content"])));
}
$supports = $db->getAll("SELECT * FROM support_tickets WHERE creator = ?", $_SESSION["id"]);
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
<?php
if ($added)
    showMessage("Das Supportticket wurde erstellt. Du solltest in Kürze eine Antwort erhalten.", "success");
?>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <br/>

            <h3>Support</h3><br/>
            <ul id="myTab" class="nav nav-tabs">
                <li class="active"><a href="#list_tickets" data-toggle="tab"><span
                            class="glyphicon glyphicon-th-list"></span> Supporttickets <span
                            class="label label-default"><?=sizeof($supports); ?></span></a></li>
                <li><a href="#create_ticket" data-toggle="tab"><span class="glyphicon glyphicon-comment"></span>
                        Supportticket schreiben</a></li>
                <li><a href="#complaint" data-toggle="tab"><span class="glyphicon glyphicon-bullhorn"></span> Beschwerde
                        schreiben</a></li>
            </ul>
            <style type="text/css"> #create_ticket {
                    width: 400px;
                }
                tr[onclick]:hover {
                    cursor: pointer;
                }
                #complaint {
                    width: 400px;
                }</style>
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
                        <tr onclick="document.location='ticket.php?id=<?= $support["ticket_id"]?>'">
                            <td><?= $support["ticket_id"] ?></td>
                            <td><?= $support["topic"]?></td>
                            <td><?= $status ?></td>
                            <td>am <?= date("d.m.Y - H:i", strtotime($support["date_of_creation"])) ?></td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
                <div class="tab-pane fade" id="create_ticket"><br/>

                    <form role="form" method="post">
                        <input name="topic" type="text" class="form-control" placeholder="Thema" required/><br/>
                        <textarea name="content" class="form-control" rows="12" placeholder="Text" required></textarea><br/>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required/>
                                Ich best&auml;tige, keine L&ouml;sung in den FAQs bez&uuml;glich meines Problems
                                gefunden zu haben.
                            </label>
                        </div>
                        <br/>
                        <input name="submit" type="submit" class="btn btn-primary" value="Abschicken"/>
                    </form>
                </div>
                <div class="tab-pane fade" id="complaint"><br/>

                    <form role="form" method="post" action="action_createcomplaint.php">
                        <input name="complaint_perpetrator" type="text" class="form-control"
                               placeholder="Name des T&auml;ters" required/><br/>
                        <input name="complaint_case" type="text" class="form-control" placeholder="Art des Vergehens"
                               required/><br/>
                        <textarea name="complaint_info" class="form-control" rows="12"
                                  placeholder="Beschreibung des Vorfalls" required></textarea><br/>
                        <input name="complaint_screen_1" type="text" class="form-control"
                               placeholder="Bild-URL - Screenshot 1 (Pflicht)" required/><br/>
                        <input name="complaint_screen_2" type="text" class="form-control"
                               placeholder="Bild-URL - Screenshot 2"/><br/>
                        <input name="complaint_screen_3" type="text" class="form-control"
                               placeholder="Bild-URL - Screenshot 3"/><br/>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" required/>
                                Ich best&auml;tige, dass mein Anliegen ausnahmslos der Wahrheit entspricht und bin mir dar&uuml;ber hinaus
                                bewusst, dass es bei einer Falschmeldung zu einer Sanktion ("Strafe") kommen kann.
                            </label>
                        </div>
                        <br/>
                        <input name="submit" type="submit" class="btn btn-primary" value="Abschicken"/>
                    </form>
                </div>
            </div>
            <script>
                $(function () {
                    $('#myTab li:eq(0) a').tab('show');
                });
            </script>
        </div>
        <!--/span-->
    </div>
    <!--/row-->

    <hr/>
    <footer>
        <?php get_footer2(); ?>
    </footer>
<?php include_once("templates/footer_general.php");