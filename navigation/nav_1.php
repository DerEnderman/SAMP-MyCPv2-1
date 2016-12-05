<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Navigation ein-/ausblenden</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php get_projectname(); ?> - Dashboard
                (Administrationsoberfl&auml;che)</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="start.php"><span class="glyphicon glyphicon-eye-open"></span> Benutzeransicht</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                       aria-expanded="false"><?php get_username(); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="<?php if ($currentPage == "user_settings.php") echo "active"; ?>"><a
                                href="user_settings.php">allgemeine
                                Einstellungen</a></li>
                        <li class="<?php if ($currentPage == "user_ts_settings.php") echo "active"; ?>"><a
                                href="user_ts_settings.php">TeamSpeak-Einstellungen</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="form" action="acp_user.php">
                <div class="form-group">
                    <input name="user" id="search" type="search" class="form-control" autocomplete="off"
                           placeholder="Benutzer durchsuchen"
                           required>
                </div>
                <div id="autocomplete-data" class="panel-footer autocomplete-data"></div>
                <button onclick="login()" value="Login" class="btn btn-default"><span class="glyphicon glyphicon-search"
                                                                                      aria-hidden="true"></span>
                </button>
            </form>
            <!-- content -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <?php
                    printNavigationLink("acp_start.php", "Start", "glyphicon-home");
                    printNavigationLink("acp_news.php", "Beitr&auml;ge", "glyphicon-inbox");
                    printNavigationLink("acp_contents.php", "Inhalte", "glyphicon-file");
                    printNavigationLink("acp_rules.php", "Regeln", "glyphicon-book");
                    printNavigationLink("acp_user.php", "Benutzer", "glyphicon-user");
                    printNavigationLink("acp_multiaccounts.php", "Multiaccounts", "glyphicon-eye-open");
                    printNavigationLink("acp_finances.php", "Finanzen", "glyphicon-usd");
                    printNavigationLink("acp_statistics.php", "Statistiken", "glyphicon-tasks");
                    printNavigationLink("acp_server_monitor.php", "Server-Monitor", "glyphicon-flash");
                    printNavigationLink("acp_applications.php", "Bewerbungen", "glyphicon-folder-open");
                    printNavigationLink("acp_support.php", "Supportbereich", "glyphicon-comment", $db->count("support_tickets", "status != 2"));
                    printNavigationLink("acp_complaints.php", "Beschwerden", "glyphicon-bullhorn", $db->count("complaints", "status != 2"));

                if ($handle = opendir('navigation')) {
                    while (false !== ($file = readdir($handle))) {
                        if (strpos($file, "acp_") === 0) {
                            include_once("./navigation/$file");
                        }
                    }
                    closedir($handle);
                }
                ?>
            </ul>
            <ul class="nav nav-sidebar">
                <?php
                    printNavigationLink("acp_log.php", "Aktivitätenprotokoll", "glyphicon-align-justify");
                    printNavigationLink("acp_dbconfig.php", "Datenbank-Konfiguration", "glyphicon-cloud-upload");
                    printNavigationLink("acp_teamspeak.php", "TeamSpeak", "glyphicon-headphones");
                    printNavigationLink("acp_factions.php", "Fraktionen & Leader", "glyphicon-list-alt");
                    printNavigationLink("acp_permissions.php", "Berechtigungen", "glyphicon-exclamation-sign");
                    printNavigationLink("acp_settings.php", "Einstellungen", "glyphicon-cog");
                ?>
            </ul>
        </div>
