<?php
//error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Field Trip Calendar</title>
        <!-- javascript to get info from make res form -->
        <script type="text/javascript">
            function returnDate(hour, mins, month, day, year) {
                opener.resform.elements["arrival_hour"].value = hour;
                opener.resform.elements["arrival_min"].value = mins;
                opener.resform.elements["requested_month"].value = month;
                opener.resform.elements["requested_day"].value = day;
                opener.resform.elements["res_year"].value = year;
                window.close()
            }
        </script>
    </head>
    <body>
    <?php 
    require_once 'inc/config.php';
    $kid_count = $_GET['kid_count'];
    $kc = intval($kid_count);
    $date = time () ; 
    $day = date('d', $date);
if (isset($_GET['m'])) {$month = $_GET['m'];} else {$month = date('m', $date); }
if ($month<$spring_opening_month) {$month=$spring_opening_month;}
if (isset($_GET['y'])) {$year = $_GET['y'];} else {$year = date('Y', $date);}  
$first_day = mktime(0,0,0,$month, 1, $year); 
$title = date('F', $first_day); 
$day_of_week = date('D', $first_day); 
switch($day_of_week){ 
case "Sun": $blank = 0; break; 
case "Mon": $blank = 1; break; 
case "Tue": $blank = 2; break; 
case "Wed": $blank = 3; break; 
case "Thu": $blank = 4; break; 
case "Fri": $blank = 5; break; 
case "Sat": $blank = 6; break; 
}
$days_in_month = cal_days_in_month(0, $month, $year) ; 
$day_count = 1;
?>
<table border=1 cellpadding=0 cellspacing=0>
    <tr>
        <th colspan=7 class="header">
            <?php echo $title.' '.$year ?>
        </th>
    </tr>
    <tr>
        <th width=100><?php link_prev_month($month, $year); ?></th>
        <th colspan=5>
            <?php echo $calendar_header_text; ?>
        </th>
        <th width=100><?php link_next_month($month, $year); ?></th>
    </tr>
    <tr><td align=center colspan=7><span class=greentext><?php echo $greentext_text; ?></span></td></tr>
    <tr><td align=center colspan=7><span class=orangetext><?php echo $orangetext_text; ?></span></td></tr>
    <tr><td align=center colspan=7><span class=error><?php echo $redtext_text; ?></span></td></tr>
    <tr><td align=center colspan=7><?php echo $calendar_message; ?></td></tr>
    <tr>
        <th width=100>Sunday</th>
        <th width=100>Monday</th>
        <th width=100>Tuesday</th>
        <th width=100>Wednesday</th>
        <th width=100>Thursday</th>
        <th width=100>Friday</th>
        <th width=100>Saturday</th>
    </tr>
    <tr height=50 valign=top>
        <?
        while ( $blank > 0 ) 
        { 
            echo '<td></td>'; 
            $blank = $blank-1; 
            $day_count++;
        }  
        $day_num = 1;
        $hour_num = 9;
        while ( $day_num <= $days_in_month ) 
        { 
            echo '<td height=50 valign=top align=center><table class=white width=100%><tr><th>'.$day_num.'</th></tr><tr><td>';
            if ($day_count > 3 && $day_count < 7)
            {
                while ( $hour_num != 12 ) 
                {
                    if (intval($hour_num) > 5 && intval($hour_num) < 12) {$amorpm="A.M.";} else {$amorpm="P.M.";}
                    $num_kids = 0;
                    $sql = "SELECT * FROM reservations WHERE res_year = '".$year."' AND requested_day = '".$day_num."' AND requested_month = '".$month."' AND arrival_hour = '".$hour_num."'";
                    if ($result = $link->query($sql))
                    {
                        while ($row = $result->fetch_assoc()) 
                        {
                             $num_kids = $num_kids + intval($row['num_children']);
                        }
                    }
                    $orange = $num_kids+$kc;
                    $max = $max_kids+$orange_margin;
		            $season = season($month, $day_num);
                    if ($orange<$max_kids) {$class="green";}
                    elseif ($orange<$max) {$class="orange";}
                    elseif ($orange>$max) {$class="red"; }
                    if ($season=="Spring" || $season=="Fall")
                    {
                        print_cal_dates($class,$hour_num,$month,$day_num,$year);
                    }
                    $hour_num++;
                    if ($hour_num==13) { $hour_num=1; }
                }
            }
            $hour_num = 9;
            echo "</td></tr></table></td>"; 
            $day_num++; 
            $day_count++;
            if ($day_count > 7)
            {
                echo "</tr><tr>";
                $day_count = 1;
            }
        } 
        while ( $day_count >1 && $day_count <=7 ) 
        { 
            echo '<td> </td>'; 
            $day_count++; 
        } 
        ?>
    </tr>
</table>
</body>
</html>