<?php
$currentPage = "start.php";
include("global.php");
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user = $db->getFirst("SELECT * FROM !accounts WHERE !username = ?", array($username));
} else  {
    redirect("index.php");
    die();
}
$title = "Neuigkeiten";
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
            <?php
            $config = getConfig();
            $login_message = $config['login_message'];
            $status_loginmessage = $config['status_loginmessage'];
            if ($_GET["login"] == 1)
            {
                echo "<div class='alert alert-success fade in' role='alert'>";
                echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
                echo "<strong><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></strong> Herzlich Willkommen, du wurdest erfolgreich eingeloggt!";
                echo "</div>";

                if ($status_loginmessage == 0) {
                    echo "<div class='alert alert-info fade in' role='alert'>";
                    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
                    echo "<strong>Hinweis:</strong> $login_message";
                    echo "</div>";
                }
            }
            ?>
            <br/>

            <h3>Neuigkeiten</h3>
            <br/>
            <?php show_news_inside(); ?>
        </div>
        <!--/span-->

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
            <?php
            $db_config = getConfig();
            $data_skin = $db_config['data_skin'];
            $data_date_of_registration = $db_config['data_date_of_registration'];
            $data_email = $db_config['data_email'];

            $user = $db->getFirst("SELECT !ucp_adminrights, !skin, !date_of_registration, !email FROM !accounts WHERE !id = ?", $_SESSION["id"]);
            $skin = $user["!skin"];
            $date_of_registration = $user[$data_date_of_registration];
            $email = $user[$data_email];

            if ($user["!ucp_adminrights"])
            {
                echo "<div class='well' align='center'>";
                echo "<a href='acp_start.php'><button type='button' class='btn btn-warning'>zum Dashboard wechseln</button></a>";
                echo "</div>";
            }
            ?>
            <div class="thumbnail">
                <h4 align="center"><?php
                    if ($user["!ucp_adminrights"])
                    {
                        echo "<span class='label label-danger'>Administrator</span><br /><br />";
                    } ?><?php get_username(); ?></h4>
                <hr/>
                <?php echo "<img src='assets/images/skins/Skin_" . $skin . ".png' />"; ?><br/>

                <div class="caption">
                    <table>
                        <tr>
                            <td><b>Mitglied seit:&nbsp;</b></td>
                            <td><?php echo $date_of_registration; ?></td>
                        </tr>
                        <tr>
                            <td><b>E-Mail Adresse:&nbsp;</b></td>
                            <td><?php echo $email; ?></td>
                        </tr>
                    </table>
                    <br/>

                    <div class="list-group">
                        <a href="profile.php" class="list-group-item">Profil anzeigen</a>
                        <a href="user_settings.php" class="list-group-item">Einstellungen bearbeiten</a>
                    </div>
                </div>
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