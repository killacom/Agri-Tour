<?php
//SEASON SETTINGS PAGE FOR AGRI-TOURISM RESERVATION SYSTEM
//THOMAS PORTER 2018-2021 - THOMAS.PORTER.1991@GMAIL.COM
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'inc/config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$pagetitle='Administrator Settings';
require_once 'inc/header.php';
require_once 'inc/adminnav.php'; 


echo '
    <form action="settings.php" method="POST">
        <table>';
echo '
            <tr>
                <td>
                    Spring Opening Date: 
                </td>
                <td> 
                    <select name=spring_opening_month_new>';
                        for ($i = 1; $i < 12; $i++) {
                            echo '<option value='.$i;
                            if ($spring_opening_month==$i) {
                                echo ' selected=selected';
                            }
                            echo '>'.getmonthname($i).'</option>';
                        }
            echo   '</select>
                    <input type="text" name="spring_opening_day_new" value="'.$spring_opening_day.'" size="2">
                </td>
            </tr>
            <tr>
                <td>
                    Spring Closing Date: 
                </td>
                <td> 
                    <select name="spring_closing_month_new">';
                    for ($i = 1; $i < 12; $i++) {
                        echo '<option value='.$i;
                        if ($spring_closing_month==$i) {
                            echo ' selected=selected';
                        }
                        echo '>'.getmonthname($i).'</option>';
                    }
              echo '</select> 
                    <input type="text" name="spring_closing_day_new" value="'.$spring_closing_day.'" size="2">            
                </td>
            </tr>
            <tr>
                <td>
                    Spring Daily Open Time: 
                </td>
                <td> 
                    <input type="text" name="spring_open_hour_new" value="'.$spring_open_hour.'" size="2"> : <input type="text" name="spring_open_min_new" value="'.$spring_open_min.'" size="2">
                </td>
            </tr>
            <tr>
                <td>
                    Spring Daily Close Time: 
                </td>
                <td> 
                    <input type="text" name="spring_close_hour_new" value="'.$spring_close_hour.'" size="2"> : <input type="text" name="spring_close_min_new" value="'.$spring_close_min.'" size="2">
                </td>
            </tr>
';













?>