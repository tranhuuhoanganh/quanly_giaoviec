<?php
session_start();
// Config
error_reporting(0);
include('config.php');
// class gold ly
include('class_manage.php');
// Class manage Variable
$tlca_do = new class_manage;
// Template Variable
$skin = $tlca_do->skin;
$class_member = $tlca_do->load('class_member');
$ip_address=$_SERVER['REMOTE_ADDR'];
?>