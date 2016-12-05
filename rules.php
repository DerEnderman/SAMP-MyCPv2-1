<?php
$currentPage = "rules.php";
include("global.php");
require_once("config.php");
require_login();
$title = "Regeln";
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

            <h3>Regeln</h3><br/>
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
                    <?php

                    $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM rules WHERE type = 1");
                    $count = $queryHandle["count"];
                    if ($count == 0)
                    {
                        echo "<div class='alert alert-danger' role='alert'>";
                        echo "<strong>Hinweis:</strong> Derzeit gibt es keine Regeln.";
                        echo "</div>";
                    }
                    else
                    {
                        $result = $db->getAll("SELECT * FROM rules WHERE type = 1");
                        $i = 1;
                        foreach ($result as $row)
                        {
                            $row = (object)$row;
                            echo "</tbody>";
                            echo "<tr>";
                            echo "<td><kbd>&sect; ", $i, "</kbd></td>";
                            echo "<td><b> ", $row->headline, "</b></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<br /><td><p> ", $row->text, "</p></td>";
                            echo "</tr><hr />";
                            echo "</tbody>";
                            $i++;
                        }
                        echo "</table>";
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="ts_rules"><br/>
                    <?php
                    $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM rules WHERE type = 2");
                    $count = $queryHandle["count"];
                    if ($count == 0)
                    {
                        echo "<div class='alert alert-danger' role='alert'>";
                        echo "<strong>Hinweis:</strong> Derzeit gibt es keine TeamSpeak-Regeln.";
                        echo "</div>";
                    }
                    else
                    {
                        $result = $db->getAll("SELECT * FROM rules WHERE type = 2");
                        $i=1;
                        foreach ($result as $row)
                        {
                            $row = (object)$row;
                            echo "</tbody>";
                            echo "<tr>";
                            echo "<td><kbd>&sect; ", $i, "</kbd></td>";
                            echo "<td><b> ", $row->headline, "</b></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<br /><td><p> ", $row->text, "</p></td>";
                            echo "</tr><hr />";
                            echo "</tbody>";
                            $i++;
                        }
                        echo "</table>";
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="punishment"><br/>
                    <?php show_rules_tab3(); ?>
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