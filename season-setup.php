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
$thisfile = 'season-setup.php';
$pagetitle = 'Season Settings';
require_once 'inc/header.php';
require_once 'inc/adminnav.php'; 
$body = '';

//check seasons table
$sql = 'SELECT * FROM `seasons`';
if ($result = $link->query($sql)){
    $rowcount=mysqli_num_rows($result);
}

//no seasons detected
if ($rowcount == 0) {
    if (isset($_POST['add_seasons'])) {
        $num_seasons_to_add  = $_POST['num_seasons_to_add'];
        //display form to add seasons
        echo $num_seasons_to_add;
    } else {
        $body = '
            No seasons found. Add some? <br>
            
        ';
    }

} else {
//or print seasons
$body =  '
    <form action="'.$thisfile.'" method="POST">
        <table>';
        for ($s = 0; ($s < $num_seasons); $s++) {
$body.=  '
            <tr>
                <td>
                    Opening Date: 
                </td>
                <td> 
                    <select name=spring_opening_month_new>';
                        for ($i = 1; $i < 12; $i++) {
                            $body.= '<option value='.$i;
                            if ($spring_opening_month==$i) {
                                $body.= ' selected=selected';
                            }
                            $body.= '>'.getmonthname($i).'</option>';
                        }
         $body.=   '</select>
                    <input type="text" name="spring_opening_day_new" value="'.$opening_day.'" size="2">
                </td>
            </tr>
            <tr>
                <td>
                    Spring Closing Date: 
                </td>
                <td> 
                    <select name="spring_closing_month_new">';
                    for ($i = 1; $i < 12; $i++) {
                        $body.= '<option value='.$i;
                        if ($spring_closing_month==$i) {
                            $body.= ' selected=selected';
                        }
                        $body.= '>'.getmonthname($i).'</option>';
                    }
            $body.= '</select> 
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
        }
    }
    $body.= '
    Number of seasons to add: 
    <form action='.$thisfile.' method="POST">
    <input type="text" name="num_seasons_to_add" size="2">
    <input type="hidden" name="add_seasons" value="true">
    <input type="submit" value="Go">
    ';
    echo $body;
    require_once 'inc/footer.php';
?>