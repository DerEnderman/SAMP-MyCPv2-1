<?php

include("global.php");
$currentPage = "informations.php";

$users = $db->getAll("SELECT DISTINCT !username as name, !adminrights as admin FROM user_log l LEFT JOIN !accounts a ON a.!id = l.user WHERE l.time >= DATE_SUB(NOW(), INTERVAL 1 HOUR)");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <link rel="icon" href="../../favicon.ico"/>

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
        function login() {
            var username = $("#username").val();
            var password = $("#password").val();
            $.ajax({
                type: "POST",
                url: "login.php",
                data: {username: username, password: password, submit: true}
            }).done(function (data) {
                var obj = jQuery.parseJSON(data);
                if (!obj.error)
                    document.location = "start.php?login=1";
                else {
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
                        echo $config["header_text1"]; ?></p>
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
                        echo $config["header_text1"]; ?></p>
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

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php $config = getConfig();
                echo $config["start_headline1"]; ?></h2>

            <p class="lead"><?php $config = getConfig();
                echo $config["start_text1"]; ?></p>
        </div>
        <div class="col-md-5">
            <img src="<?php $config = getConfig();
            echo $config["start_img1"]; ?>" class="featurette-image img-responsive" alt="Generisches Platzhalter-Bild">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-5">
            <img src="<?php $config = getConfig();
            echo $config["start_img2"]; ?>" class="featurette-image img-responsive" alt="Generisches Platzhalter-Bild">
        </div>
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php $config = getConfig();
                echo $config["start_headline2"]; ?></h2>

            <p class="lead"><?php $config = getConfig();
                echo $config["start_text2"]; ?></p>
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading"><?php $config = getConfig();
                echo $config["start_headline3"]; ?></h2>

            <p class="lead"><?php $config = getConfig();
                echo $config["start_text3"]; ?></p>
        </div>
        <div class="col-md-5">
            <img src="<?php $config = getConfig();
            echo $config["start_img3"]; ?>" class="featurette-image img-responsive" alt="Generisches Platzhalter-Bild">
        </div>
    </div>

    <hr class="featurette-divider">
    <!-- online list -->
    <?php
    $row = getConfig();
    $status_whosonline_list = $row['status_whosonline_list'];
    if ($status_whosonline_list != 1)
    {

    ?>
    <style>
        #onlinelist span {
            padding-right: 10px;
        }

        #onlinelist span:after {
            content: ",";
        }

        #onlinelist span:last-child:after {
            content: "";
        }
    </style>
    <div class="well-lg">
        <h3><span style="float:left" class='glyphicon glyphicon-user'> </span>
            <?php
            $count = sizeof($users);
            if (!$count)
            {
                echo "Derzeit sind keine Benutzer online";
            }
            else
            {
                if ($count == 1)
                {
                    echo "Derzeit ist ein Benutzer online";
                }
                else
                {
                    echo "Derzeit sind $count Benutzer online";
                }
            }
            echo "</h3><hr>";
            echo "<div id='onlinelist'>";
            foreach ($users as $user)
            {
                echo "<span>";
                if ($user["admin"])
                {
                    echo "<b>Admin </b>";
                }
                echo $user["name"];
                echo "</span>";
            }
            ?>
    </div>
</div>
<?php
}
?>
<br/>

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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/docs.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
<script>
    $("form").submit(function (e) {
        e.preventDefault(); // this will prevent from submitting the form.
        login();
    });
</script>
</body>
</html>