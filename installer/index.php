<?php
include_once("global.php");
session_start();
define("LAST_STEP", 6);
define("BASEDIR", __DIR__);
$installVersion = "2.0";
$step = 0;
if (isset($_GET["step"]))
    $step = (int) $_GET["step"];
if ($step > LAST_STEP)
    $step = 0;
include_once("steps/$step.php");
if (!sizeof($_POST)) {
    include_once(BASEDIR."/templates/header.php");
    include_once(BASEDIR."/templates/step$step.php");
    include_once(BASEDIR."/templates/footer.php");
}
