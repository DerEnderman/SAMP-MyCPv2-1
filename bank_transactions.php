<?php
$currentPage = "bank_transactions.php";
include("global.php");
require_once("config.php");
if (isset($_SESSION['username']))
{
    $username = $_SESSION['username'];
    $id = $_SESSION["id"];
}
else
{
    redirect("index.php");
    die();
}
$title = "Kontoauszug";
define("ITEMS_PER_PAGE", 25);

$page = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;
if ($page < 1)
{
    $page = 1;
}
$first = ($page - 1) * ITEMS_PER_PAGE;
$last = $first + ITEMS_PER_PAGE - 1;

$transactions = $db->getAll("SELECT id, `from`, `to`, amount, `date`, message, (SELECT !username FROM !accounts WHERE !id = `from`) as user_from, (SELECT !username FROM !accounts WHERE !id = `to`) as user_to FROM bank_transactions WHERE `from` = ? OR `to` = ? ORDER BY `date` DESC LIMIT $first,$last ", array($id, $id));
$pages = $db->getFirst("SELECT COUNT(*) as pages FROM bank_transactions WHERE `from` = ? OR `to` = ?", array($id, $id));
$pages = ceil($pages["pages"] / ITEMS_PER_PAGE);
include_once("templates/header_general.php");
?>
    <style>
        .big_indicator {
            font-size: 15px;
            font-weight: 900;
        }
    </style>

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
    <a href='finances.php'>
        <button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck
        </button>
    </a>

    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <br/>

            <h3><?= $title ?></h3><br/>

            <?php
            if (!sizeof($transactions))
            {
                echo "<i class='glyphicon glyphicon-warning-sign'></i> Für dich sind keine Kontauszüge verfügbar.";
            }
            else
            {
                ?>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Wertstellung</th>
                        <th>Kontoinhaber</th>
                        <th>Verwendungszweck</th>
                        <th>Betrag</th>
                    </tr>
                    </thead>
                    <tbody> <?php
                    foreach ($transactions as $transaction)
                    {
                        ?>
                        <tr class="<?= $transaction["from"] == $id ? "danger" : "success" ?>">
                            <td><?= date("d.m.Y - H:i", strtotime($transaction["date"])) ?></td>
                            <td><?= $transaction["from"] == $id ? $transaction["user_from"] : $transaction["user_to"] ?></td>
                            <td><?= htmlspecialchars($transaction["message"]) ?></td>
                            <td><span
                                    class="big_indicator"><?= $transaction["from"] == $id ? "-" : "+" ?></span><?= $transaction["amount"] ?>
                                SA$
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                if ($pages > 1)
                {
                    ?>
                    <nav>
                        <ul class="pagination pagination">
                            <li class="<?= ($page - 1 < 1) ? "disabled" : "" ?>"><a
                                    href="bank_transactions.php?page=<?= $page - 1 ?>"><span
                                        aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                            <?php
                            for ($i = 1; $i < $pages; $i++)
                            {
                                $active = ($i == $page) ? "active" : "";
                                echo '<li class="' . $active . '"><a href="bank_transactions.php?page=' . $i . '">' . $i . '</a></li>';
                            } ?>
                            <li class="<?= ($page + 1 >= $pages) ? "disabled" : "" ?>"><a
                                    href="bank_transactions.php?page=<?= $page + 1 ?>"><span
                                        aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                        </ul>
                    </nav>
                <?php
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