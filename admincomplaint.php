<?php
$currentPage = "acp_complaints.php";
include("global.php");
require_once("config.php");
include_once("templates/header_acp.php");
require_admin();
$title = "Beschwerden";


if ($_GET["complaint_status"] == "success") {
    showMessage('Das Supportticket wurde erfolgreich beantwortet.', 'success'); 
}
if (isset($_GET["show_complaint"])) {
    $selected_object = $_SESSION["complaint_id"];

    $query2 = $db->getFirst("SELECT * FROM complaints WHERE id = ?", $selected_object);
    $id = $query2['id'];
    $date_of_creation = $query2['date_of_creation'];
    $creator = $query2['creator'];
    $perpetrator = $query2['perpetrator'];
    $case = $query2['case'];
    $status = $query2['status'];
    $screen_1 = $query2['screen_1'];
    $screen_2 = $query2['screen_2'];
    $screen_3 = $query2['screen_3'];

    if ($status == 0) {
        $current_status = "unbearbeitet";
    } else if ($status == 1) {
        $current_status = "bearbeitet";
    } else if ($status == 2) {
        $current_status = "abgeschlossen";
    }

    echo "<table>";
    echo "<tr>";
    echo "<td><a href='acp_complaints.php'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck</button></a>&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($status != 2) {
        echo "<a href='action_admin_close_complaint.php?action=closeComplaint&complaintId=$selected_object'><button type='button' class='btn btn-danger'>Schlie&szlig;en</button></a></td>";
    }
    echo "</tr>";
    echo "</table> <br /><br />";
    echo "<div class='panel panel-default'>";
    echo "<div class='panel-heading'>";
    echo "<h6 id='size'><b>Beschwerden-ID:</b> $id &nbsp;&nbsp;&nbsp;&nbsp; <b>Opfer:</b> $creator &nbsp;&nbsp;&nbsp;&nbsp; <b>Beschuldigter:</b> $perpetrator &nbsp;&nbsp;&nbsp;&nbsp; <b>Vergehen:</b> $case &nbsp;&nbsp;&nbsp;&nbsp; <b>Status:</b> $current_status </h6>";
    echo "</div>";
    echo "<div class='panel-body'>";
    show_complaint($selected_object);
    echo "</div>";
    echo "</div>";


    echo "<img src='$screen_1' alt='Anzeigefehler: Der Screenshot konnte nicht geladen werden.' class='img-thumbnail' width='300px' height='50' data-toggle='modal' data-target='#modal-1' style='cursor: pointer;' title='Screenshot vergr&ouml;&szlig;ern'>";
    if (!empty($screen_2)) {
        echo "<img src='$screen_2' alt='Anzeigefehler: Der Screenshot konnte nicht geladen werden.' class='img-thumbnail' width='300px' height='50' data-toggle='modal' data-target='#modal-2' style='cursor: pointer;' title='Screenshot vergr&ouml;&szlig;ern'>";
    }
    if (!empty($screen_3)) {
        echo "<img src='$screen_3' alt='Anzeigefehler: Der Screenshot konnte nicht geladen werden.' class='img-thumbnail' width='300px' height='50' data-toggle='modal' data-target='#modal-3' style='cursor: pointer;' title='Screenshot vergr&ouml;&szlig;ern'>";
    }


}
?>
    <div class="modal fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Schlie�en</span></button>
                    <h4 class="modal-title" id="ModalLabel">Screenshot 1 - vergr&ouml;&szlig;ert</h4>
                </div>
                <div class="modal-body">
                    <?php echo "<img src='$screen_1' alt='Anzeigefehler: Der Screenshot konnte nicht geladen werden.' class='img-thumbnail'>"; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo $screen_1; ?>" target="_blank">
                        <button type="button" class="btn btn-warning">Quelle &ouml;ffnen</button>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Schlie&szlig;en</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="modal-2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Schlie�en</span></button>
                    <h4 class="modal-title" id="ModalLabel">Screenshot 2 - vergr&ouml;&szlig;ert</h4>
                </div>
                <div class="modal-body">
                    <?php echo "<img src='$screen_2' alt='Anzeigefehler: Der Screenshot konnte nicht geladen werden.' class='img-thumbnail'>"; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo $screen_2; ?>" target="_blank">
                        <button type="button" class="btn btn-warning">Quelle &ouml;ffnen</button>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Schlie&szlig;en</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="modal-3" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Schlie�en</span></button>
                    <h4 class="modal-title" id="ModalLabel">Screenshot 3 - vergr&ouml;&szlig;ert</h4>
                </div>
                <div class="modal-body">
                    <?php echo "<img src='$screen_3' alt='Anzeigefehler: Der Screenshot konnte nicht geladen werden.' class='img-thumbnail'>"; ?>
                </div>
                <div class="modal-footer">
                    <a href="<?php echo $screen_3; ?>" target="_blank">
                        <button type="button" class="btn btn-warning">Quelle &ouml;ffnen</button>
                    </a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Schlie&szlig;en</button>
                </div>
            </div>
        </div>
    </div>
<?php include_once("templates/footer_acp.php");