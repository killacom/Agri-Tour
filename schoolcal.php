<?
//SCHOOL CALENDAR (SEE WHOS COMING) FOR AGRI-TOURISM RESERVATION SYSTEM
//PAGE FARMS VERSION
//THOMAS PORTER 2018-2019 - THOMAS.PORTER.1991@GMAIL.COM
require_once 'config.php';
$pagetitle= 'Field Trip Calendar';
require_once 'header.php';
$date = time () ; 
$day = date('d', $date);
if (isset($_GET['m'])) {$month = $_GET['m'];} else {$month = date('m', $date); }
if ($month < $spring_opening_month) {$month=$spring_opening_month;}
if (isset($_GET['y'])) {$year = $_GET['y'];} else {$year = date('Y', $date);} 
$first_day = mktime(0,0,0,$month, 1, $year); 
$title = date('F', $first_day); 
$day_of_week = date('D', $first_day); 
switch($day_of_week)
{ 
    case 'Sun': $blank = 0; break; 
    case 'Mon': $blank = 1; break; 
    case 'Tue': $blank = 2; break; 
    case 'Wed': $blank = 3; break; 
    case 'Thu': $blank = 4; break; 
    case 'Fri': $blank = 5; break; 
    case 'Sat': $blank = 6; break; 
}
$days_in_month = cal_days_in_month(0, $month, $year); ?>
<table border=1 cellpadding=0 cellspacing=0 align=center width=800px>
<tr><th width=100>
<? link_prev_month_school($month, $year); ?>
</th><th colspan=5 class=header> <? echo $title.' '.$year ?></th><th width=100>
<? link_next_month_school($month, $year); ?>
</th></tr>
<tr><th width=100>Sunday</th><th width=100>Monday</th><th width=100>Tuesday</th>
    <th width=100>Wednesday</th><th width=100>Thursday</th><th width=100>Friday</th>
    <th width=100>Saturday</th></tr>
<tr height=50 valign=top>
<? $day_count = 1;
$reservations ='';
while ( $blank > 0 ) 
{ 
    echo '<td></td>'; 
    $blank = $blank-1; 
    $day_count++;
} 
$day_num = 1;
$season = season_num($month);
if ($season <= 2){$hour_num = $spring_open_hour;}
elseif($season > 2){$hour_num = $fall_open_hour;}
while ( $day_num <= $days_in_month ) 
	{ 
	echo '<td height=75 valign=top align=center><table class=white width=100%><tr><th>'.$day_num.'</th></tr><tr><td>';
    while ( $hour_num != 7 ) 
		{	
			if (intval($hour_num) > 5 && intval($hour_num) < 12) {$amorpm='A.M.';} else {$amorpm='P.M.';}
			$num_children = 0;
			$sql = 'SELECT * FROM reservations WHERE res_year = '.$year.' && requested_day = '.$day_num.' && requested_month = '.$month.' && arrival_hour = '.$hour_num;
			if ($result = $link->query($sql))
            {
                while ($row = $result->fetch_assoc())
                {  
                    $school_name = $row['school_name'];
                    $reservations.= '<tr><td>•&nbsp;'.$school_name.'</td></tr>';
                }
            }   
            if ($arrival_min==0){$arrival_min='00';}
            echo '<table cellpadding=0 cellspacing=0 border=0 class=white width=100%>'.$reservations.'</table>' ;
            $hour_num++;
            $reservations ='';
            if ($hour_num==13) { $hour_num=1; }
        }
	$hour_num = 9;
	echo '</td></tr></table></td>'; 
	$day_num++; 
	$day_count++;
	if ($day_count > 7)
	{
	echo '</tr><tr>';
	$day_count = 1;
	}
} 
while ( $day_count >1 && $day_count <=7 ) 
{ 
    echo '<td> </td>'; 
    $day_count++; 
} 
echo '</tr></table>'; 
require_once 'footer.php';
?>