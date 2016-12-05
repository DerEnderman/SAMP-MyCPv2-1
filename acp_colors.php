<?php
$currentPage = "acp_colors.php";
include_once("global.php");

require_admin();
$title = "Farbschema anpassen";
include_once("templates/header_acp.php");
if (sizeof($_POST))
{
    $color[0]["r"] = (int)$_POST["r"];
    $color[0]["g"] = (int)$_POST["g"];
    $color[0]["b"] = (int)$_POST["b"];
    foreach ($color[0] as $key =>  $col) {
        if ($col > 255)
            $col = 255;
        if ($col < 0)
            $col = 0;
        $color[1][$key] = round($col * 1.25);
        $color[2][$key] = round($col * 1.75);
        $color[3][$key] = round($col * 0.20);
    }
    $template = file_get_contents("assets/css/bootstrap.min.css.template");
    $template = str_replace("__COLOR_BASE__", "rgb(".$color[0]["r"].",".$color[0]["g"].",".$color[0]["b"].")" , $template);
    $template = str_replace("__COLOR_DARKER__", "rgb(".$color[1]["r"].",".$color[1]["g"].",".$color[1]["b"].")" , $template);
    $template = str_replace("__COLOR_DARK__", "rgb(".$color[2]["r"].",".$color[2]["g"].",".$color[2]["b"].")" , $template);
    $template = str_replace("__COLOR_LIGHT__", "rgb(".$color[3]["r"].",".$color[3]["g"].",".$color[3]["b"].")" , $template);
    file_put_contents("assets/css/bootstrap.min.css", $template);
    $colorString = "rgb(".$color[0]["r"].",".$color[0]["g"].",".$color[0]["b"].")";
    saveConfig(array("color"=> $colorString));
}
$color = getConfig("color");
if (!is_writable("assets/css/bootstrap.min.css"))
    showMessage("myCP hat keine Schreibrechte auf den Ordner assets/css. Das Farbschema kann nicht verändert werden.");
?>
<script src="assets/js/spectrum.js"></script>
<link type="text/css" rel="stylesheet" href="assets/css/spectrum.css">

    <br/><p>Hier kannst du mit einem Klick das Farbschema im Benutzerbereich von myCP verändern,
    wähle einfach eine Farbe, und das Schema wird automatisch generiert und verwendet.</p>
    <form method="POST" id="colorform">
    <input type="hidden" name="r">
    <input name="g" type="hidden">
    <input name="b" type="hidden">
    <input name="color" id="colors" type="text">
</form>
    <script>
        $("input#colors").spectrum({
            color: "<?= $color == null?"rgb(10,10,200)":$color ?>",
            flat: true,
            showInput: true,
            preferredFormat: "hex",
            chooseText: "Übernehmen",
            cancelText: "Zurücksetzen",
            showPalette: true,
            palette: [
                ['#333', '#555', '#777'],
                ['#337ab7', '#5cb85c', '#5bc0de'],
                ['#f0ad4e', '#d9534f', '#555']
            ],
            change: function(color) {
                document.getElementsByName("r")[0].value = color._r;
                document.getElementsByName("g")[0].value = color._g;
                document.getElementsByName("b")[0].value = color._b;
                document.getElementById("colorform").submit();
            }
        });
    </script>
<?php include_once("templates/footer_acp.php");