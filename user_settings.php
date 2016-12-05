<?php

$currentPage = "user_settings.php";
include("global.php");
require_once("config.php");
require_login();

$title = "Profil";
?>
<?php include_once("templates/header_general.php"); ?>
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
<?php
if (htmlspecialchars($_GET["status"]) == success)
{
    echo "<div class='alert alert-success fade in' role='alert'>";
    echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
    echo "<strong>Prima!</strong> Deine Einstellungen wurden erfolgreich aktualisiert.";
    echo "</div>";
}
?>
<div class="panel panel-default">
<div class="panel-heading">allgemeine Einstellungen</div>
<div class="panel-body">
<form class="form-signin" role="form" action="action_edit_user_settings.php" method="post">
<?php
$row = getConfig();
$data_email = $row['data_email'];
$data_sex = $row['data_sex'];
$data_age = $row['data_age'];


$username = $_SESSION['username'];
$data2 = $db->getFirst("SELECT * FROM !accounts WHERE !username = '$username'");

$email = $data2[$data_email];
$password = $data2["!password"];
$sex = $data2[$data_sex];
$age = $data2[$data_age];

?>
<table>
<tr>
    <td><b>E-Mail Adresse</b>&nbsp;&nbsp;&nbsp;</td>
    <td><input type="text" name="email" class="form-control" placeholder="E-Mail Adresse"
               value="<?= htmlspecialchars($email) ?>" required/></td>
</tr>

<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>

<tr>
    <td><b>Passwort</b>&nbsp;&nbsp;&nbsp;</td>
    <td><input type="password" name="password" class="form-control"
               placeholder="neues Passwort"/></td>
</tr>

<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>

<tr>
    <td><b>Geschlecht</b>&nbsp;&nbsp;&nbsp;</td>
    <td>
        <select class="form-control" name="sex" size="1">
            <option value='1' <?php if ($sex == 1)
            {
                echo "selected";
            } ?>>m&auml;nnlich
            </option>
            <option value='2'<?php if ($sex == 2)
            {
                echo "selected";
            } ?>>weiblich
            </option>
        </select>
    </td>
</tr>

<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>

<tr>
<td><b>Alter</b>&nbsp;&nbsp;&nbsp;</td>
<td>
    <select class="form-control" name="age" size="1">
        <option value='12' <?php if ($age == 12)
        {
            echo "selected";
        } ?>>12
        </option>
        <option value='13'<?php if ($age == 13)
        {
            echo "selected";
        } ?>>13
        </option>
        <option value='14'<?php if ($age == 14)
        {
            echo "selected";
        } ?>>14
        </option>
        <option value='15'<?php if ($age == 15)
        {
            echo "selected";
        } ?>>15
        </option>
        <option value='16'<?php if ($age == 16)
        {
            echo "selected";
        } ?>>16
        </option>
        <option value='17'<?php if ($age == 17)
        {
            echo "selected";
        } ?>>17
        </option>
        <option value='18'<?php if ($age == 18)
        {
            echo "selected";
        } ?>>18
        </option>
        <option value='19'<?php if ($age == 19)
        {
            echo "selected";
        } ?>>19
        </option>
        <option value='20'<?php if ($age == 20)
        {
            echo "selected";
        } ?>>20
        </option>
        <option value='21'<?php if ($age == 21)
        {
            echo "selected";
        } ?>>21
        </option>
        <option value='22'<?php if ($age == 22)
        {
            echo "selected";
        } ?>>22
        </option>
        <option value='23'<?php if ($age == 23)
        {
            echo "selected";
        } ?>>23
        </option>
        <option value='24'<?php if ($age == 24)
        {
            echo "selected";
        } ?>>24
        </option>
        <option value='25'<?php if ($age == 25)
        {
            echo "selected";
        } ?>>25
        </option>
        <option value='26'<?php if ($age == 26)
        {
            echo "selected";
        } ?>>26
        </option>
        <option value='27'<?php if ($age == 27)
        {
            echo "selected";
        } ?>>27
        </option>
        <option value='28'<?php if ($age == 28)
        {
            echo "selected";
        } ?>>28
        </option>
        <option value='29'<?php if ($age == 29)
        {
            echo "selected";
        } ?>>29
        </option>
        <option value='30'<?php if ($age == 30)
        {
            echo "selected";
        } ?>>30
        </option>
        <option value='31'<?php if ($age == 31)
        {
            echo "selected";
        } ?>>31
        </option>
        <option value='32'<?php if ($age == 32)
        {
            echo "selected";
        } ?>>32
        </option>
        <option value='33'<?php if ($age == 33)
        {
            echo "selected";
        } ?>>33
        </option>
        <option value='34'<?php if ($age == 34)
        {
            echo "selected";
        } ?>>34
        </option>
        <option value='35'<?php if ($age == 35)
        {
            echo "selected";
        } ?>>35
        </option>
        <option value='36'<?php if ($age == 36)
        {
            echo "selected";
        } ?>>36
        </option>
        <option value='37'<?php if ($age == 37)
        {
            echo "selected";
        } ?>>37
        </option>
        <option value='38'<?php if ($age == 38)
        {
            echo "selected";
        } ?>>38
        </option>
        <option value='39'<?php if ($age == 39)
        {
            echo "selected";
        } ?>>39
        </option>
        <option value='40'<?php if ($age == 40)
        {
            echo "selected";
        } ?>>40
        </option>
        <option value='41'<?php if ($age == 41)
        {
            echo "selected";
        } ?>>41
        </option>
        <option value='42'<?php if ($age == 42)
        {
            echo "selected";
        } ?>>42
        </option>
        <option value='43'<?php if ($age == 43)
        {
            echo "selected";
        } ?>>43
        </option>
        <option value='44'<?php if ($age == 44)
        {
            echo "selected";
        } ?>>44
        </option>
        <option value='45'<?php if ($age == 45)
        {
            echo "selected";
        } ?>>45
        </option>
        <option value='46'<?php if ($age == 46)
        {
            echo "selected";
        } ?>>46
        </option>
        <option value='47'<?php if ($age == 47)
        {
            echo "selected";
        } ?>>47
        </option>
        <option value='48'<?php if ($age == 48)
        {
            echo "selected";
        } ?>>48
        </option>
        <option value='49'<?php if ($age == 49)
        {
            echo "selected";
        } ?>>49
        </option>
        <option value='50'<?php if ($age == 50)
        {
            echo "selected";
        } ?>>50
        </option>
        <option value='51'<?php if ($age == 51)
        {
            echo "selected";
        } ?>>51
        </option>
        <option value='52'<?php if ($age == 52)
        {
            echo "selected";
        } ?>>52
        </option>
        <option value='53'<?php if ($age == 53)
        {
            echo "selected";
        } ?>>53
        </option>
        <option value='54'<?php if ($age == 54)
        {
            echo "selected";
        } ?>>54
        </option>
        <option value='55'<?php if ($age == 55)
        {
            echo "selected";
        } ?>>55
        </option>
        <option value='56'<?php if ($age == 56)
        {
            echo "selected";
        } ?>>56
        </option>
        <option value='57'<?php if ($age == 57)
        {
            echo "selected";
        } ?>>57
        </option>
        <option value='58'<?php if ($age == 58)
        {
            echo "selected";
        } ?>>58
        </option>
        <option value='59'<?php if ($age == 59)
        {
            echo "selected";
        } ?>>59
        </option>
        <option value='60'<?php if ($age == 60)
        {
            echo "selected";
        } ?>>60
        </option>
    </select>
</td>
</tr>
</table>
<br/>
<input type="submit" name="submit" class="btn btn-success" value="speichern"/>
</form>
</div>
</div>
<br/>
</div>
<!--/span-->

<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <br/><br/><br/>

    <div class="list-group">
        <a href="profile.php" class="list-group-item">Profil</a>
        <a href="user_settings.php" class="list-group-item active">allgemeine Einstellungen</a>
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