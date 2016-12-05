<?php
$currentPage = "profile.php";
include("global.php");

require_once("config.php");


if (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];

    $db_config = getConfig();
    $user = $db->getFirst("SELECT * FROM !accounts WHERE !username = ?", array($username));
    if (!$user)
    {
        die("<h1>Fehler: Datenbankkonfiguration inkorrekt.</h1>");
    }
}
else
{
    redirect("index.php");
    die();
}
$title = "Profil";
include_once("templates/header_general.php");
$factions = $db->getFirst("SELECT * FROM factions");

if ($user[$db_config["data_faction"]])
{
    $faction = $factions["faction_" . $user[$db_config["data_faction"]]];
}
else
{
    $faction = ICON_NO;
}
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

<h3>Profil</h3><br/>

<div class="col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-eye-open"></span> Aussehen</h3>
        </div>
        <div class="panel-body" align="center">
            <?php echo "<img src='assets/images/skins/Skin_" . $user[$db_config["data_skin"]] . ".png' />"; ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-lock"></span> Berufsleben</h3>
        </div>
        <div class="panel-body">
            <table>
                <tr>
                    <td><b>Fraktion:&nbsp;</b></td>
                    <td>
                        <?= $faction ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Rang:&nbsp;</b></td>
                    <td>
                        <?php
                        if ($leader || $user[$db_config["data_faction"]] != 0)
                        {
                            echo $user[$db_config["data_rank"]];
                        }
                        else
                        {
                            echo ICON_NO;
                        }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Leader:&nbsp;</b></td>
                    <td>
                        <?php
                        if ($user[$db_config["data_leader"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            echo ICON_OK;
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Nebenjob:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_job"]])
                        {
                            echo ICON_OK;
                        }
                        else
                        {
                            echo ICON_NO;
                        } ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /.col-sm-4 -->
<div class="col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-asterisk"></span> Allgemein</h3>
        </div>
        <div class="panel-body">
            <table>
                <tr>
                    <td><b>Nickname:&nbsp;</b></td>
                    <td><?php get_username(); ?></td>
                </tr>
                <tr>
                    <td><b>Level:&nbsp;</b></td>
                    <td><?php echo $user[$db_config["data_level"]]; ?></td>
                </tr>
                <tr>
                    <td><b>Alter:&nbsp;</b></td>
                    <td><?php echo $user[$db_config["data_age"]]; ?></td>
                </tr>
                <tr>
                    <td><b>Geschlecht:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_sex"]] == 1)
                        {
                            echo "m&auml;nnlich";
                        }
                        else
                        {
                            if ($user[$db_config["data_sex"]] == 2)
                            {
                                echo "weiblich";
                            }
                        } ?></td>
                </tr>
                <tr>
                    <td><b>Respektpunkte:&nbsp;</b></td>
                    <td><?php echo $user[$db_config["data_respect"]]; ?></td>
                </tr>
                <tr>
                    <td><b>Wanteds:&nbsp;</b></td>
                    <td><?php echo $user[$db_config["data_wanteds"]]; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-usd"></span> Finanzen</h3>
        </div>
        <div class="panel-body">
            <table>
                <tr>
                    <td><b>Kontostand:&nbsp;</b></td>
                    <td><?= $user[$db_config["data_bankmoney"]] . " SA$" ?></td>
                </tr>
                <tr>
                    <td><b>Bargeld:&nbsp;</b></td>
                    <td><?= $user[$db_config["data_cashmoney"]] . " SA$" ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /.col-sm-4 -->
<div class="col-sm-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-credit-card"></span> Lizenzen</h3>
        </div>
        <div class="panel-body">
            <table>
                <?php if (isset($db_config["data_passport"]) && !empty($db_config["data_passport"])) { ?>
                <tr>
                    <td><b>Ausweis&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_passport"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            if ($user[$db_config["data_passport"]] == 1)
                            {
                                echo ICON_OK;
                            }
                        } ?></td>
                </tr>
                <?php }?>
                <tr>
                    <td><b>Autof&uuml;hrerschein:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_car_license"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            if ($user[$db_config["data_car_license"]] == 1)
                            {
                                echo ICON_OK;
                            }
                        } ?></td>
                </tr>
                <tr>
                    <td><b>Flugschein:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_plane_license"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            if ($user[$db_config["data_plane_license"]] == 1)
                            {
                                echo ICON_OK;
                            }
                        } ?></td>
                </tr>
                <tr>
                    <td><b>Bootsschein:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_boat_license"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            if ($user[$db_config["data_boat_license"]] == 1)
                            {
                                echo ICON_OK;
                            }
                        } ?></td>
                </tr>
                <?php if (isset($db_config["data_LKW_license"]) && !empty($db_config["data_LKW_license"])) { ?>
                <tr>
                    <td><b>LKW-F&uuml;hrerschein:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_LKW_license"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            if ($user[$db_config["data_LKW_license"]] == 1)
                            {
                                echo ICON_OK;
                            }
                        } ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td><b>Motorradf&uuml;hrerschein:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_bike_license"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            echo ICON_OK;
                        } ?></td>
                </tr>
                <tr>
                    <td><b>Waffenschein:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_weapon_license"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            echo ICON_OK;
                        } ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><span class="glyphicon glyphicon-home"></span> Besitzt&uuml;mer</h3>
        </div>
        <div class="panel-body">
            <table>
                <?php if (isset($db_config["data_house"]) && !empty($db_config["data_house"])) { ?>
                <tr>
                    <td><b>Haus:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_house"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            echo ICON_OK;
                        } ?></td>
                </tr><?php } ?>
                <?php if (isset($db_config["data_business"]) && !empty($db_config["data_business"])) { ?>
                <tr>
                    <td><b>Unternehmen:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_business"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            echo ICON_OK;
                        } ?></td>
                </tr><?php } ?>
                <?php if (isset($db_config["data_donatorrank"]) && !empty($db_config["data_donatorrank"])) { ?>
                <tr>
                    <td><b>Premium-Rang:&nbsp;</b></td>
                    <td><?php if ($user[$db_config["data_donatorrank"]] == 0)
                        {
                            echo ICON_NO;
                        }
                        else
                        {
                            echo ICON_OK;
                        } ?></td>
                </tr><?php } ?>
                <?php if (isset($db_config["data_coins"]) && !empty($db_config["data_coins"])) { ?>
                <tr>
                    <td><b>Premium-Guthaben:&nbsp;</b></td>
                    <td><?php echo $user[$db_config["data_coins"]]; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<!-- /.col-sm-4 -->
</div>
<!--/span-->

<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <br/><br/><br/>

    <div class="list-group">
        <a href="profile.php" class="list-group-item active">Profil</a>
        <a href="user_settings.php" class="list-group-item">allgemeine Einstellungen</a>
        <a href="user_ts_settings.php" class="list-group-item">TeamSpeak Einstellungen</a>
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