<?php
$title = "Aktion: Inhalte überarbeiten";
include("global.php");
require_admin();

$allowed = array('status_loginmessage', 'login_message', 'footer_content_3', 'footer_content_2', 'header_img1', 'header_img2', 'header_img3', 'header_headline1', 'header_headline2', 'header_headline3', 'header_text1', 'header_text2', 'header_text3', 'start_img1', 'start_img2', 'start_img3', 'start_headline1', 'start_headline2', 'start_headline3', 'start_text1', 'start_text2', 'start_text3',);
$config = filterInput($_POST, $allowed);
saveConfig($config);

user_log("edit_contents");
redirect("acp_contents.php?status=success");