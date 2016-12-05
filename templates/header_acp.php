<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="icon" href="assets/favicon.ico"/>

    <title><?= $title ?> - <?php get_projectname(); ?> Dashboard</title>

    <!-- Bootstrap-CSS -->
    <link href="assets/css/bootstrap.min-acp.css" rel="stylesheet"/>
    <script src="assets/js/bauer_autocomplete.js"></script>
    <!-- Besondere Stile f�r diese Vorlage -->
    <link href="assets/css/dashboard.css" rel="stylesheet"/>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Unterst�tzung f�r Media Queries und HTML5-Elemente im Internet Explorer �ber HTML5 shim und Respond.js -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .autocomplete-data {
            position:absolute;
            box-shadow: 0 1px 4px rgba(0,0,0,0.3);
        }
    </style>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <style>
        body {
            font-family: 'Lato', sans-serif !important;
            overflow-x: hidden;
        }
    </style>

</head>
<body>

<!-- navigation -->
<?php include("navigation/nav_1.php"); ?>

<!-- content -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header"><?= $title ?></h1>