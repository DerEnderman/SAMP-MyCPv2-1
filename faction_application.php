<?php

$currentPage = "faction.php";
include("global.php");
require_once("config.php");
require_login();

$title = "Bewerbungen";
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

            <h3>Bewerbungen</h3><br/>
            <?php
            if (htmlspecialchars($_GET["show_application"]) == true)
            {
                $selected_object = $_SESSION["object_id"];

                $query2 = $db->getFirst("SELECT * FROM faction_applications WHERE id = '$selected_object'");

                $id = $query2['id'];
                $date_of_creation = $query2['date_of_creation'];
                $creator = $query2['creator'];
                $status = $query2['status'];


                if ($status == 0)
                {
                    $current_status = "fehlerhaft";
                }
                else
                {
                    if ($status == 1)
                    {
                        $current_status = "neu eingegangen";
                    }
                }
                echo "<table>";
                echo "<tr>";
                echo "<td><a href='faction_listapplications.php'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck</button></a>&nbsp;&nbsp;&nbsp;&nbsp;";
                echo "</tr>";
                echo "</table> <br /><br />";
                echo "<div class='well' style='height: auto; width: auto;'>";
                echo "<h6 id='size'><b>Bewerbungs-ID:</b> $id &nbsp;&nbsp;&nbsp;&nbsp; <b>Erstelldatum:</b> $date_of_creation &nbsp;&nbsp;&nbsp;&nbsp; <b>Bewerber:</b> $creator &nbsp;&nbsp;&nbsp;&nbsp; <b>Status:</b> $current_status </h6><hr />";
                show_faction_application($selected_object);
                echo "</div>";
                if ($status = 1)
                {
                    echo "<a href='action_accept_faction_application.php?action=acceptApplication&Id=$selected_object'><button type='button' class='btn btn-success'>Annehmen</button></a>";
                }
                if ($status != 2)
                {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='action_reject_faction_appliaction.php?action=rejectApplication&Id=$selected_object'><button type='button' class='btn btn-danger'>Ablehnen</button></a>";
                }
            }
            ?>
        </div>
        <!--/span-->
    </div>
    <!--/row-->

    <hr/>
    <footer>
        <?php get_footer2(); ?>
    </footer>
<?php include_once("templates/footer_general.php");