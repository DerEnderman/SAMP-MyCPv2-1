CREATE TABLE IF NOT EXISTS `bank_transactions` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from` int(10) NOT NULL,
  `to` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `message` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_creation` datetime NOT NULL,
  `creator` varchar(45) NOT NULL,
  `perpetrator` varchar(45) NOT NULL,
  `case` varchar(45) NOT NULL,
  `info` text NOT NULL,
  `screen_1` varchar(120) NOT NULL,
  `screen_2` varchar(120) NOT NULL,
  `screen_3` varchar(120) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `conversations` (
  `message` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conversation` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text,
  `as_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`message`),
  KEY `Index 2` (`conversation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `factions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faction_1` varchar(45) NOT NULL,
  `faction_2` varchar(45) NOT NULL,
  `faction_3` varchar(45) NOT NULL,
  `faction_4` varchar(45) NOT NULL,
  `faction_5` varchar(45) NOT NULL,
  `faction_6` varchar(45) NOT NULL,
  `faction_7` varchar(45) NOT NULL,
  `faction_8` varchar(45) NOT NULL,
  `faction_9` varchar(45) NOT NULL,
  `faction_10` varchar(45) NOT NULL,
  `faction_11` varchar(45) NOT NULL,
  `faction_12` varchar(45) NOT NULL,
  `faction_13` varchar(45) NOT NULL,
  `faction_14` varchar(45) NOT NULL,
  `faction_15` varchar(45) NOT NULL,
  `faction_16` varchar(45) NOT NULL,
  `faction_17` varchar(45) NOT NULL,
  `faction_18` varchar(45) NOT NULL,
  `faction_19` varchar(45) NOT NULL,
  `faction_20` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `faction_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_creation` datetime NOT NULL,
  `creator` varchar(45) NOT NULL,
  `faction` varchar(45) NOT NULL,
  `application_text` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `creator` (`creator`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `faction_informations` (
  `faction_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(1250) NOT NULL,
  `image` varchar(1024) NOT NULL,
  PRIMARY KEY (`faction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `leader_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_creation` datetime NOT NULL,
  `creator` varchar(45) NOT NULL,
  `faction` varchar(45) NOT NULL,
  `application_text` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `creator` (`creator`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postedby` varchar(200) NOT NULL,
  `news` text NOT NULL,
  `subject` varchar(200) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `online_list` (
  `username` varchar(45) NOT NULL,
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `headline` varchar(80) NOT NULL,
  `text` text NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `supporter_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_creation` datetime NOT NULL,
  `creator` varchar(45) NOT NULL,
  `application_text` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `creator` (`creator`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `support_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL DEFAULT '0',
  `date_of_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator` int(14) NOT NULL,
  `topic` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ticket_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `user_log` (
  `user` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(19) CHARACTER SET latin1 NOT NULL,
  `ip` varchar(39) CHARACTER SET latin1 NOT NULL DEFAULT '127.0.0.1' COMMENT '39 Zeichen für IPV6',
  `extra` text COMMENT 'Für zukünftige Erweiterungen',
  PRIMARY KEY (`user`,`time`),
  KEY `action` (`action`),
  KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `news` (`id`, `postedby`, `news`, `subject`, `date`) VALUES (0, 'admin', '<font size="3pt"><b>Herzlich Willkommen in myCP 2!</b></font>\r\nDamit du dein User Control Panel nach der abgeschlossenen Installation besser individualisieren kannst, logge dich am besten ein und navigiere auf das Dashboard. Gehe in der linken Auswahl zunächst auf den Menüpunkt "<b>Einstellungen</b>". Dort hast du dann die Möglichkeit sämtliche Einstellungen zu verwalten.\r\n\r\n<i>Wende dich bei zusätzlichen Fragen einfach an das myCP 2 - Team. </i>', 'Willkommen!', 1419972698);


CREATE TABLE IF NOT EXISTS `server_monitor` (
  `date` datetime NOT NULL,
  `online` tinyint(1) NOT NULL,
  `player_online` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`date`),
  KEY `Schlüssel 2` (`player_online`),
  KEY `Schlüssel 3` (`online`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `mycp_adminranks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

CREATE TABLE IF NOT EXISTS `mycp_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mycp_permissions` (
  `id` int(11) NOT NULL,
  `is_admin_rank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `permission_target` tinytext NOT NULL,
  `permission_type` tinytext NOT NULL,
  `grant` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`,`permission_target`(100),`permission_type`(100),`grant`,`is_admin_rank`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mycp_users_to_groups` (
  `user` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`user`,`group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mycp_groups` (`id`, `name`) VALUES (1, 'Vollzugriff');
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_applications', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_applications', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_colors', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_colors', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_complaints', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_complaints', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_contents', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_contents', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_dbconfig', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_dbconfig', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_factions', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_factions', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_finances', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_finances', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_log', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_log', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_multiaccounts', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_multiaccounts', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_news', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_news', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_permissions', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_permissions', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_rules', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_rules', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_server_monitor', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_server_monitor', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_settings', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_settings', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_start', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_start', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_statistics', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_statistics', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_support', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_support', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_teamspeak', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_teamspeak', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_update', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_update', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_user', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'acp_user', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_add_rule', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_accept_leader_application', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_close_complaint', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_delete_complaint', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_reject_leader_appliaction', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_reject_supporter_appliaction', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_show_complaint', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_admin_show_leader_application', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_delete_rule', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_delete_user', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_contents', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_factions', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_rule_information', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_settings', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_TSconnection', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_ts_config', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_ts_controller', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_user', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_edit_user_accstatus', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_reset_ts_user', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_show_user', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'action_uninvite_leader', 'execute', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'admincomplaint', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'admincomplaint', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'adminticket', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'adminticket', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'dashboard', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'edit_rule', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'edit_rule', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'leader_application', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'leader_application', 'show', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'useraccount', 'edit', 1);
INSERT INTO `mycp_permissions` (`id`, `is_admin_rank`, `permission_target`, `permission_type`, `grant`) VALUES (1, 0, 'useraccount', 'show', 1);
