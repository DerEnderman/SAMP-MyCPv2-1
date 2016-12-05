<?php
$currentPage = "acp_support.php";
include("global.php");
require_admin();
$title = "Supportbereich";
if (!isset($_GET["id"]))
    die();
$ticket = $db->getFirst("SELECT * FROM support_tickets WHERE ticket_id = ?", $_GET["id"]);

if (sizeof($_POST)) {

    if (isset($_POST["toggleClose"])) {
        if ($ticket["status"] == 2) {
            $message = "Admin ". $_SESSION["username"]." hat das Ticket wieder geöffnet.";
            $status = 0;
        }
        else {
            $message = "Admin ".$_SESSION["username"]." hat das Ticket geschlossen.";
            $status = 2;
        }
        $db->query("UPDATE support_tickets SET status = ? WHERE ticket_id = ?", $status, $_GET["id"]);
        $db->add("conversations", array("content" => $message, "author" => $_SESSION["id"], "as_admin" => 1, "conversation" => $ticket["conversation_id"]));
    }
    elseif (isset($_POST["answer"])) {
        $db->query("UPDATE support_tickets SET status = 1 WHERE ticket_id = ?", $_GET["id"]);
        $db->add("conversations", array("content" => $_POST["answer"], "author" => $_SESSION["id"], "as_admin" => 1, "conversation" => $ticket["conversation_id"]));
    }
    $ticket = $db->getFirst("SELECT * FROM support_tickets WHERE ticket_id = ?", $_GET["id"]);
}
$conversation = $db->getAll("SELECT message, time, content, as_admin, !username FROM conversations c JOIN support_tickets s ON s.conversation_id = c.conversation JOIN !accounts a ON c.author = a.!id WHERE ticket_id = ?", $_GET["id"]);
include_once("templates/header_acp.php");
?>
<style>
    .message {
        border: 1px solid black;
        border-radius: 5px;
        overflow: hidden;
        visibility:hidden;
        transform: translate(-100%,-00%);
        -webkit-transform: translate(-100%,-00%);
        margin-bottom:50px
    }
    .user .author {
        float:left;
        border-right: 1px solid black;
        clear:both;
        margin-right:5px;
        padding-left: 5px;
        padding-right:5px;
        color:white;
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.6);
    }
    .admin .inner-message {
        padding-left:5px;
    }
    .admin .author {
        float:right;
        border-left: 1px solid black;
        clear:both;
        margin-left:5px;
        padding-right: 5px;
        padding-left:5px;
        color:white;
        text-shadow: 0 1px 0 rgba(0, 0, 0, 0.6);
    }
    .show {
        visibility: visible;
        transition: 0.5s ease-in-out;
        transform: translate(-0%,-0%);
        -webkit-transform: translate(-0%,-0%);
    }
</style>

<div class="container">
    <?php
    if (!$ticket) {
        showMessage("Das Ticket existiert nicht.", "error");
        die();
    }
    ?>
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
            <p class="pull-right visible-xs">
                <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
            </p>
            <br/>

            <h3>Supportticket: <i><?= $ticket["topic"] ?></i></h3><br/>
            <?php foreach ($conversation as $message) { ?>
                <div class="message <?php if ($message["as_admin"]) echo "admin"; else echo "user"?>">
                    <div class="author navbar-inverse"><?php if ($message["as_admin"]) echo "<b>Admin</b>"?> <?= $message["!username"] ?><br>Gesendet am <?= date("d.m.Y - H:i", strtotime($message["time"]))?></div>
                    <div class="inner-message">
                        <?= nl2br($message["content"]) ?>
                    </div>
                </div>
            <?php } ?>
            <hr>

            <h4>Antworten</h4>
            <form class="form" role="form" method="POST">
                <textarea name="answer" class="form-control" rows="5"></textarea><br>
                <button type="submit" class="btn btn-primary">Absenden</button>
            </form>
            <form  style="float:right;margin-top:-40px" class="form" role="form" method="POST">
                <button name="toggleClose" type="submit" class="btn btn-default">Ticket <?= $ticket["status"] == 2?"öffnen":"schließen"?></button>
            </form>

        </div>
        <!--/span-->
    </div>
    <!--/row-->

<?php include_once("templates/footer_acp.php");
?>    <script>
    var messages = document.getElementsByClassName("message");
    for (var i=0;i<messages.length;i++) {
        var author = messages[i].getElementsByClassName("author")[0];
        var inner = messages[i].getElementsByClassName("inner-message")[0];
        if ($(inner).height() > $(author).height()) {
            $(author).height($(inner).height());
            $(author).height($(inner).height());
            $(author).height($(inner).height());
            $(author).height($(inner).height());
        }
        $(messages[i]).addClass("show");
    }
    <?php if (sizeof($_POST)) echo '$("html, body").animate({ scrollTop: $(document).height() }, "slow");'; ?>
</script>