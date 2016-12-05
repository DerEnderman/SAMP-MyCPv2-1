<?php
$currentPage = "finances.php";
$title = "Finanzen";
include("global.php");
include_once("templates/header_general.php");
require_login();

$config = getConfig();
?>

    <script src="assets/js/bauer_autocomplete.js"></script>
    <!--suppress JSUnresolvedFunction -->
    <script>
        function stepTwo() {
            $("#stepOne").hide(600);
            $("#stepTwo").show(600);
        }
        var isInt = function (n) {
            return parseInt(n) === n
        };
        function stepThree() {
            var two = $("#stepTwo");
            var three = $("#stepThree");
            var amount = two.find("form #amount").val();
            amount = parseInt(amount);
            if (isNaN(amount) || amount == 0) {
                two.find("form #amount").parent().addClass("has-error");
                two.find("form #amount").parent().find("label").text("Betrag (bitte eine natürliche Zahl eingeben)");
                return;
            }
            var target = two.find("form #target").val();
            if (target == "") {
                two.find("form #target").parent().addClass("has-error");

                return;
            }
            var message = two.find('form #message').val();
            three.find("form #amount3").val(amount);
            three.find("form #target3").val(target);
            three.find("form #message3").val(message);
            three.find("#amount3-copy").text(amount);
            three.find('#target3-copy').text(target);
            three.find("#message3-copy").text(message);
            two.hide(300);
            three.show(1000);

        }
    </script>
    <style>
        #autocomplete-data li {
            display: block;
            border: 1px solid blue;
            z-index: /*over */ 9000;
            padding: 3px;
            margin-right: 5px;
        }

        #autocomplete-data li:hover {
            cursor: pointer;
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

<?php
$row = getConfig();
$status_finances = $row['status_finances'];
if ($status_finances != 0)
{
    ?>
    <!-- deactivedfd -->
    <div class="container" id="stepOne">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <br/>

            <h3>Finanzen</h3>
            <br/>

            <div class='alert alert-danger'><strong>Hinweis:</strong> Die Finanz- und Transaktionsfunktionen wurden
                deaktiviert.
            </div>

        </div>
        <!--/span-->

    </div>
<?php
}
else
{

    if (isset($_POST["amount"]) && isset($_POST["target"]) && isset($_POST["message"]))
    {
        $id = $_SESSION["id"];
        $amount = (int)$_POST["amount"];
        if ($amount < 0)
        {
            $error = "Der Betrag muss größer als 0 sein.";
        }
        $message = strip_tags($_POST["message"]);
        $target = strip_tags($_POST["target"]);
        if (empty($target))
        {
            $error = "Du hast vergessen einen Zahlungsempfänger anzugeben!";
        }
        if (!isset($error))
        {
            $target_user = $db->getFirst("SELECT !id as id FROM !accounts WHERE !username = ?", $target);
            $user = $db->getFirst("SELECT !bankmoney as bankmoney FROM !accounts WHERE !id = ?", $id);
            if (!$target_user)
            {
                $error = "Der angegebene Nutzer $target existiert nicht.";
            }
            elseif ($user['bankmoney'] < $amount)
            {
                $error = "Du hast nicht genug Geld dafür!";
            }
            else
            {
                $db->query("UPDATE !accounts SET !bankmoney = !bankmoney - ? WHERE !id = ?", $amount, $id);
                $db->query("UPDATE !accounts SET !bankmoney = !bankmoney + ? WHERE !id = ?", $amount, $target_user["id"]);
                $db->query("INSERT INTO bank_transactions (`from`, `to`, `amount`, `message`) VALUES (?, ?, ?, ?)", $id, $target_user["id"], $amount, $message);
                $success = "Du hast $amount SA$ an $target überwiesen. Als Verwendungszweck wurde $message hinterlegt.";
                user_log("bank_transaction", "$amount SA$ an $target überwiesen.");
            }
        }
    }

    $datum = date("d.m.Y - H:i");

    $id = $_SESSION["id"];
    $user = $db->getFirst("SELECT !bankmoney as bankmoney FROM !accounts WHERE !id = ?", $id);

    $outgoing = $db->getAll("SELECT amount, !username as username FROM bank_transactions b JOIN accounts a ON a.!id = b.to WHERE b.from = ? ORDER BY `date` DESC LIMIT 0,3", $id);
    $incoming = $db->getAll("SELECT amount, !username as username FROM bank_transactions b JOIN accounts a ON a.!id = b.from WHERE b.to = ? ORDER BY `date` DESC LIMIT 0,3", $id);

    if (isset($error))
    {
        echo "<div class='alert alert-danger fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>";
    echo "<strong>Oh Nein!</strong> $error.";
    echo "</div>";
}
if (isset($success))
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schließen</span></button>";
    echo "<strong>Hervorragend!</strong> $success.";
    echo "</div>";
}
?>

    <br/>
    <div class="container" id="stepThree" style="display:none">
        <h1>Bitte bestätigen Sie Ihre Eingaben:</h1>
        <table class="table table-striped">
            <tr>
                <td>Zahlungsempfänger</td>
                <td><b id="target3-copy"></b></td>
            </tr>
            <tr>
                <td>Betrag</td>
                <td><b id="amount3-copy"></b>SA$</td>
            </tr>
            <tr>
                <td>Verwendungszweck</td>
                <td><b id="message3-copy"></b></td>
            </tr>
        </table>
        <form role="form" method="POST">
            <input type="hidden" class="form-control" id="target3" name="target"
                   placeholder="Bitte Benutzernamen eingeben">
            <input type="hidden" class="form-control" id="amount3" name="amount" placeholder="Betrag">
            <input type="hidden" class="form-control" id="message3" name="message" placeholder="Verwendungszweck">

            <div class="form-group">
                <label for="message">Passwort</label>
                <input type="password" class="form-control" name="password"
                       placeholder="Bitte geben Sie zur Bestätigung Ihr Passwort ein!">
            </div>
            <button type="submit" class="btn btn-primary">Abschicken</button>
        </form>
    </div>
    <div class="container" id="stepTwo" style="display:none">
        <h1>Überweisung erstellen</h1>

        <form role="form">
            <div class="form-group">
                <label for="target">Zahlungsempfänger</label>
                <input autocomplete="off" type="text" class="form-control" id="target" name="target"
                       placeholder="Bitte Benutzernamen eingeben">
                <ul id="autocomplete-data" class="autocomplete-data panel-footer"></ul>
            </div>
            <div class="form-group">
                <label for="amount">Betrag</label>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Betrag (in SA$)">
                <span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group">
                <label for="message">Verwendungszweck</label>
                <input type="text" class="form-control" id="message" name="message" placeholder="Verwendungszweck">
            </div>
            <button type="button" onclick="stepThree()" class="btn btn-default">Absenden</button>
        </form>
    </div>
<div class="container" id="stepOne">
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <br/>

            <h3>Finanzen</h3>
            <br/>

            <div align="right"><b>Kontoauszug</b> vom <?= $datum; ?></div>
            <br/>
            <?php
            if (isset($_GET["status"]) && $_GET["status"] == "success")
            {
                echo "<div class='alert alert-success fade in' role='alert'>";
                echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
                echo "<strong>Hervorragend!</strong> Deine Einstellungen wurden erfolgreich aktualisiert.";
                echo "</div>";
            }
            ?>

            <br/>

            <div class="row">
                <div class="col-xs-6 col-md-4">
                    <table>
                        <tr>
                            <td><b>Kontostand</b></td>
                        </tr>
                        <tr>
                            <td><h3><b><?= $user["bankmoney"] ?> SA$</b></h3>
                                <hr/>
                            </td>
                        </tr>
                        <tr>
                            <td><br/>
                                <button type="button" class="btn btn-primary btn-default" onclick="stepTwo()"><span
                                        class="glyphicon glyphicon-credit-card"
                                        aria-hidden="true"></span> Überweisung
                                    erstellen
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="well">
                        <h4><b>Geldeingänge</b> <span class="glyphicon glyphicon-import"
                                                      aria-hidden="true"></span></h4>
                        <hr/>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Absender</th>
                                <th>Betrag</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($incoming as $item)
                            { ?>
                                <tr>
                                <td><?= $item["username"] ?></td>
                                <td><?= $item["amount"] ?>,00 SA$</td>
                                </tr><?php } ?>
                            </tbody>
                        </table>
                        <a href="bank_transactions.php">
                            <button type="button" class="btn btn-default btn-xs">» alle Transaktionen anzeigen</button>
                        </a>
                    </div>
                </div>
                <div class="col-xs-6 col-md-4">
                    <div class="well">
                        <h4><b>Geldausgänge</b> <span class="glyphicon glyphicon-export"
                                                      aria-hidden="true"></span></h4>
                        <hr/>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Empfänger</th>
                                <th>Betrag</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($outgoing as $item)
                            { ?>
                                <tr>
                                <td><?= $item["username"] ?></td>
                                <td><?= $item["amount"] ?>,00 SA$</td>
                                </tr><?php } ?>
                            </tbody>
                        </table>
                        <a href="bank_transactions.php">
                            <button type="button" class="btn btn-default btn-xs">» alle Transaktionen anzeigen</button>
                        </a>
                    </div>
                </div>
            </div>

        </div>
        <!--/span-->

    </div>

    <!--/row-->
<?php } ?>
    <hr/>
    <footer>
        <?php get_footer2(); ?>
    </footer>
    <script>new BauerAutoComplete().addAutocomplete(document.getElementById("target"), document.getElementById("autocomplete-data"))</script>
<?php include_once("templates/footer_general.php");