<?php

$currentPage = "acp_user.php";
include("global.php");
require_once("config.php");
require_admin();

$row = getConfig();
$data_email = $row['data_email'];
$data_level = $row['data_level'];
$data_faction = $row['data_faction'];
$data_leader = $row['data_leader'];
$data_lastlogin = $row['data_lastlogin'];
$data_skin = $row['data_skin'];
$data_date_of_registration = $row['data_date_of_registration'];
$data_sex = $row['data_sex'];
$data_age = $row['data_age'];
$data_cashmoney = $row['data_cashmoney'];
$data_bankmoney = $row['data_bankmoney'];
$data_rank = $row['data_rank'];
$data_coins = $row['data_coins'];

$data = $db->getFirst("SELECT * FROM factions");

$faction_1 = $data['faction_1'];
$faction_2 = $data['faction_2'];
$faction_3 = $data['faction_3'];
$faction_4 = $data['faction_4'];
$faction_5 = $data['faction_5'];
$faction_6 = $data['faction_6'];
$faction_7 = $data['faction_7'];
$faction_8 = $data['faction_8'];
$faction_9 = $data['faction_9'];
$faction_10 = $data['faction_10'];
$faction_11 = $data['faction_11'];
$faction_12 = $data['faction_12'];
$faction_13 = $data['faction_13'];
$faction_14 = $data['faction_14'];
$faction_15 = $data['faction_15'];
$faction_16 = $data['faction_16'];
$faction_17 = $data['faction_17'];
$faction_18 = $data['faction_18'];
$faction_19 = $data['faction_19'];
$faction_20 = $data['faction_20'];

$title = "Benutzer";
?>
<?php include_once("templates/header_acp.php"); ?>

    <!-- navigation -->
<?php include("navigation/nav_1.php"); ?>

    <!-- content -->
    <style>
        #size {
            color: white
        }
    </style>
    <div>
    <?php
    if (htmlspecialchars($_GET["status"]) == 1) //success for editing the user account
    {
        echo "<div class='alert alert-success fade in' role='alert'>";
        echo "<button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Schlie�en</span></button>";
        echo "<strong>Hinweis:</strong> Der Benutzer wurde erfolgreich &uuml;berarbeitet.";
        echo "</div>";
    }
    if (htmlspecialchars($_GET["show_profile"]) == true)
    {
        $selected_user = $_SESSION["userId"];

        $query2 = $db->getFirst("SELECT * FROM !accounts WHERE !id = '$selected_user'");
        $id = $query2[$row["data_id"]];
        $username = $query2[$row["data_username"]];
        $skin = $query2[$data_skin];
        $date_of_registration = $query2[$data_date_of_registration];
        $lastlogin = $query2[$data_lastlogin];
        $email = $query2[$data_email];
        $sex = $query2[$data_sex];
        $age = $query2[$data_age];
        $level = $query2[$data_level];
        $cashmoney = $query2[$data_cashmoney];
        $bankmoney = $query2[$data_bankmoney];
        $leader = $query2[$data_leader];
        $faction = $query2[$data_faction];
        $rank = $query2[$data_rank];
        $coins = $query2[$data_coins];
        $TS_UID = $query2['TS_UID'];
        $verified = $query2['verified'];
        $banned = $query2[$row["data_banned"]];
        $ucpadmin = $query2[$row["data_ucp_adminrights"]];


        $value = getConfig();

        echo "<table>";
        echo "<tr>";
        echo "<td><a href='acp_user.php'><button type='button' class='btn btn-primary'><span class='glyphicon glyphicon-arrow-left'></span> Zur&uuml;ck</button></a>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "</tr>";
        echo "</table> <br /><br />";
        echo "<div class='panel panel-primary'>";
        echo "<div class='panel-heading'>";
        echo "<h5 id='size'>Benutzerprofil von <b>$username</b> (Datenbank-ID: $id) </h5>";
        echo "</div>";
        echo "<div class='panel-body'>";
        ?>
        <form role="form" method="post" action="action_edit_user.php?userId=<?php echo $id; ?>">
        <table>
        <tr>
            <td><?php echo "<img src='assets/images/skins/Skin_" . $skin . ".png' class='img-thumbnail' data-toggle='modal' data-target='#skin-modal' style='cursor: pointer;' title='Ansicht vergr&ouml;&szlig;ern'/>"; ?></td>
            <td><?php echo "<h3> $username </h3>"; ?></td>
            <td><b>Dashboard-Zugang:</b> <select name="ucp_adminrights"><option <?php if ($ucpadmin) echo "selected"?> value="1">Ja</option><option <?php if (!$ucpadmin) echo "selected"?> value="0">Nein</option></select></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td><b>Registrierungsdatum</b>&nbsp;&nbsp;&nbsp;</td>
            <td><?= htmlspecialchars($date_of_registration) ?></td>
        </tr>

        <tr>
            <td><b>letztes Login</b>&nbsp;&nbsp;&nbsp;</td>
            <td><?= htmlspecialchars($lastlogin) ?></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td><b>Level</b>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" name="level" class="form-control" placeholder="Level"
                       value="<?= htmlspecialchars($level) ?>"/></td>

            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leader</b>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <select class="form-control" name="leader" size="1">
                    <?php
                    echo "<option value='0'";
                    if ($leader == 0)
                    {
                        echo "selected";
                    }
                    echo "> Kein Leader </option>";
                    if (!empty($faction_1))
                    {
                        echo "<option value='1'";
                        if ($leader == 1)
                        {
                            echo "selected";
                        }
                        echo "> $faction_1 </option>";
                    }
                    if (!empty($faction_2))
                    {
                        echo "<option value='2'";
                        if ($leader == 2)
                        {
                            echo "selected";
                        }
                        echo "> $faction_2 </option>";
                    }
                    if (!empty($faction_3))
                    {
                        echo "<option value='3'";
                        if ($leader == 3)
                        {
                            echo "selected";
                        }
                        echo "> $faction_3 </option>";
                    }
                    if (!empty($faction_4))
                    {
                        echo "<option value='4'";
                        if ($leader == 4)
                        {
                            echo "selected";
                        }
                        echo "> $faction_4 </option>";
                    }
                    if (!empty($faction_5))
                    {
                        echo "<option value='5'";
                        if ($leader == 5)
                        {
                            echo "selected";
                        }
                        echo "> $faction_5 </option>";
                    }
                    if (!empty($faction_6))
                    {
                        echo "<option value='6'";
                        if ($leader == 6)
                        {
                            echo "selected";
                        }
                        echo "> $faction_6 </option>";
                    }
                    if (!empty($faction_7))
                    {
                        echo "<option value='7'";
                        if ($leader == 7)
                        {
                            echo "selected";
                        }
                        echo "> $faction_7 </option>";
                    }
                    if (!empty($faction_8))
                    {
                        echo "<option value='8'";
                        if ($leader == 8)
                        {
                            echo "selected";
                        }
                        echo "> $faction_8 </option>";
                    }
                    if (!empty($faction_9))
                    {
                        echo "<option value='9'";
                        if ($leader == 9)
                        {
                            echo "selected";
                        }
                        echo "> $faction_9 </option>";
                    }
                    if (!empty($faction_10))
                    {
                        echo "<option value='10'";
                        if ($leader == 10)
                        {
                            echo "selected";
                        }
                        echo "> $faction_10 </option>";
                    }
                    if (!empty($faction_11))
                    {
                        echo "<option value='11'";
                        if ($leader == 11)
                        {
                            echo "selected";
                        }
                        echo "> $faction_11 </option>";
                    }
                    if (!empty($faction_12))
                    {
                        echo "<option value='12'";
                        if ($leader == 12)
                        {
                            echo "selected";
                        }
                        echo "> $faction_12 </option>";
                    }
                    if (!empty($faction_13))
                    {
                        echo "<option value='13'";
                        if ($leader == 13)
                        {
                            echo "selected";
                        }
                        echo "> $faction_13 </option>";
                    }
                    if (!empty($faction_14))
                    {
                        echo "<option value='14'";
                        if ($leader == 14)
                        {
                            echo "selected";
                        }
                        echo "> $faction_14 </option>";
                    }
                    if (!empty($faction_15))
                    {
                        echo "<option value='15'";
                        if ($leader == 15)
                        {
                            echo "selected";
                        }
                        echo "> $faction_15 </option>";
                    }
                    if (!empty($faction_16))
                    {
                        echo "<option value='16'";
                        if ($leader == 16)
                        {
                            echo "selected";
                        }
                        echo "> $faction_16 </option>";
                    }
                    if (!empty($faction_17))
                    {
                        echo "<option value='17'";
                        if ($leader == 17)
                        {
                            echo "selected";
                        }
                        echo "> $faction_17 </option>";
                    }
                    if (!empty($faction_18))
                    {
                        echo "<option value='18'";
                        if ($leader == 18)
                        {
                            echo "selected";
                        }
                        echo "> $faction_18 </option>";
                    }
                    if (!empty($faction_19))
                    {
                        echo "<option value='19'";
                        if ($leader == 19)
                        {
                            echo "selected";
                        }
                        echo "> $faction_19 </option>";
                    }
                    if (!empty($faction_20))
                    {
                        echo "<option value='20'";
                        if ($leader == 20)
                        {
                            echo "selected";
                        }
                        echo "> $faction_20 </option>";
                    }
                    ?>
                </select>
            </td>
            <?php
            if ($value['status_ts_controller'] == 0)
            {
                echo " <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TS-Verifizierung</b>&nbsp;&nbsp;&nbsp;</td>";
                echo "<td>";
                if ($verified == 1)
                {
                    echo ICON_OK;
                }
                else
                {
                    if ($verified == 0)
                    {
                        echo ICON_NO;
                    }
                }
                echo "</td>";
            }
            ?>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td><b>Passwort</b>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="password" name="password" class="form-control" placeholder="neues Passwort"/></td>

            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fraktion</b>&nbsp;&nbsp;&nbsp;</td>
            <td>
                <select class="form-control" name="faction" size="1">
                    <?php
                    echo "<option value='0'";
                    if ($faction == 0)
                    {
                        echo "selected";
                    }
                    echo "> Keine Fraktion </option>";
                    if (!empty($faction_1))
                    {
                        echo "<option value='1'";
                        if ($faction == 1)
                        {
                            echo "selected";
                        }
                        echo "> $faction_1 </option>";
                    }
                    if (!empty($faction_2))
                    {
                        echo "<option value='2'";
                        if ($faction == 2)
                        {
                            echo "selected";
                        }
                        echo "> $faction_2 </option>";
                    }
                    if (!empty($faction_3))
                    {
                        echo "<option value='3'";
                        if ($faction == 3)
                        {
                            echo "selected";
                        }
                        echo "> $faction_3 </option>";
                    }
                    if (!empty($faction_4))
                    {
                        echo "<option value='4'";
                        if ($faction == 4)
                        {
                            echo "selected";
                        }
                        echo "> $faction_4 </option>";
                    }
                    if (!empty($faction_5))
                    {
                        echo "<option value='5'";
                        if ($faction == 5)
                        {
                            echo "selected";
                        }
                        echo "> $faction_5 </option>";
                    }
                    if (!empty($faction_6))
                    {
                        echo "<option value='6'";
                        if ($faction == 6)
                        {
                            echo "selected";
                        }
                        echo "> $faction_6 </option>";
                    }
                    if (!empty($faction_7))
                    {
                        echo "<option value='7'";
                        if ($faction == 7)
                        {
                            echo "selected";
                        }
                        echo "> $faction_7 </option>";
                    }
                    if (!empty($faction_8))
                    {
                        echo "<option value='8'";
                        if ($faction == 8)
                        {
                            echo "selected";
                        }
                        echo "> $faction_8 </option>";
                    }
                    if (!empty($faction_9))
                    {
                        echo "<option value='9'";
                        if ($faction == 9)
                        {
                            echo "selected";
                        }
                        echo "> $faction_9 </option>";
                    }
                    if (!empty($faction_10))
                    {
                        echo "<option value='10'";
                        if ($faction == 10)
                        {
                            echo "selected";
                        }
                        echo "> $faction_10 </option>";
                    }
                    if (!empty($faction_11))
                    {
                        echo "<option value='11'";
                        if ($faction == 11)
                        {
                            echo "selected";
                        }
                        echo "> $faction_11 </option>";
                    }
                    if (!empty($faction_12))
                    {
                        echo "<option value='12'";
                        if ($faction == 12)
                        {
                            echo "selected";
                        }
                        echo "> $faction_12 </option>";
                    }
                    if (!empty($faction_13))
                    {
                        echo "<option value='13'";
                        if ($faction == 13)
                        {
                            echo "selected";
                        }
                        echo "> $faction_13 </option>";
                    }
                    if (!empty($faction_14))
                    {
                        echo "<option value='14'";
                        if ($faction == 14)
                        {
                            echo "selected";
                        }
                        echo "> $faction_14 </option>";
                    }
                    if (!empty($faction_15))
                    {
                        echo "<option value='15'";
                        if ($faction == 15)
                        {
                            echo "selected";
                        }
                        echo "> $faction_15 </option>";
                    }
                    if (!empty($faction_16))
                    {
                        echo "<option value='16'";
                        if ($faction == 16)
                        {
                            echo "selected";
                        }
                        echo "> $faction_16 </option>";
                    }
                    if (!empty($faction_17))
                    {
                        echo "<option value='17'";
                        if ($faction == 17)
                        {
                            echo "selected";
                        }
                        echo "> $faction_17 </option>";
                    }
                    if (!empty($faction_18))
                    {
                        echo "<option value='18'";
                        if ($faction == 18)
                        {
                            echo "selected";
                        }
                        echo "> $faction_18 </option>";
                    }
                    if (!empty($faction_19))
                    {
                        echo "<option value='19'";
                        if ($faction == 19)
                        {
                            echo "selected";
                        }
                        echo "> $faction_19 </option>";
                    }
                    if (!empty($faction_20))
                    {
                        echo "<option value='20'";
                        if ($faction == 20)
                        {
                            echo "selected";
                        }
                        echo "> $faction_20 </option>";
                    }
                    ?>
                </select>
            </td>
            <?php
            if ($value['status_ts_controller'] == 0)
            {
                echo "<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;eindeutige TS-ID</b>&nbsp;&nbsp;&nbsp;</td>";
                echo "<td><input type='text' name='TS_UID' class='form-control' placeholder='TS_UID' value='$TS_UID' style='width: 280px;' disabled/></td>";
            }
            ?>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td><b>E-Mail Adresse</b>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" name="email" class="form-control" placeholder="E-Mail Adresse"
                       value="<?= htmlspecialchars($email) ?>"/></td>

            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rang</b>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" name="rank" class="form-control" placeholder="Rang"
                       value="<?= htmlspecialchars($rank) ?>"/></td>
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

            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Premiumguthaben</b>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" name="coins" class="form-control" placeholder="Premiumguthaben"
                       value="<?= htmlspecialchars($coins) ?>"/></td>
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

        <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bargeld</b>&nbsp;&nbsp;&nbsp;</td>
        <td><input type="text" name="cashmoney" class="form-control" placeholder="Bargeld"
                   value="<?= htmlspecialchars($cashmoney) ?>"/></td>
        </tr>

        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td><b>Accountstatus</b>&nbsp;&nbsp;&nbsp;</td>
            <td><?php if ($banned == 0)
                {
                    echo "nicht gebannt";
                }
                else
                {
                    if ($banned == 1)
                    {
                        echo "gebannt";
                    }
                } ?></td>

            <td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kontostand</b>&nbsp;&nbsp;&nbsp;</td>
            <td><input type="text" name="bankmoney" class="form-control" placeholder="Kontostand"
                       value="<?= htmlspecialchars($bankmoney) ?>"/></td>
        </tr>
        </table>
        <br/>
        <input type="submit" name="submit" class="btn btn-success" value="speichern" align="left"/>
        </form>
        <div align="right">
            <button type="button" class="btn btn-primary"
                    onclick="document.location='acp_log.php?username=<?= $username ?>'"><span
                    class="glyphicon glyphicon-search"></span> Protokolle zeigen
            </button>
            <?php
            if ($value['status_ts_controller'] == 0)
            {
                if ($verified == 1)
                {
                    echo "<a href='action_reset_ts_user.php?userId=$id'><button type='button' class='btn btn-default'><span class='glyphicon glyphicon-repeat'></span> TeamSpeak-Rechte entziehen</button></a>";
                }
            }
            ?>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#meinModal"><span
                    class="glyphicon glyphicon-trash"></span> Account l&ouml;schen
            </button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php
            $query3 = $db->getFirst("SELECT !banned FROM !accounts WHERE !id = '$selected_user'") or die(mysql_error());
            $banned = $query3["!banned"];
            if ($banned == 0)
            {
                echo "<a href='action_edit_user_accstatus.php?action=1&userId=$id'><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-lock'></span> Benutzer bannen</button></a>";
            }
            else
            {
                if ($banned == 1)
                {
                    echo "<a href='action_edit_user_accstatus.php?action=0&userId=$id'><button type='button' class='btn btn-danger'><span class='glyphicon glyphicon-lock'></span> Benutzer entbannen</button></a>";
                }
            }
            ?>
        </div>
        <?php
        echo "</div>";
        echo "</div>";


    }
    ?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="meinModal" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">zur&uuml;ck</span></button>
                    <h4 class="modal-title" id="meinModalLabel">Account l&ouml;schen</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                class="sr-only">zur&uuml;ck</span></button>
                        <strong>Warnung:</strong> Eine Accountl&ouml;schung ist unwiderruflich und kann nicht wieder r&uuml;ckg&auml;ngig
                        gemacht werden.
                    </div>
                    <br/>

                    <form role="form" method="post" action="action_delete_user.php?userId=<?php echo $id; ?>">
                        <div class="checkbox">
                            <label>
                                <input name="accept" type="checkbox" value="1" required/>
                                Ich best&auml;tige das ich den Warnhinweis gelesen habe.
                            </label>
                            <br/><br/>
                            <label>
                                <input name="accept2" type="checkbox" value="2" required/>
                                Ich best&auml;tige dar&uuml;ber hinaus das ich mir bewusst bin, das eine Accountl&ouml;schung
                                unwiderrufliche Folgen hat.
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">zur&uuml;ck</button>
                    <input type="submit" name="submit" class="btn btn-danger" value="best&auml;tigen"/>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal 2 -->
<div class="modal fade" id="skin-modal" tabindex="-1" role="dialog" aria-labelledby="meinModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">zur&uuml;ck</span></button>
                <h4 class="modal-title" id="meinModalLabel">Aussehen - vergr&ouml;&szlig;erte Ansicht</h4>
            </div>
            <div class="modal-body" align="center">
                <?php echo "<img src='http://weedarr.wdfiles.com/local--files/skinlistc/" . $skin . ".png' class='img-thumbnail'/>"; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Schlie&szlig;en</button>
            </div>
        </div>
    </div>
<?php include_once("templates/footer_general.php");