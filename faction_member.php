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
$data_username = $row['data_username'];

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
        else
        {
            if ($faction == 11 || $leader == 11)
            {
                echo $faction_11;
            }
            else
            {
                if ($faction == 12 || $leader == 12)
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
    <h4>Mitglieder</h4><br/>
    <?php
    if ($_GET["status"] == 1) //success for kicking a member
    {
        echo "<div class='alert alert-success fade in' role='alert'>";
        echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
        echo "<strong>Hinweis:</strong> Du hast den Benutzer erfolgreich aus deiner Fraktion entlassen.";
        echo "</div>";
    }
    if ($_GET["status"] == 2) //error for self-kick
    {
        echo "<div class='alert alert-danger fade in' role='alert'>";
        echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
        echo "<strong>Hinweis:</strong> Du kannst dich als Leader nicht selbst aus der Fraktion enlassen.";
        echo "</div>";
    }

    $row = getConfig();
    $data_faction = $row['data_faction'];
    $data_lastlogin = $row['data_lastlogin'];
    $data_rank = $row['data_rank'];
    $data_username = $row['data_username'];

    $queryHandle = $db->getFirst("SELECT COUNT(*) AS count FROM !accounts WHERE $data_faction = $faction");
    $count = $queryHandle["count"];
    if ($count == 0)
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<strong>Hinweis:</strong> Derzeit gibt es keine Mitglieder in deiner Fraktion.";
        echo "</div>";
    }
    else
    {
        $result = $db->getAll("SELECT * FROM !accounts WHERE $data_faction = $faction");
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead>";
        echo "<tr>";
        echo "<td>&nbsp;&nbsp;&nbsp;<b>Benutzername</b>&nbsp;&nbsp;&nbsp;</td>";
        echo "<td>&nbsp;&nbsp;&nbsp;<b>Rang</b>&nbsp;&nbsp;&nbsp;</td>";
        echo "<td>&nbsp;&nbsp;&nbsp;<b>letztes Login</b>&nbsp;&nbsp;&nbsp;</td>";
        echo "</tr>";
        echo "</thead>";
        foreach ($result as $row)
        {
            $row = (object)$row;
            echo "<tr>";
            echo "<td>", $row->$data_username, "</td>";
            echo "<td>", $row->$data_rank, "</td>";
            echo "<td>", $row->$data_lastlogin, "</td>";
            if ($leader != 0)
            {
                if ($row->$data_leader != 0)
                {
                    echo '<td><span class="label label-primary">Leader der Fraktion</span></td>';
                }
                else
                {
                    echo "<td><a href=\"action_uninvite_member.php?action=uninviteMember&userId=" . $row->id . "\"><button type='button' class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-ban-circle'></span> Mitglied entlassen</button></a></td>";
                }
            }
            echo "</tr>";
            echo "</tbody>";
        }
        echo "</table>";
    }
    ?>
<?php
}
?>
</div>
<?php
if (!($faction == 0 && $leader == 0))
{
    ?>
    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
        <br/><br/><br/><br/><br/>

        <div class="list-group">
            <a href="faction.php" class="list-group-item">Allgmein</a>
            <a href="faction_member.php" class="list-group-item active">Mitglieder</a>
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