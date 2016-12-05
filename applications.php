<?php
$currentPage = "applications.php";
include("global.php");
require_once("config.php");
require_login();
$title = "Bewerbungen";
include_once("templates/header_general.php");

$username = $_SESSION["username"];
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
if (htmlspecialchars($_GET["status"]) == 1) //success for cancel the faction application
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Deine Fraktions-Bewerbung wurde erfolgreich zur&uuml;ckgezogen.";
    echo "</div>";
}
if (htmlspecialchars($_GET["status"]) == 2) //success for cancel the leader application
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Deine Leader-Bewerbung wurde erfolgreich zur&uuml;ckgezogen.";
    echo "</div>";
}
if (htmlspecialchars($_GET["status"]) == 3) //success for cancel the supporter application
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Deine Supporter-Bewerbung wurde erfolgreich zur&uuml;ckgezogen.";
    echo "</div>";
}

if (htmlspecialchars($_GET["status"]) == 4) //success for post the faction application
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Deine Fraktions-Bewerbung wurde erfolgreich erstellt.";
    echo "</div>";
}
if (htmlspecialchars($_GET["status"]) == 5) //success for post the leader application
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Deine Leader-Bewerbung wurde erfolgreich erstellt.";
    echo "</div>";
}
if (htmlspecialchars($_GET["status"]) == 6) //success for post the supporter application
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Hinweis:</strong> Deine Supporter-Bewerbung wurde erfolgreich erstellt.";
    echo "</div>";
}
$row = getConfig();
$status_leader_application = $row['status_leader_application'];
$status_supporter_application = $row['status_supporter_application'];

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

?>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#faction_application" data-toggle="tab"><span
                class="glyphicon glyphicon-list-alt"></span> Fraktions-Bewerbung</a></li>
    <li><a href="#leader_application" data-toggle="tab"><span class="glyphicon glyphicon-briefcase"></span>
            Leader-Bewerbung</a></li>
    <li><a href="#supporter_application" data-toggle="tab"><span class="glyphicon glyphicon-flag"></span>
            Supporter-Bewerbung</a></li>
    <?php
    $row = getConfig();
    $data_faction = $row['data_faction'];
    $data_leader = $row['data_leader'];

    $data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");
    $user_faction = $data2[$data_faction];
    $user_leader = $data2[$data_leader];

    ?>
</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane fade in active" id="faction_application"><br/>
<?php
if ($user_faction != 0)
{
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<strong>Hinweis:</strong> Du befindest dich derzeit schon in einer und kannst dich erst nach einem Austritt neu bewerben.";
    echo "</div>";
}
else
{
    $data2 = $db->getFirst("SELECT * FROM faction_applications WHERE creator = '$username'");
    $status = $data2['status'];
    $faction = $data2['faction'];
    $faction_application_text = nl2br($data2['application_text']);

    if ($status != 0)
    {
        if ($status == 1)
        {
            echo "<h4><b>Status:</b> Die Bewerbung wird von einem Leader gepr&uuml;ft.</h4>";
            if ($faction == 1)
            {
                echo "<h4><b>Fraktion:</b> $faction_1</h4>";
            }
            else if ($faction == 2)
            {
                echo "<h4><b>Fraktion:</b> $faction_2</h4>";
            }
            else if ($faction == 3)
            {
                echo "<h4><b>Fraktion:</b> $faction_3</h4>";
            }
            else if ($faction == 4)
            {
                echo "<h4><b>Fraktion:</b> $faction_4</h4>";
            }
            else if ($faction == 5)
            {
                echo "<h4><b>Fraktion:</b> $faction_5</h4>";
            }
            else if ($faction == 6)
            {
                echo "<h4><b>Fraktion:</b> $faction_6</h4>";
            }
            else if ($faction == 7)
            {
                echo "<h4><b>Fraktion:</b> $faction_7</h4>";
            }
            else if ($faction == 8)
            {
                echo "<h4><b>Fraktion:</b> $faction_8</h4>";
            }
            else if ($faction == 9)
            {
                echo "<h4><b>Fraktion:</b> $faction_9</h4>";
            }
            else if ($faction == 10)
            {
                echo "<h4><b>Fraktion:</b> $faction_10</h4>";
            }
            else if ($faction == 11)
            {
                echo "<h4><b>Fraktion:</b> $faction_11</h4>";
            }
            else
            {
                if ($faction == 12)
                {
                    echo "<h4><b>Fraktion:</b> $faction_12</h4>";
                }
                else
                {
                    if ($faction == 13)
                    {
                        echo "<h4><b>Fraktion:</b> $faction_13</h4>";
                    }
                    else
                    {
                        if ($faction == 14)
                        {
                            echo "<h4><b>Fraktion:</b> $faction_14</h4>";
                        }
                        else
                        {
                            if ($faction == 15)
                            {
                                echo "<h4><b>Fraktion:</b> $faction_15</h4>";
                            }
                            else
                            {
                                if ($faction == 16)
                                {
                                    echo "<h4><b>Fraktion:</b> $faction_16</h4>";
                                }
                                else
                                {
                                    if ($faction == 17)
                                    {
                                        echo "<h4><b>Fraktion:</b> $faction_17</h4>";
                                    }
                                    else
                                    {
                                        if ($faction == 18)
                                        {
                                            echo "<h4><b>Fraktion:</b> $faction_18</h4>";
                                        }
                                        else
                                        {
                                            if ($faction == 19)
                                            {
                                                echo "<h4><b>Fraktion:</b> $faction_19</h4>";
                                            }
                                            else
                                            {
                                                if ($faction == 20)
                                                {
                                                    echo "<h4><b>Fraktion:</b> $faction_20</h4>";
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
            echo "<form class='form-signin' role='form' action='action_cancel_faction_application.php' method='post'>";
            echo "<p align='right'><input type='submit' name='submit' class='btn btn-danger' value='Bewerbung zur&uuml;ckziehen'/></p>Deine Bewerbung:";
            echo "<div class='well'>";
            echo $faction_application_text;
            echo "</div>";
            echo "</form>";
        }
        else if ($status == 2)
        {
            echo "<form class='form-signin' role='form' action='action_accept_faction_reject.php' method='post'>";
            echo "<div class='alert alert-danger' role='alert'>";
            echo "<strong>Schade!</strong> Leider konnte deine Bewerbung nicht &uuml;berzeugen und wurde daher vom Leader <b>abgelehnt</b>.";
            echo "<br /><br /><p align='center'><input type='submit' name='submit' class='btn btn-danger' value='Ok'/>&nbsp;&nbsp;<input type='submit' name='submit' class='btn btn-default' value='erneut bewerben'/></p>";
            echo "</div>";
            echo "</form>";
        }
    }
    else
    {
        ?>
        <form class="form-signin" role="form" action="action_post_faction_application.php" method="post">
            <select class="form-control" name="selected_faction" size="1">
                <?php
                if (!empty($faction_1))
                {
                    echo "<option value='1' selected> $faction_1 </option>";
                }
                if (!empty($faction_2))
                {
                    echo "<option value='2'> $faction_2 </option>";
                }
                if (!empty($faction_3))
                {
                    echo "<option value='3'> $faction_3 </option>";
                }
                if (!empty($faction_4))
                {
                    echo "<option value='4'> $faction_4 </option>";
                }
                if (!empty($faction_5))
                {
                    echo "<option value='5'> $faction_5 </option>";
                }
                if (!empty($faction_6))
                {
                    echo "<option value='6'> $faction_6 </option>";
                }
                if (!empty($faction_7))
                {
                    echo "<option value='7'> $faction_7 </option>";
                }
                if (!empty($faction_8))
                {
                    echo "<option value='8'> $faction_8 </option>";
                }
                if (!empty($faction_9))
                {
                    echo "<option value='9'> $faction_9 </option>";
                }
                if (!empty($faction_10))
                {
                    echo "<option value='10'> $faction_10 </option>";
                }
                if (!empty($faction_11))
                {
                    echo "<option value='11'> $faction_11 </option>";
                }
                if (!empty($faction_12))
                {
                    echo "<option value='12'> $faction_12 </option>";
                }
                if (!empty($faction_13))
                {
                    echo "<option value='13'> $faction_13 </option>";
                }
                if (!empty($faction_14))
                {
                    echo "<option value='14'> $faction_14 </option>";
                }
                if (!empty($faction_15))
                {
                    echo "<option value='15'> $faction_15 </option>";
                }
                if (!empty($faction_16))
                {
                    echo "<option value='16'> $faction_16 </option>";
                }
                if (!empty($faction_17))
                {
                    echo "<option value='17'> $faction_17 </option>";
                }
                if (!empty($faction_18))
                {
                    echo "<option value='18'> $faction_18 </option>";
                }
                if (!empty($faction_19))
                {
                    echo "<option value='19'> $faction_19 </option>";
                }
                if (!empty($faction_20))
                {
                    echo "<option value='20'> $faction_20 </option>";
                }
                ?>
            </select> <br/>
            <textarea name="application_text" class="form-control" rows="12" placeholder="Bewerbungstext"
                      required></textarea> <br/>
            <input type="submit" name="submit" class="btn btn-primary" value="Abschicken"/>
        </form>
    <?php
    }
}
?>
</div>
<div class="tab-pane fade" id="leader_application"><br/>
<?php
if ($status_leader_application != 1)
{
    $data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");
    $user_leader = $data2[$data_leader];

    if ($user_leader != 0)
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<strong>Hinweis:</strong> Du bist bereits Leader einer Fraktion, und kannst dich erst nach einer K&uuml;ndigung neu bewerben.";
        echo "</div>";
    }
    else
    {
        $data2 = $db->getFirst("SELECT * FROM leader_applications WHERE creator = '$username'");

        $leader_status = $data2['status'];
        $leader_faction = $data2['faction'];
        $leader_application_text = nl2br($data2['application_text']);

        if ($leader_status != 0)
        {
            if ($leader_status == 1)
            {
                echo "<h4><b>Status:</b> Die Bewerbung wird von einem Administrator gepr&uuml;ft.</h4>";
                if ($leader_faction == 1)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_1</h4>";
                }
                else if ($leader_faction == 2)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_2</h4>";
                }
                else if ($leader_faction == 3)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_3</h4>";
                }
                else if ($leader_faction == 4)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_4</h4>";
                }
                else if ($leader_faction == 5)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_5</h4>";
                }
                else if ($leader_faction == 6)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_6</h4>";
                }
                else if ($leader_faction == 7)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_7</h4>";
                }
                else if ($leader_faction == 8)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_8</h4>";
                }
                else if ($leader_faction == 9)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_9</h4>";
                }
                else if ($leader_faction == 10)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_10</h4>";
                }
                else if ($leader_faction == 11)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_11</h4>";
                }
                else if ($leader_faction == 12)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_12</h4>";
                }
                else if ($leader_faction == 13)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_13</h4>";
                }
                else if ($leader_faction == 14)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_14</h4>";
                }
                else if ($leader_faction == 15)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_15</h4>";
                }
                else if ($leader_faction == 16)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_16</h4>";
                }
                else if ($leader_faction == 17)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_17</h4>";
                }
                else if ($leader_faction == 18)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_18</h4>";
                }
                else if ($leader_faction == 19)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_19</h4>";
                }
                else if ($leader_faction == 20)
                {
                    echo "<h4><b>Leaderposten der Fraktion:</b> $faction_20</h4>";
                }
                echo "<form class='form-signin' role='form' action='action_cancel_leader_application.php' method='post'>";
                echo "<p align='right'><input type='submit' name='submit' class='btn btn-danger' value='Bewerbung zur&uuml;ckziehen'/></p>Deine Bewerbung:";
                echo "<div class='well'>";
                echo $leader_application_text;
                echo "</div>";
                echo "</form>";
            }
            else if ($leader_status == 2)
            {
                echo "<form class='form-signin' role='form' action='action_accept_leader_reject.php' method='post'>";
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<strong>Schade!</strong> Leider konnte deine Bewerbung nicht &uuml;berzeugen und wurde daher vom Administrator <b>abgelehnt</b>.";
                echo "<br /><br /><p align='center'><input type='submit' name='submit' class='btn btn-danger' value='Ok'/>&nbsp;&nbsp;<input type='submit' name='submit' class='btn btn-default' value='erneut bewerben'/></p>";
                echo "</div>";
                echo "</form>";
            }
        }
        else
        {
            ?>
            <form class="form-signin" role="form" action="action_post_leader_application.php" method="post">
                <select class="form-control" name="selected_faction" size="1">
                    <?php
                    if (!empty($faction_1))
                    {
                        echo "<option value='1' selected> Leaderposten: $faction_1 </option>";
                    }
                    if (!empty($faction_2))
                    {
                        echo "<option value='2'> Leaderposten: $faction_2 </option>";
                    }
                    if (!empty($faction_3))
                    {
                        echo "<option value='3'> Leaderposten: $faction_3 </option>";
                    }
                    if (!empty($faction_4))
                    {
                        echo "<option value='4'> Leaderposten: $faction_4 </option>";
                    }
                    if (!empty($faction_5))
                    {
                        echo "<option value='5'> Leaderposten: $faction_5 </option>";
                    }
                    if (!empty($faction_6))
                    {
                        echo "<option value='6'> Leaderposten: $faction_6 </option>";
                    }
                    if (!empty($faction_7))
                    {
                        echo "<option value='7'> Leaderposten: $faction_7 </option>";
                    }
                    if (!empty($faction_8))
                    {
                        echo "<option value='8'> Leaderposten: $faction_8 </option>";
                    }
                    if (!empty($faction_9))
                    {
                        echo "<option value='9'> Leaderposten: $faction_9 </option>";
                    }
                    if (!empty($faction_10))
                    {
                        echo "<option value='10'> Leaderposten: $faction_10 </option>";
                    }
                    if (!empty($faction_11))
                    {
                        echo "<option value='11'> Leaderposten: $faction_11 </option>";
                    }
                    if (!empty($faction_12))
                    {
                        echo "<option value='12'> Leaderposten: $faction_12 </option>";
                    }
                    if (!empty($faction_13))
                    {
                        echo "<option value='13'> Leaderposten: $faction_13 </option>";
                    }
                    if (!empty($faction_14))
                    {
                        echo "<option value='14'> Leaderposten: $faction_14 </option>";
                    }
                    if (!empty($faction_15))
                    {
                        echo "<option value='15'> Leaderposten: $faction_15 </option>";
                    }
                    if (!empty($faction_16))
                    {
                        echo "<option value='16'> Leaderposten: $faction_16 </option>";
                    }
                    if (!empty($faction_17))
                    {
                        echo "<option value='17'> Leaderposten: $faction_17 </option>";
                    }
                    if (!empty($faction_18))
                    {
                        echo "<option value='18'> Leaderposten: $faction_18 </option>";
                    }
                    if (!empty($faction_19))
                    {
                        echo "<option value='19'> Leaderposten: $faction_19 </option>";
                    }
                    if (!empty($faction_20))
                    {
                        echo "<option value='20'> Leaderposten: $faction_20 </option>";
                    }
                    ?>
                </select> <br/>
                <textarea name="application_text" class="form-control" rows="12" placeholder="Bewerbungstext"
                          required></textarea> <br/>
                <input type="submit" name="submit" class="btn btn-primary" value="Abschicken"/>
            </form>
        <?php
        }
    }
    ?>
<?php
}
else
{
    echo "<div class='alert alert-danger' role='alert'>";
    echo "<strong>Hinweis:</strong> Zurzeit werden keine Leader gesucht.";
    echo "</div>";
}
?>
</div>
<div class="tab-pane fade" id="supporter_application"><br/>
    <?php
    if ($status_supporter_application != 1)
    {
        $data2 = $db->getFirst("SELECT * FROM supporter_applications WHERE creator = '$username'");

        $supporter_status = $data2['status'];
        $supporter_faction = $data2['faction'];
        $supporter_application_text = nl2br($data2['application_text']);

        if ($supporter_status != 0)
        {
            if ($supporter_status == 1)
            {
                echo "<h4><b>Status:</b> Die Bewerbung wird von einem Administrator gepr&uuml;ft.</h4>";
                echo "<form class='form-signin' role='form' action='action_cancel_supporter_application.php' method='post'>";
                echo "<p align='right'><input type='submit' name='submit' class='btn btn-danger' value='Bewerbung zur&uuml;ckziehen'/></p>Deine Bewerbung:";
                echo "<div class='well'>";
                echo $supporter_application_text;
                echo "</div>";
                echo "</form>";
            }
            else if ($supporter_status == 2)
            {
                echo "<form class='form-signin' role='form' action='action_accept_supporter_reject.php' method='post'>";
                echo "<div class='alert alert-danger' role='alert'>";
                echo "<strong>Schade!</strong> Leider konnte deine Bewerbung nicht &uuml;berzeugen und wurde daher vom Administrator <b>abgelehnt</b>.";
                echo "<br /><br /><p align='center'><input type='submit' name='submit' class='btn btn-danger' value='Ok'/>&nbsp;&nbsp;<input type='submit' name='submit' class='btn btn-default' value='erneut bewerben'/></p>";
                echo "</div>";
                echo "</form>";
            }
        }
        else
        {
            ?>
            <form class="form-signin" role="form" action="action_post_supporter_application.php" method="post">
                <textarea name="application_text" class="form-control" rows="12" placeholder="Bewerbungstext"
                          required></textarea> <br/>
                <input type="submit" name="submit" class="btn btn-primary" value="Abschicken"/>
            </form>
        <?php
        }
        ?>
    <?php
    }
    else
    {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "<strong>Hinweis:</strong> Zurzeit werden keine Supporter gesucht.";
        echo "</div>";
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
<!--/span-->
</div>
<!--/row-->

<hr/>
<footer>
    <?php get_footer2(); ?>
</footer>
<?php include_once("templates/footer_general.php");