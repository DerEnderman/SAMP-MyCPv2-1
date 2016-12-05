<?php
$currentPage = "faction.php";
include("global.php");
require_once("config.php");
require_login();

$row = getConfig();
$data_leader = $row['data_leader'];

$username = $_SESSION['username'];
$data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");
$user_leader = $data2[$data_leader];

if ($user_leader == 0)
{
    redirect("error.php?errorid=3");
}

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
            $data = $db->getFirst("SELECT * FROM factions");
            $faction_1 = $data['faction_1'];
            $faction_2 = $data['faction_2'];
            $faction_3 = $data['faction_3'];
            $faction_4 = $data['faction_4'];
            $faction_5 = $data['faction_5'];
            $faction_6 = $data['faction_6'];
            $faction_7 = $data['faction_7'];
            $faction_8 = $data['faction_8'];
            $faction_9 = $data['faction_9'];
            $faction_10 = $data['faction_10'];
            $faction_11 = $data['faction_11'];
            $faction_12 = $data['faction_12'];
            $faction_13 = $data['faction_13'];
            $faction_14 = $data['faction_14'];
            $faction_15 = $data['faction_15'];
            $faction_16 = $data['faction_16'];
            $faction_17 = $data['faction_17'];
            $faction_18 = $data['faction_18'];
            $faction_19 = $data['faction_19'];
            $faction_20 = $data['faction_20'];

            $row = getConfig();
            $data_faction = $row['data_faction'];
            $data_leader = $row['data_leader'];

            $username = $_SESSION['username'];
            $data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");
            $faction = $data2[$data_faction];
            $leader = $data2[$data_leader];

            ?>
            <h3>Fraktion
                <small><?php if ($faction == 1 || $leader == 1)
                    {
                        echo $faction_1;
                    }
                    else if ($faction == 2 || $leader == 2)
                    {
                        echo $faction_2;
                    }
                    else if ($faction == 3 || $leader == 3)
                    {
                        echo $faction_3;
                    }
                    else if ($faction == 4 || $leader == 4)
                    {
                        echo $faction_4;
                    }
                    else if ($faction == 5 || $leader == 5)
                    {
                        echo $faction_5;
                    }
                    else if ($faction == 6 || $leader == 6)
                    {
                        echo $faction_6;
                    }
                    else if ($faction == 7 || $leader == 7)
                    {
                        echo $faction_7;
                    }
                    else if ($faction == 8 || $leader == 8)
                    {
                        echo $faction_8;
                    }
                    else if ($faction == 9 || $leader == 9)
                    {
                        echo $faction_9;
                    }
                    else if ($faction == 10 || $leader == 10)
                    {
                        echo $faction_10;
                    }
                    else if ($faction == 11 || $leader == 11)
                    {
                        echo $faction_11;
                    }
                    else if ($faction == 12 || $leader == 12)
                    {
                        echo $faction_12;
                    }
                    else
                    {
                        if ($faction == 13 || $leader == 13)
                        {
                            echo $faction_13;
                        }
                        else
                        {
                            if ($faction == 14 || $leader == 14)
                            {
                                echo $faction_14;
                            }
                            else
                            {
                                if ($faction == 15 || $leader == 15)
                                {
                                    echo $faction_15;
                                }
                                else
                                {
                                    if ($faction == 16 || $leader == 16)
                                    {
                                        echo $faction_16;
                                    }
                                    else
                                    {
                                        if ($faction == 17 || $leader == 17)
                                        {
                                            echo $faction_17;
                                        }
                                        else
                                        {
                                            if ($faction == 18 || $leader == 18)
                                            {
                                                echo $faction_18;
                                            }
                                            else
                                            {
                                                if ($faction == 19 || $leader == 19)
                                                {
                                                    echo $faction_19;
                                                }
                                                else
                                                {
                                                    if ($faction == 20 || $leader == 20)
                                                    {
                                                        echo $faction_20;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } ?></small>
            </h3>
            <br/>
            <?php
            if ($faction == 0 && $leader == 0)
            {
                echo "<div class='alert alert-danger'>";
                echo "<strong>Hinweis:</strong> Du bist in keiner Fraktion Mitglied.";
                echo "</div>";
            }
            else
            {

                ?>
                <h4>Bewerbungen</h4><br/>
                <?php
                if ($_GET["status"] == 1) //success for reject a faction application
                {
                    echo "<div class='alert alert-success fade in' role='alert'>";
                    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
                    echo "<strong>Hinweis:</strong> Du hast die Fraktions-Bewerbung erfolgreich abgelehnt.";
                    echo "</div>";
                }
                if ($_GET["status"] == 2) //success for accept a faction application
                {
                    echo "<div class='alert alert-success fade in' role='alert'>";
                    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
                    echo "<strong>Hinweis:</strong> Du hast die Fraktions-Bewerbung erfolgreich angenommen, der Benutzer ist nun Mitglied deiner Fraktion.";
                    echo "</div>";
                }

                $result = $db->getAll("SELECT * FROM faction_applications WHERE faction = '$leader' AND status = '1'");
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>&nbsp;&nbsp;&nbsp;<b>Bewerbungs-ID</b>&nbsp;&nbsp;&nbsp;</th>";
                echo "<th>&nbsp;&nbsp;&nbsp;<b>Erstelldatum</b>&nbsp;&nbsp;&nbsp;</th>";
                echo "<th>&nbsp;&nbsp;&nbsp;<b>Bewerber</b>&nbsp;&nbsp;&nbsp;</th>";
                echo "<th>&nbsp;&nbsp;&nbsp;<b>Status</b>&nbsp;&nbsp;&nbsp;</th>";
                echo "</tr>";
                echo "</thead>";
                foreach ($result as $row)
                {
                    $row = (object)$row;
                    echo "<tr>";
                    echo "<td>", $row->id, "</td>";
                    echo "<td>", $row->date_of_creation, "</td>";
                    echo "<td>", $row->creator, "</td>";
                    echo "<td>";
                    if ($row->status == 1)
                    {
                        echo "<p class='text-danger'>neu eingegangen</p>";
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($row->status == 1)
                    {
                        echo "<a href=\"action_show_faction_application.php?action=showApplication&Id=" . $row->id . "\"><button type='button' class='btn btn-default btn-xs'>Anzeigen</button></a></td>";
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($row->status == 1)
                    {
                        echo "<a href=\"action_accept_faction_application.php?action=acceptApplication&Id=" . $row->id . "\"><button type='button' class='btn btn-success btn-xs'>Annehmen</button></a></td>";
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($row->status != 2)
                    {
                        echo "<a href=\"action_reject_faction_appliaction.php?action=rejectApplication&Id=" . $row->id . "\"><button type='button' class='btn btn-danger btn-xs'>Ablehnen</button></a></td>";
                    }
                    echo "</td>";
                    echo "</tr>";
                    echo "</tbody>";
                }
            }
            echo "</table>";
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
                    <a href="faction.php" class="list-group-item">Allgmein</a>
                    <a href="faction_member.php" class="list-group-item">Mitglieder</a>
                    <a href="faction_listapplications.php" class="list-group-item active">Bewerbungen</a>
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