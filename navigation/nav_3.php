<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Navigation ein-/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><?php get_projectname(); ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class='<?php if ($currentPage == "informations.php") echo "active"; ?>'><a href="informations.php">Informationen</a>
                </li>
                <li class='<?php if ($currentPage == "index.php") echo "active"; ?>'><a href="index.php">Start</a></li>
                <?php
                $row = getConfig();
                $status_forum = $row['status_forum'];
                $href_forum = $row['href_forum'];

                if ($status_forum == 0)
                {
                    echo '<li><a href="' . $href_forum . '">Forum</a></li>';
                }
                ?>
            </ul>
            <form class="navbar-form navbar-right" role="form">
                <div id="loginerror"></div>
                <div class="form-group">
                    <input name="username" id="username" type="text" class="form-control" placeholder="Nickname"
                           required autofocus>
                </div>
                <div class="form-group">
                    <input name="password" id="password" type="password" class="form-control" placeholder="Passwort"
                           required>
                </div>
                <button onclick="login()" value="Login" class="btn btn-default"><span class="glyphicon glyphicon-log-in"
                                                                                      aria-hidden="true"></span> Login
                </button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Jetzt
                        starten <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="ts3server://<?php get_ts3ip(); ?>">» mit TeamSpeak verbinden</a></li>
                        <li><a href="samp://<?php get_sampip(); ?>">» mit Server verbinden</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>