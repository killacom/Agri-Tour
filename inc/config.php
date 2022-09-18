<?php
//INTERNAL CONFIGURATION FILE FOR AGRI-TOURISM RESERVATION SYSTEM
//THOMAS PORTER 2018-2022 - THOMAS.PORTER.1991@GMAIL.COM

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$ROOT = realpath('./../../dbconfig/');
$dbconfig = $ROOT.'/agritour.php';
require_once $dbconfig;
require_once 'fns.php';
require_once 'texts.php';
$this_year = intval(date('Y'));
$sql = "SELECT * FROM `settings` WHERE `index` = 1"; 
if ($result = $link->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $farm_name = $row['farm_name'];
        $max_kids = intval($row['max_kids']);
        $max_kids_length = strlen(strval($max_kids));
        $day_max_kids = intval($row['day_max_kids']);
        $orange_margin = intval($row['orange_margin']);
        $confirmation_body = $row['confirmation_body'];
        $master_password = $row['master_password'];
        $site_url = $row['site_url'];
        $admin_email = $row['admin_email'];
        $admin_email_cc = $row['admin_email_cc'];
        $admin_email_bcc = $row['admin_email_bcc'];
        $spring_opening_day = $row['spring_opening_day'];
        $spring_opening_month = $row['spring_opening_month'];
        $spring_closing_day = $row['spring_closing_day'];
        $spring_closing_month = $row['spring_closing_month'];
        $spring_open_hour = $row['spring_open_hour'];
        $spring_open_min = $row['spring_open_min'];
        $spring_close_hour = $row['spring_close_hour'];
        $spring_close_min = $row['spring_close_min'];
        $fall_opening_day = $row['fall_opening_day'];
        $fall_opening_month = $row['fall_opening_month'];
        $fall_closing_day = $row['fall_closing_day'];
        $fall_closing_month = $row['fall_closing_month'];
        $fall_open_hour = $row['fall_open_hour'];
        $fall_open_min = $row['fall_open_min'];
        $fall_close_hour = $row['fall_close_hour'];
        $fall_close_min = $row['fall_close_min'];
    }
    $som = $spring_opening_month;
    $scm = $spring_closing_month;
    $sod = $spring_opening_day;
    $scd = $spring_closing_day;
    $fom = $fall_opening_month;
    $fcm = $fall_closing_month;
    $fod = $fall_opening_day;
    $fcd = $fall_closing_day;
}
?>