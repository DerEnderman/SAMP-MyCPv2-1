<?php
include("global.php");
$currentPage = "index.php";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="icon" href="assets/favicon.ico"/>

    <title>Startseite - <?php get_projectname(); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>


    <!--[if lt IE 9]>
    <script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://holdirbootstrap.de/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web&subset=latin,latin-ext' rel='stylesheet'
          type='text/css'>
    <style>
        body {
            font-family: 'Titillium Web', sans-serif !important;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="http://holdirbootstrap.de/examples/carousel/carousel.css" rel="stylesheet">
    <script>
        $("#navbar input").keyup(function (e) {
            if (e.keyCode == 13) {
                login();
            }
        });
        function login() {
            $("#loginerror").text("Einen Moment bitte...");
            $("#loginerror").fadeIn("slow");
            $("#loginerror")[0].style.color = "black";
            var username = $("#username").val();
            var password = $("#password").val();
            $.ajax({
                type: "POST",
                url: "login.php",
                data: {username: username, password: password, submit: true}
            }).done(function (data) {
                $("#loginerror").fadeOut("slow");
                var obj = jQuery.parseJSON(data);
                if (!obj.error)
                    document.location = "start.php?login=1";
                else {
                    $("#loginerror")[0].style.color = "red";
                    $("#loginerror").text(obj.message);
                    $("#loginerror").fadeIn("slow");

                    ///
                    $("body").effect("shake",
                        {times: 1}, 300);
                    ///

                }
            });
        }
    </script>
    <style>
        div#loginerror {
            position: absolute;
            top: 70px;
            background: white;
            padding: 10px;
            color: red;
            /* border: 1px black solid; */
            box-shadow: black 2px;
            box-shadow: 1px 1px 10px white;
            /* border-radius: 2px; */
            font-weight: bold;
            display: none;
        }
    </style>

</head>
<!-- NAVBAR
================================================== -->
<body>
<div class="navbar-wrapper">
    <div class="container">
        <?php include("navigation/nav_3.php"); ?>
    </div>
</div>
<!-- ================================================== -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- position -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img src="<?php $config = getConfig();
            echo $config["header_img1"]; ?>" alt="Erste Folie">

            <div class="container">
                <div class="carousel-caption">
                    <h1><?php $config = getConfig();
                        echo $config["header_headline1"]; ?></h1>

                    <p><?php $config = getConfig();
                        echo $config["header_text1"]; ?></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?php $config = getConfig();
            echo $config["header_img2"]; ?>" alt="Zweite Folie">

            <div class="container">
                <div class="carousel-caption">
                    <h1><?php $config = getConfig();
                        echo $config["header_headline2"]; ?></h1>

                    <p><?php $config = getConfig();
                        echo $config["header_text2"]; ?></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?php $config = getConfig();
            echo $config["header_img3"]; ?>" alt="Dritte Folie">

            <div class="container">
                <div class="carousel-caption">
                    <h1><?php $config = getConfig();
                        echo $config["header_headline3"]; ?></h1>

                    <p><?php $config = getConfig();
                        echo $config["header_text3"]; ?></p>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Zurück</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Weiter</span>
    </a>
</div>
<!-- /.carousel -->


<!-- main content
================================================== -->

<div class="container marketing">

    <h3>Neuigkeiten</h3>

    <?php show_news_outside(); ?>

    <hr class="featurette-divider">


    <!-- FOOTER -->
    <footer>
        <p class="pull-right"><a href="#"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span> nach
                oben</a></p>

        <p><?php get_footer3(); ?></p>
    </footer>

</div>
<!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script>
    $("form").submit(function (e) {
        e.preventDefault(); // this will prevent from submitting the form.
        //login();
    });
</script>
</body>
</html>