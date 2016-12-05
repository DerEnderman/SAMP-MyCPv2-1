<?php
$currentPage = "acp_finances.php";
include("global.php");

require_admin();
$title = "Finanzen";
include_once("templates/header_acp.php");

define("ITEMS_PER_PAGE", 25);

$page = (isset($_GET["page"])) ? (int)$_GET["page"] : 1;
if ($page < 1)
{
    $page = 1;
}
$first = ($page - 1) * ITEMS_PER_PAGE;
$last = $first + ITEMS_PER_PAGE - 1;

$transactions = $db->getAll("SELECT id, `from`, `to`, amount, `date`, message, (SELECT !username FROM !accounts WHERE !id = `from`) as user_from, (SELECT !username FROM !accounts WHERE !id = `to`) as user_to FROM bank_transactions  ORDER BY `date` DESC LIMIT $first,$last ");
$pages = $db->getFirst("SELECT COUNT(*) as pages FROM bank_transactions");
$pages = ceil($pages["pages"] / ITEMS_PER_PAGE);
?>
    <style>
        .big_indicator {
            font-size: 15px;
            font-weight: 900;
        }
    </style>
<div class="container">

    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">

            <?php
            if (!sizeof($transactions))
            {
                echo "<i class='glyphicon glyphicon-warning-sign'></i> Es wurde noch nichts überwiesen.";
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

<?php include_once("templates/footer_acp.php");