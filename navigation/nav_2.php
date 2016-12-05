<!-- TODO: MySQL-->
<ul class="nav navbar-nav">
    <li class='<?php if ($currentPage == "start.php") echo "active"; ?>'><a href="start.php"><span
                class="glyphicon glyphicon-home"></span> Startseite</a></li>
    <li class='<?php if ($currentPage == "rules.php") echo "active"; ?>'><a href="rules.php"><span
                class="glyphicon glyphicon-book"></span> Regeln</a></li>
    <li class="dropdown <?=(in_array($currentPage, array("profile.php", "finances.php", "applications.php", "user_settings.php", "user_ts_settings.php")))?"active":"" ?>">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span
                class="glyphicon glyphicon-user"></span> Account<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="<?php if ($currentPage == "profile.php") echo "active"; ?>"><a href="profile.php">Profil</a></li>
            <?php
            $row = getConfig();
            $status_finances = $row['status_finances'];
            if ($status_finances != 1)
            {
                ?>
                <li class="<?php if ($currentPage == "finances.php") echo "active"; ?>"><a
                        href="finances.php">Finanzen</a></li>
            <?php
            }
            ?>
            <li class="<?php if ($currentPage == "applications.php") echo "active"; ?>"><a href="applications.php">Bewerbungen</a>
            </li>
            <li class="divider"></li>
            <li class="dropdown-header">Anpassungen</li>
            <li class="<?php if ($currentPage == "user_settings.php") echo "active"; ?>"><a href="user_settings.php">allgemeine
                    Einstellungen</a></li>
            <li class="<?php if ($currentPage == "user_ts_settings.php") echo "active"; ?>"><a
                    href="user_ts_settings.php">TeamSpeak-Einstellungen</a></li>
        </ul>
    </li>
    <li class='<?php if ($currentPage == "faction.php") echo "active"; ?>'><a href="faction.php"><span
                class="glyphicon glyphicon-lock"></span> Fraktion</a></li>
    <li class='<?php if ($currentPage == "support.php") echo "active"; ?>'><a href="support.php"><span
                class="glyphicon glyphicon-comment"></span> Support</a></li>
    <?php
    if ($handle = opendir('navigation')) {
        while (false !== ($file = readdir($handle))) {
            if (strpos($file, "ucp_") === 0) {
                include_once("./navigation/$file");
            }
        }
        closedir($handle);
    }
    ?>
</ul>
<ul class="nav navbar-nav navbar-right">
    <?php
    if (check_permission("dashboard", "show"))
    {
        echo "<li><a href='acp_start.php'><span class='glyphicon glyphicon-th-large'></span> Dashboard</a></li>";
    }
    ?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
           aria-expanded="false"><?php get_username(); ?> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li class="<?php if ($currentPage == "user_settings.php") echo "active"; ?>"><a href="user_settings.php">allgemeine
                    Einstellungen</a></li>
            <li class="<?php if ($currentPage == "user_ts_settings.php") echo "active"; ?>"><a
                    href="user_ts_settings.php">TeamSpeak-Einstellungen</a></li>
            <li class="divider"></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
            </li>
        </ul>
    </li>
</ul>