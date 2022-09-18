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
$body = $scripts = $onload = $onchange = $monthdata = '';

//check seasons table
$sql = 'SELECT * FROM `seasons`';
if ($result = $link->query($sql)){
    $rowcount=mysqli_num_rows($result);
}

//are we adding seasons?
if (isset($_POST['add_seasons'])) {
    $num_seasons_to_add  = $_POST['num_seasons_to_add'];
    //display form to add seasons
    $body.= '
        <form action='.$thisfile.' method="POST" name="add_seasons_form" id="add_seasons_form">
            <table>
            <tr>
                <td>Season #</td><td>Season Name</td><td>Opening Date</td><td>Opening Time</td> 
            </tr>
    ';
   for ($a = 1; $a < $num_seasons_to_add+1; $a++) {
    $body.= '
                
                <tr>
                    <td>Season '.$a.'</td>
                    <td><input type="text" name="season'.$a.'name"></td>
                    <td>
                        <select name="season_'.$a.'_open_month" id="season_'.$a.'_open_month">';
                        for ($rm = 1; $rm < 13; $rm++) {
                            $body.='<option value="'.$rm.'">'.getmonthname($rm).'</option>';
                        }
                $body.= '</select>
                        <select name="season_'.$a.'_open_day" id="season_'.$a.'_open_day">
                        </select>
                </tr>
    ';
   }
    $scripts = '
        <script type="text/javascript">
    ';
    for ($i = 0; $i < $num_seasons_to_add; $i++) {
        $j=$i+1;
        
        $onchange.= "
            document.forms['add_seasons_form'].elements['season_".$j."_open_month'].onchange = function(e) {
                var relName = 'season_".$j."_open_day';
                var relList = this.form.elements[ relName ];
                var obj = Select_List_Data".$j."[ relName ][ this.value ];
                removeAllOptions(relList, true);
                appendDataToSelect(relList, obj);
            };";
        $monthdata.= "
            var Select_List_Data".$j." = {
                'season_".$j."_open_day': {
                    ".$month_switcher."
                }
            };
        ";
        $onload.= "
                var sel".$j." = form.elements['season_".$j."_open_month'];
                var relName".$j." = 'season_".$j."_open_day';
                var rel".$j." = form.elements[ relName".$j." ];
                var data".$j." = Select_List_Data".$j."[ relName".$j." ][ sel".$j.".value ];
                appendDataToSelect(rel".$j.", data".$j.");
        ";
    }
    $scripts.= $onchange.$monthdata."            
            window.onload = function() {
                var form = document.forms['add_seasons_form'];
                ".$onload." 
            };

        </script>
    ";



    $body.= '
        </table>
   </form><br><br>';
} else {

//no seasons detected
if ($rowcount == 0) {
        $body = 'No seasons found. Add some? <br>';
} else {
//or print seasons
$body =  '
    <form action="'.$thisfile.'" method="POST" name="add_seasons_form">
        <table>';
        for ($s = 1; ($s < $num_seasons); $s++) {
$body.=  '
            <tr>
                <td>
                    Opening Date: 
                </td>
                <td> 
                    <select name="season_'.$s.'_opening_month">';
                        for ($i = 1; $i < 12; $i++) {
                            $body.= '<option value='.$i;
                            if ($spring_opening_month==$i) {
                                $body.= ' selected=selected';
                            }
                            $body.= '>'.getmonthname($i).'</option>';
                        }
         $body.=   '</select>
                    <select name="season_'.$s.'_opening_month" id="season_'.$s.'_opening_month">
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Closing Date: 
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
}
    echo $body;
    require_once 'inc/footer.php';

echo $scripts;

?>

