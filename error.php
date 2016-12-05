<?php
include("global.php");
$currentPage = "error.php";

$row = getConfig();
$login_background = $row['login_background'];

$title = "Fehler";
include_once("templates/header_general.php");
?>
    <style>
        body {
            background-image: url(<?= htmlspecialchars($login_background) ?>);
            no-repeat fixed !important;
        }
    </style>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">

            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand"><?php get_projectname(); ?><br/>
                        <small><?php get_projectdescription(); ?></small>
                    </h3>
                    <?php include("navigation/nav_3.php"); ?>
                </div>
            </div>

            <div class="inner cover">
                <?php
                if (htmlspecialchars($_GET["errorid"]) == 0)
                {
                    echo "<div class='alert alert-error'>";
                    echo "Scheinbar hast du versucht manuell die 'error.php' anzuw&auml;hlen.";
                    echo "<br /> Diese Seite gibt jedoch lediglich Fehlermeldungen aus und ist dir also nutzlos.";
                    echo "</div>";
                }
                else
                {
                    if (htmlspecialchars($_GET["errorid"]) == 1)
                    {
                        echo "<div class='alert alert-error'>";
                        echo "Diese Seite ist nur f&uuml;r Administratoren zug&auml;nglich.";
                        echo "</div>";
                    }
                    else
                    {
                        if (htmlspecialchars($_GET["errorid"]) == 3)
                        {
                            echo "<div class='alert alert-error'>";
                            echo "Diese Seite ist nur f&uuml;r Leader einer Fraktion zug&auml;nglich.";
                            echo "</div>";
                        }
                        else
                        {
                            if (htmlspecialchars($_GET["errorid"]) > 1)
                            {
                                echo "<div class='alert alert-error'>";
                                echo "Der Fehlercode (" . htmlspecialchars($_GET["errorid"]) . ") ist dem System nicht bekannt. Und kann folglich auch nicht richtig zugeordnet werden.";
                                echo "</div>";
                            }
                        }
                    }
                }
                ?>
            </div>

            <div class="mastfoot">
                <div class="inner">
                    <?php get_footer3(); ?>
                </div>
            </div>
        </div>
    </div>
<?php include_once("templates/footer_general.php");