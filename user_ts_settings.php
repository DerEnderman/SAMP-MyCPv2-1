<?php

$currentPage = "user_ts_settings.php";
include("global.php");
require_once("config.php");
require_login();

$title = "Profil";
?>
<?php include_once("templates/header_general.php"); ?>
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

            <h3>Profil</h3><br/>
            <?php
            $row = getConfig();
            $status_ts_controller = $row['status_ts_controller'];


            if ($status_ts_controller == 1)
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong>Hinweis:</strong> Die automatische TeamSpeak-Registration wurde deaktiviert und ist derzeit nicht verf&uuml;gbar.";
                echo "</div>";
            }
            else
            {

                ?>

                <div class="panel panel-default">
                    <div class="panel-heading">TeamSpeak Einstellungen</div>
                    <div class="panel-body">
                        <ul id="myTab" class="nav nav-tabs">
                            <li class="active"><a href="#getrights" data-toggle="tab"><span
                                        class="glyphicon glyphicon-plus-sign"></span> Rechte erhalten</a></li>
                            <li><a href="#revokerights" data-toggle="tab"><span
                                        class="glyphicon glyphicon-minus-sign"></span> Rechte entziehen</a></li>
                        </ul>
                        <style type="text/css"> #size_1 {
                                width: 400px;
                            }</style>
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="getrights"><br/>
                                <?php
                                $username = $_SESSION['username'];
                                $data = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");
                                $verified = $data['verified'];
                                $TS_UID = $data['TS_UID'];

                                $row = getConfig();
                                $TS_servergroupname = $row['TS_servergroupname'];

                                if (htmlspecialchars($_GET["status"]) == 1)
                                {
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>Hinweis:</strong> Die TeamSpeak-Verifizierung war erfolgreich.";
                                    echo "</div>";
                                }
                                else
                                {
                                    if (htmlspecialchars($_GET["status"]) == 2)
                                    {
                                        echo "<div class='alert alert-success'>";
                                        echo "<strong>Hinweis:</strong> Die TeamSpeak-Rechte wurden dir erfolgreich entzogen und deine Verifizierung zur&uuml;ckgesetzt.";
                                        echo "</div>";
                                    }
                                    else
                                    {
                                        if ($verified == 1)
                                        {
                                            echo "<div class='alert alert-warning'>";
                                            echo "<strong>Hinweis:</strong> Du bist bereits im Teamspeak registriert. <a href='action_revokerights.php'>Hier</a> kannst du deine Registration aufheben. <br />";
                                            echo "Du bist derzeit mit der eindeutigen ID <b>" . $TS_UID . "</b> registriert.";
                                            echo "</div>";
                                        }
                                        else
                                        {
                                            if ($verified == 0)
                                            {
                                                ?>
                                                <div class="alert alert-warning">
                                                    <strong>Warnung:</strong> Bitte verwende aus Sicherheitsgr&uuml;nden
                                                    nur
                                                    deine
                                                    eigene eindeutige ID.
                                                </div>
                                                <br/>
                                                <form class="form-signin" role="form" action="action_getrights.php"
                                                      method="post">
                                                    <input name="TS_UID" type="text" class="form-control"
                                                           placeholder="eindeutige ID" id="size_1" required/><br/>
                                                    <select name="TS_servergroup" class="form-control input-sm"
                                                            id="size_1">
                                                        <option
                                                            value="1"><?= htmlspecialchars($TS_servergroupname) ?></option>
                                                    </select><br/>

                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="ownUID" type="checkbox" value="1" required/>
                                                            Ich best&auml;tige das die von mir eingegebene eindeutige ID
                                                            <br/>
                                                            <u><b>meine eigene</b></u> ist.
                                                        </label>
                                                    </div>
                                                    <br/>
                                                    <input class="btn btn-lg btn-success btn-block" type="submit"
                                                           value="weiter"
                                                           id="size_1"/>
                                                </form>
                                            <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="revokerights"><br/>
                                <?php
                                if (htmlspecialchars($_GET["status"]) == 2)
                                {
                                    echo "<div class='alert alert-success'>";
                                    echo "<strong>Hinweis:</strong> Die TeamSpeak-Rechte wurden dir erfolgreich entzogen und deine Verifizierung zur&uuml;ckgesetzt.";
                                    echo "</div>";
                                }
                                else if ($verified == 0)
                                {
                                    echo "<div class='alert alert-danger'>";
                                    echo "<strong>Hinweis:</strong> Du hast dich noch nicht im Teamspeak registriert.";
                                    echo "</div>";
                                }
                                else if ($verified == 1)
                                {
                                    ?>
                                    <form class="form-signin" role="form" action="action_revokerights.php">
                                        <input name="TS_UID" type="text" class="form-control"
                                               placeholder="eindeutige ID" value="<?= htmlspecialchars($TS_UID) ?>"
                                               id="size_1" disabled/><br/><br/>
                                        <input class="btn btn-lg btn-danger btn-block" type="submit"
                                               value="unwiederruflich entziehen" id="size_1"/>
                                    </form>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <script>
                            $(function () {
                                $('#myTab li:eq(0) a').tab('show');
                            });
                        </script>
                    </div>
                </div><br/>
            <?php } ?>
        </div>
        <!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <br/><br/><br/>

            <div class="list-group">
                <a href="profile.php" class="list-group-item">Profil</a>
                <a href="user_settings.php" class="list-group-item">allgemeine Einstellungen</a>
                <a href="user_ts_settings.php" class="list-group-item active">TeamSpeak Einstellungen</a>
            </div>
        </div>
        <!--/span-->
    </div>
    <!--/row-->

    <hr/>
    <footer>
        <?php get_footer2(); ?>
    </footer>
<?php include_once("templates/footer_general.php");