<?php
$title = "myCP Datenbank-Konfiguration (Spaltennamen)";
$hideButton = true;
$host = $_SESSION["MySQLserver"] ;
$user = $_SESSION["MySQLuser"];
$password = $_SESSION["MySQLpassword"];
$database = $_SESSION["MySQLdatabase"];
$table=  $_SESSION["table_accounts"];
$pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$statement = $pdo->prepare("select COLUMN_NAME from information_schema.columns WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?");
$statement->execute(array($database, $table));
$columns_ =  $statement->fetchAll();
$columns = array();
foreach ($columns_ as $column) {
    $columns[] = $column["COLUMN_NAME"];
}



if (sizeof($_POST)) {
    $i = 0;
    $allowed = array_merge(array_flip($need), array_flip($optional));
    foreach ($_POST as $key => $value)  {
        if (!in_array($key, $allowed))
            continue;
        if (!in_array($value, $columns))
            continue;
        $i++;
        $_SESSION[$key] = $value;
    }
    if ($i < sizeof($need)) {
        header("Location: index.php?step=4");
        die();
    }
    header("Location: index.php?step=5");
    die();
}