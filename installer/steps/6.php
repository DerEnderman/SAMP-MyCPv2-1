<?php
$title = "Konfiguration speichern";
$hideButton = true;


if (sizeof($_POST)) {
    $host = $_SESSION["MySQLserver"] ;
    $user = $_SESSION["MySQLuser"];
    $password = $_SESSION["MySQLpassword"];
    $database = $_SESSION["MySQLdatabase"];
    $table =  $_SESSION["table_accounts"];
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $statement = $pdo->prepare("SELECT ".$_SESSION["data_id"]." as id FROM ".$_SESSION["table_accounts"]." WHERE ".$_SESSION["data_username"]." = '".$_POST["admin-user"]."'");
    $statement->execute();
    $admin_id = $statement->fetch();
    if (!is_array($admin_id)) {
        header("Location: "."http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        die();
    }
    $admin_id = $admin_id["id"];

    $queries = file_get_contents(BASEDIR."/db.sql");
    $queries = explode(";", $queries);
    foreach ($queries as $query) {
        try {
        $statement = $pdo->prepare($query);
        $statement->execute();
        } catch (Exception $e) {}
    }

    $statement = $pdo->prepare("INSERT INTO `mycp_users_to_groups` (`user`, `group`) VALUES ($admin_id, 1);");
    $statement->execute();

    $config = array();
    $config["mysql_user"] = $_SESSION["MySQLuser"];
    $config["mysql_password"] = $_SESSION["MySQLpassword"];
    $config["mysql_host"] = $_SESSION["MySQLserver"];
    $config["mysql_database"] = $_SESSION["MySQLdatabase"];
    $config["data_accounts"] = $_SESSION["table_accounts"];

    $config['header_img1'] = '//i.imgur.com/rcmV5b7.jpg';
    $config['header_img2'] = '//i.imgur.com/JhXFdka.jpg';
    $config['header_img3'] = '//i.imgur.com/t5kBv22.jpg';
    $config['header_headline1'] = 'Lorem ipsum I';
    $config['header_headline2'] = 'Lorem ipsum II';
    $config['header_headline3'] = 'Lorem ipsum III';
    $config['header_text1'] = ' Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ';
    $config['header_text2'] = ' Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ';
    $config['header_text3'] = ' Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ';
    $config['start_img1'] = '//i.imgur.com/8Qu0QTG.png';
    $config['start_img2'] = '//i.imgur.com/8Qu0QTG.png';
    $config['start_img3'] = '//i.imgur.com/8Qu0QTG.png';
    $config['start_headline1'] = 'Über myCP';
    $config['start_headline2'] = 'Lorem Ipsum 2';
    $config['start_headline3'] = 'Lorem Ipsum 3';
    $config['start_text1'] = 'myCP ist die einfachste Möglichkeit, einen SA:MP-Server zu verwalten.';
    $config['start_text2'] = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ';
    $config['start_text3'] = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. ';
    $config['projectname'] = 'myCP 2';
    $config['projectdescription'] = 'Das alternative UCP für jeden SA:MP-Server';
    $config['samp_ip'] = '127.0.0.1:7777';
    $config['footer_content_3'] = '&copy; myCP 2  - Das vielseitige UCP für jeden SA:MP-Server &middot; 2014-2015';
    $config['footer_content_2'] = '&copy; myCP 2  - Das vielseitige UCP für jeden SA:MP-Server &middot; 2014-2015';
    $config['status_loginmessage'] = '1';
    $config['login_message'] = '';
    $config['rules_tab3'] = '<b><font size="5pt">Inhalt folgt</font></b><br />
<font size="1pt" color="#808080">* Sollte eine Strafe fehlerhaft vergeben worden sein, melde dich am Besten bei unseren Support.</font>';
    $config['ts_ipadress'] = '127.0.0.1';
    $config['ts_port'] = '9987';
    $config['ts_query_admin'] = 'serveradmin';
    $config['ts_query_password'] = '';
    $config['ts_query_port'] = '10011';
    $config['ts_query_user_nick'] = 'myCP-Bot';
    $config['status_registration'] = '1';
    $config['status_ts_controller'] = '1';
    $config['status_supporter_application'] = '1';
    $config['status_leader_application'] = '1';
    $config['status_whosonline_list'] = '1';
    $config['status_forum'] = '1';
    $config['status_finances'] = '1';
    $config['TS_servergroupname'] = 'VIP';
    $config['TS_servergroupID'] = '11';
    $config['TS_verifydescription'] = 'Verifizierter Benutzer';
    $config['href_forum'] = 'https://breadfish.de/';
    $config['color'] = 'rgb(50,122,182)';
    $config['version'] = '1.9';
    $config['samp_ipadress'] = '127.0.0.1:7777';
    $config['ts3_ipadress'] = '127.0.0.1';
    $config["cronjob_key"] = false;

    foreach ($need as $key => $value) {
        $config[$key] = $_SESSION[$key];
    }
    foreach ($optional as $key => $value) {
        if (isset($_SESSION[$key]))
            $config[$key] = $_SESSION[$key];
    }
    $config["hashFunction"] = $_SESSION["hashFunction"];
    saveConfig($config);
    //Selbstzerstörung
    unlink(BASEDIR."/index.php");
    unlink(BASEDIR."/GO");
    $dir = '.';
    $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach($files as $file) {
        if ($file->isDir()){
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    rmdir($dir);
    header("Location: ../");
}