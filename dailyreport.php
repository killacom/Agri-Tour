<?php
//DAILY REPORT FOR AGRI-TOURISM RESERVATION SYSTEM
//HOLDER HILL  VERSION
//THOMAS PORTER 2018-2021 - THOMAS.PORTER.1991@GMAIL.COM

//check login
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('location: login.php');
    exit;
}

//includes
require_once 'config.php';

//variables
$m = intval(date('n'));
$d = intval(date('j'));
$y = intval(date('Y'));
$season_num_day = season_num_day($m,$d); //get season number of current date
$date = $m."/".$d.'/'.$y;
$report_kids = 0;
$report_teachers = 0;
$report_adults = 0;
$report_reservations = 0;
$year_kids = 0;
$year_teachers = 0;
$year_adults = 0;
$year_reservations = 0;
$season_kids = 0;
$season_teachers = 0;
$season_adults = 0;
$season_reservations = 0;
$season_season = 0;
$season_y = $y;
$tpeople = 0;
$rescount = 0;
$reservations = '';
$next_year_adults = $next_year_kids = $next_year_reservations = $next_year_teachers = 0 ;


//use submitted date range if there is one
if (isset($_POST['sent'])) {
	$start_m = intval($_POST['start_month']);
	$start_d = intval($_POST['start_day']);
	$start_y = intval($_POST['start_year']);
	$end_m = intval($_POST['end_month']);
	$end_d = intval($_POST['end_day']);
	$end_y = intval($_POST['end_year']);
}

//else use season as date range
else{
	if($season_num_day==0){
		//If current date is before spring opening date, set start date to opening date
		$start_m = $spring_opening_month;
		$start_d = $spring_opening_day;
		$start_y = $y;
		$end_m = $spring_closing_month;
		$end_d = $spring_closing_day;
		$end_y = $y;
	}
	elseif($season_num_day==1){
		//current date is during spring season; set start date to today
		$start_m = $m;
		$start_d = $d;
		$start_y = $y;
		$end_m = $spring_closing_month;
		$end_d = $spring_closing_day;
		$end_y = $y;
	}
	elseif($season_num_day==2){
		//current date is between spring and fall; start at fall
		$start_m = $fall_opening_month;
		$start_d = $fall_opening_day;
		$start_y = $y;
		$end_m = $fall_closing_month;
		$end_d = $fall_closing_day;
		$end_y = $y;
	}
	elseif($season_num_day==3){
		//date is during fall season; start date today
		$start_m = $fall_opening_month;
		$start_d = $fall_opening_day;
		$start_y = $y;
		$end_m = $spring_closing_month;
		$end_d = $spring_closing_day;
		$end_y = $y;
	}
	elseif($season_num_day==4){
		//date is after fall, set to spring of next year
		$start_m = $spring_opening_month;
		$start_d = $spring_opening_day;
		$start_y = $y+1;
		$end_m = $spring_closing_month;
		$end_d = $spring_closing_day;
		$end_y = $y+1;
	}
}
$end_date = $end_m."/".($end_d+1)."/".$end_y;
$curr_m = $start_m;
$curr_d = $start_d;
$curr_y = $start_y;
$currdate = $curr_m."/".$curr_d.'/'.$curr_y;

//get season totals
$sql = 'SELECT num_children, num_teachers, num_adults, requested_month, requested_day FROM reservations WHERE res_year = '.$curr_y; 
if ($result = $link->query($sql)){
    while ($row = $result->fetch_assoc()){
        $kids = intval($row['num_children']);
        $teachers = intval($row['num_teachers']);
        $adults = intval($row['num_adults']);
        $req_mon = intval($row['requested_month']);
        $req_day = intval($row['requested_day']);
        if (season_num($req_mon)==season_num($curr_m)){
            $season_kids = $season_kids + $kids;
            $season_teachers = $season_teachers + $teachers;
            $season_adults = $season_adults + $adults;
            $season_reservations++;
			$season_y = $curr_y;
			$season_m = $curr_m;
			$season_season=season($season_m, $curr_d);
        }
    }
}

//get year totals
$sql = 'SELECT num_children, num_teachers, num_adults FROM reservations WHERE res_year = '.$y;
if ($result = $link->query($sql)){
    while ($row = $result->fetch_assoc()){
        $kids = intval($row['num_children']);
        $teachers = intval($row['num_teachers']);
        $adults = intval($row['num_adults']);
        $year_kids = $year_kids + $kids;
        $year_teachers = $year_teachers + $teachers;
        $year_adults = $year_adults + $adults;
        $year_reservations++;
    }
}

//get next year totals
$next_y=$y+1;
$sql = 'SELECT num_children, num_teachers, num_adults FROM reservations WHERE res_year = '.$next_y;
if ($result = $link->query($sql)){
    while ($row = $result->fetch_assoc()){
        $kids = intval($row['num_children']);
        $teachers = intval($row['num_teachers']);
        $adults = intval($row['num_adults']);
        $next_year_kids = $next_year_kids + $kids;
        $next_year_teachers = $next_year_teachers + $teachers;
        $next_year_adults = $next_year_adults + $adults;
        $next_year_reservations++;
    }
}

//make sure end date is after start date
if ((($start_m==$end_m && $end_d<$start_d)||($start_m>$end_m && $start_y==$end_y))||$start_y>$end_y) {
    $reservations = '<tr><td colspan=10 align=center><span class=error align=center>The end date cannot be before the start date!</span></td></tr>';
}
else {
	while ($currdate != $end_date) {
        $daycount = daycount($curr_m); 
        $sql = 'SELECT * FROM reservations WHERE res_year = "'.$curr_y.'" && requested_month = "'.$curr_m.'" && requested_day = "'.$curr_d.'" ORDER BY hr24,arrival_min ASC';  
        if ($result = $link->query($sql)){   
            $tkids = 0;
            $tteachers = 0;
            $tadults = 0;
            while ($row = $result->fetch_assoc()) {
                    $kids = intval($row['num_children']);
                    $tkids = $tkids + $kids;
                    $teachers = intval($row['num_teachers']);
                    $tteachers = $tteachers + $teachers;
                    $adults = intval($row['num_adults']);
                    $tadults = $tadults + $adults;
                    $tpeople = $tpeople + $tkids + $tteachers + $tadults;
                    $report_kids = $report_kids + $kids;
                    $report_teachers = $report_teachers + $teachers;
                    $report_adults = $report_adults + $adults;
                    $report_reservations++;
                    $rescount++;
            }
        }
        if($rescount > 0) {   
            $season = season($curr_m, $curr_d);
            $day_of_week = date('l', mktime(0, 0, 0, $curr_m, $curr_d, $curr_y));
            $reservations.='<tr><td colspan=10><table width = 100%>';
            $reservations.='
                <tr>
                    <th colspan=2 align=center class=date>'.$day_of_week.', '.$currdate.'</th><th class=date>'.$tkids.'</th><th class=date>'.$tteachers.'</th><th class=date>'.$tadults.'</th><th colspan=4 align=center>'.$season.'</th>
                </tr>
                <tr>
                    <th width=25%>School Name</th>
                    <th width=10%>Time Reserved</th>
                    <th width=5%>Kids</th>
                    <th width=5%>Teachers</th>
                    <th width=5%>Adults</th>
                    <th width=20%>Contact Name</th>
                    <th width=20>Contact Phone</th>
                    <th width=5%>Edit</th>
                    <th width=5%>Delete</th>
                </tr>';
            if ($result = $link->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $id = intval($row['id']);
                    $sent_time = $row['sent_time'];
                    $school_name = $row['school_name'];
                    $arrival_time = $row['arrival_time'];
                    $date = $row['requested_date'];
                    $kids = intval($row['num_children']);
                    $teachers = intval($row['num_teachers']);
                    $adults = intval($row['num_adults']);
                    $teacher_name = $row['contact_person'];
                    $cp = $row['contact_phone'];
                    $ph1 = substr($cp,0,3);
                    $ph2 = substr($cp,3,3);
                    $ph3 = substr($cp,6,4);
                    $contact_phone = '('.$ph1.') '.$ph2.'-'.$ph3;
                    $reservations.='
                    <tr>
                        <td><a href="view_res.php?id='.$id.'" target="_blank">'.$school_name.'</a></td>
                        <td align=center>'.$arrival_time.'</td>
                        <td align=center>'.$kids.'</td>
                        <td align=center>'.$teachers.'</td>
                        <td align=center>'.$adults.'</td>
                        <td align=center>'.$teacher_name.'</td>
                        <td align=center>'.$contact_phone.'</td>
                        <td align=center>
                            <form action=admineditres.php method=post>
                            <input type=hidden name=id value='.$id.' />
                            <input type=image src="images/b_edit.png" onsubmit="submit-form();">
                            </form>
                        </td>
                        <td align=center>
                            <form action="drop_res.php" method="post">
                            <input type="hidden" name="id" value="'.$id.'" />
                            <input type="image" src="images/b_drop.png" onsubmit="submit-form();">
                            </form>
                        </td>
                    </tr>'; 
                }
            $reservations.='
                            </table>
                        </td>
                    </tr>
                <tr>
            <td colspan=10>&nbsp;</td>
        </tr>
           ';
            }
        $rescount=0;
        }
    if ($curr_m == 12 && $curr_d == $daycount) { //last day of the year
            //go to jan 1 of next year
			$curr_y++;
            $curr_m=1;
            $curr_d=1;
        }
    elseif ($curr_d == $daycount) { //last day of month
            //go to next month
            $curr_m++;
            $curr_d=1;
        }
    else {
        $curr_d++;
    }
    $currdate = $curr_m.'/'.ltrim($curr_d, '0').'/'.$curr_y;
    $currdate = ltrim($currdate, '0');
}
    $reservations.='<tr><td colspan=10>&nbsp;</td></tr>';
    $reservations.='<tr><td colspan=10>&nbsp;</td></tr>';
    $reservations.='<tr><td colspan=10>
            <table width = 100%>
                <tr>
                    <th colspan=2 align=center class=date>Report Totals</th>
                    <th class=date>'.$report_kids.'</th>
                    <th class=date>'.$report_teachers.'</th>
                    <th class=date>'.$report_adults.'</th>
                    <th class=date>'.$report_reservations.'</th>
                    <th colspan=3 align=center>&nbsp;</th>
                </tr>
                <tr>
                    <th width=35% colspan=2>'.$start_m.'/'.$start_d.'/'.$start_y.' through '.$end_m.'/'.$end_d.'/'.$end_y.'</th>
                    <th width=5%>Kids</th>
                    <th width=5%>Teachers</th>
                    <th width=5%>Adults</th>
                    <th width=10%>Reservations</th>
                    <th width=40% colspan=3>&nbsp;</th>
                </tr>
            </table></td></tr>';
    $reservations.='<tr><td colspan=10>&nbsp;</td></tr>';
    $reservations.='<tr><td colspan=10>
            <table width = 100%>
                <tr>
                    <th colspan=2 align=center class=date>'.$season_y.' '.$season_season.' Totals</th>
                    <th class=date>'.$season_kids.'</th>
                    <th class=date>'.$season_teachers.'</th>
                    <th class=date>'.$season_adults.'</th>
                    <th class=date>'.$season_reservations.'</th>
                    <th colspan=3 align=center>&nbsp;</th>
                </tr>
                <tr>
                    <th width=35% colspan=2>&nbsp;</th>
                    <th width=5%>Kids</th>
                    <th width=5%>Teachers</th>
                    <th width=5%>Adults</th>
                    <th width=10%>Reservations</th>
                    <th width=40% colspan=3>&nbsp;</th>
                </tr>
            </table></td></tr>';
    $reservations.='<tr><td colspan=10>&nbsp;</td></tr>';
    $reservations.='<tr><td colspan=10>
            <table width = 100%>
                <tr>
                    <th colspan=2 align=center class=date>'.$y.' Totals</th>
                    <th class=date>'.$year_kids.'</th>
                    <th class=date>'.$year_teachers.'</th>
                    <th class=date>'.$year_adults.'</th>
                    <th class=date>'.$year_reservations.'</th>
                    <th colspan=3 align=center>&nbsp;</th>
                </tr>
                <tr>
                    <th width=35% colspan=2>&nbsp;</th>
                    <th width=5%>Kids</th>
                    <th width=5%>Teachers</th>
                    <th width=5%>Adults</th>
                    <th width=10%>Reservations</th>
                    <th width=40% colspan=3>&nbsp;</th>
                </tr>
            </table></td></tr>';
	$reservations.='<tr><td colspan=10>&nbsp;</td></tr>';
    $reservations.='<tr><td colspan=10>
            <table width = 100%>
                <tr>
                    <th colspan=2 align=center class=date>'.$next_y.' Totals</th>
                    <th class=date>'.$next_year_kids.'</th>
                    <th class=date>'.$next_year_teachers.'</th>
                    <th class=date>'.$next_year_adults.'</th>
                    <th class=date>'.$next_year_reservations.'</th>
                    <th colspan=3 align=center>&nbsp;</th>
                </tr>
                <tr>
                    <th width=35% colspan=2>&nbsp;</th>
                    <th width=5%>Kids</th>
                    <th width=5%>Teachers</th>
                    <th width=5%>Adults</th>
                    <th width=10%>Reservations</th>
                    <th width=40% colspan=3>&nbsp;</th>
                </tr>
            </table></td></tr>';
}
mysqli_close($link);

$pagetitle= 'Daily Report - '.$farm_name;
require_once 'header.php';
require_once 'adminnav.php';
if ($start_y==$y){$syi=0;}
else if ($start_y==($y+1)){$syi=1;}
if ($end_y==$y){$eyi=0;}
else if ($end_y==($y+1)){$eyi=1;}
?>
<table width=100% align=center>
        <tr><th class=date colspan=10 ><span id=main><?php echo $farm_name; ?> Daily Report</span></th></tr>
        <tr><td align=center><div class=ybsm>Hello Farm Staff! <br />Please contact me (Thomas Porter) for any issues or requested updates regarding the reservation system.<br />
			Phone: 919-699-4841 (Texting preferred) or email at thomas.porter.1991@gmail.com. Thanks!</div></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td align=center>Reservations for current or coming season (if currently off-season) shown. Select a date range below to see more.</td></tr>
        <tr>
            <td align=center>
                <form action='dailyreport.php' method=post name='dateform'>        
                <select name=start_month id=start_month>
                    <?     
                    $sm = 1;
                    while ($sm != 13)
                    {
                        $sm_name = getmonthname($sm);
                        echo '<option '; if($start_m==$sm){echo'selected=selected ';}  echo 'value='.$sm.'>'.$sm_name.'</option>';
                        $sm++;
                    }
                    ?>
                </select>
                <select name=start_day id=start_day>
                </select>
				<select name=start_year id=start_year>
					<option selected=selected value=<? echo $y; ?>><? echo $y; ?></option>
					<option value=<? echo $y+1; ?>><? echo $y+1; ?></option>
				</select>
                     through 
                <select name=end_month id=end_month>
                    <?     
                    $em = 1;
                    while ($em != 13)
                    {
                        $em_name = getmonthname($em);
                        echo '<option '; if($end_m==$em){echo'selected=selected ';}  echo 'value='.$em.'>'.$em_name.'</option>';
                        $em++;
                    }
                    ?>
                </select>
                <select name=end_day id=end_day>
                </select>
				<select name=end_year id=end_year>
					<option selected=selected value=<? echo $y; ?>><? echo $y; ?></option>
					<option value=<? echo $y+1; ?>><? echo $y+1; ?></option>
				</select>
                <input type=submit class=button name=sent value='Go!'>
                </form>
            </td>
        </tr>
        <? echo $reservations; ?>
        </table>
<script type="text/javascript"> 
document.forms['dateform'].elements['start_month'].onchange = function(e) {
    var relName = 'start_day';
    var relList = this.form.elements[ relName ];
    var obj = Select_List_Data[ relName ][ this.value ];
    removeAllOptions(relList, true);
    appendDataToSelect(relList, obj);
};
document.forms['dateform'].elements['end_month'].onchange = function(e) {
    var relNameEnd = 'end_day';
    var relListEnd = this.form.elements[ relNameEnd ];
    var objEnd = Select_List_Data_End[ relNameEnd ][ this.value ];
    removeAllOptions(relListEnd, true);
    appendDataToSelect(relListEnd, objEnd);
};
var Select_List_Data = 
{
    'start_day': 
    {
        <? echo $month_switcher; ?>
    }
};
var Select_List_Data_End = 
{
    'end_day': 
    {
        <? echo $month_switcher; ?>
    }
};   
window.onload = function() {
	
    var form = document.forms['dateform'];
	var yel = form.elements['start_year'];
    yel.selectedIndex = <? echo $syi; ?>;
    var sel = form.elements['start_month'];
    sel.selectedIndex = <? echo $start_m-1; ?>;
    var relName = 'start_day';
    var rel = form.elements[ relName ];
    var data = Select_List_Data[ relName ][ sel.value ];
    appendDataToSelect(rel, data);
    rel.selectedIndex = <? echo $start_d-1; ?>;
	
    var formEnd = document.forms['dateform'];
	var eyel = form.elements['end_year'];
    eyel.selectedIndex = <? echo $eyi; ?>;;
    var selEnd = formEnd.elements['end_month'];
    selEnd.selectedIndex = <? echo $end_m-1; ?>;
    var relNameEnd = 'end_day';
    var relEnd = formEnd.elements[ relNameEnd ];
    var dataEnd = Select_List_Data_End[ relNameEnd ][ selEnd.value ];
    appendDataToSelect(relEnd, dataEnd);
    relEnd.selectedIndex = <? echo $end_d-1; ?>;
};
</script>
<?
require_once 'footer.php';
?>
