<?php

function daycount($m)
{
    if ($m==1 || $m==3 || $m==5 || $m==7 || $m==8 || $m==10 || $m==12){return 31;}
    elseif ($m==4 || $m==6 || $m==9 || $m==11){return 30;}
    elseif ($m==2){return 28;}
}
function getmonthname($m)
{
    $name ='';
    switch (intval($m)) 
    {
        case 1: $name='January'; break;        
        case 2: $name='February'; break;        
        case 3: $name='March'; break;
        case 4: $name='April'; break;
        case 5: $name='May'; break;
        case 6: $name='June'; break;
        case 7: $name='July'; break;
        case 8: $name='August'; break;
        case 9: $name='September'; break;
        case 10: $name='October'; break;
        case 11: $name='November'; break;
        case 12: $name='December'; break;
    }
    return $name;
}
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         $isValid = false;
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || 
 checkdnsrr($domain,"A")))
      {
         $isValid = false;
      }
   }
   return $isValid;
}
function link_next_month($m, $y) 
{
    global $som, $scm, $fom, $fcm, $kc;
    $next_month = intval($m)+1;
    $season = season_num($next_month);
    if($season == 2) {$next_month=$fom;}
	if ($next_month==13) {$next_month=1; $year=intval($y)+1;} else {$year=$y;}
    $date =time(); 
	$cur_year = date('Y', $date);
    $href = '<a href="calendar.php?m='.$next_month.'&y='.$year.'&kid_count='.$kc.'"><span class=twelve>Next Month</span><br /><img src="images/right.gif" width=60 height=40></a>';
	//if ($year!=intval($cur_year) || $next_month > $fcm)  { echo '&nbsp;'; } else { echo $href; }     
    echo $href;
}
function link_prev_month($m, $y) 
{
    global $som, $scm, $fom, $fcm, $kc;
	$last_month = intval($m)-1;
    $season = season_num($last_month);
    if($season == 2) {$last_month=$scm;}
	if ($last_month==0) {$last_month=12; $year=intval($y)-1;} else {$year=$y;}
	$date =time(); 
	$cur_year = date('Y', $date);
    $href = '<a href="calendar.php?m='.$last_month.'&y='.$year.'&kid_count='.$kc.'"><span class=twelve>Prev. Month</span><br /><img src="images/left.gif" width=60 height=40></a>';
	//if ($year!=intval($cur_year) || $last_month < $som) {echo '&nbsp;';} else {echo $href;}
    echo $href;
}
function link_next_month_school($m, $y) 
{
    global $som, $scm, $fom, $fcm;
	$next_month = intval($m)+1;
    $season = season_num($next_month);
    if($season == 2) {$next_month=$fom;} 
	if ($next_month==13) {$next_month=1; $year=intval($y)+1;} else {$year=$y;}
    $date =time(); 
	$cur_year = date('Y', $date);
    $href = '<a href="'.$_SERVER['PHP_SELF'].'?m='.$next_month.'&y='.$year.'"><span class=twelve>Next Month</span><br /><img src="images/right.gif" width=60 height=40></a>';
	//if ($year!=intval($cur_year) || $next_month > $fcm)  { echo "&nbsp;"; }  else { echo $href; }
    echo $href;
}
function link_prev_month_school($m, $y) 
{
    global $som, $scm, $fom, $fcm;
	$last_month = intval($m)-1;
    $season = season_num($last_month);
    if($season == 2) {$last_month=$scm;}
	if ($last_month==0) {$last_month=12; $year=intval($y)-1;} else {$year=$y;}
	$date =time(); 
	$cur_year = date('Y', $date);
    $href = '<a href="'.$_SERVER['PHP_SELF'].'?m='.$last_month.'&y='.$year.'"><span class=twelve>Prev. Month</span><br /><img src="images/left.gif" width=60 height=40></a>';
	//if ($year!=intval($cur_year) || $last_month < $som) {echo "&nbsp;";} else echo $href;
    echo $href;
}
function print_cal_dates($cl, $h, $m, $d, $y)
{
    echo "
    <table cellpadding=0 cellspacing=0 border=0 class=".$cl." width=100%>
        <tr>
            <td align=center>
                <b><a href='' onclick='returnDate(\"".$h."\", \"00\", \"".$m."\", \"".$d."\", \"".$y."\")'>".$h.":00&nbsp;A.M.</a></b>
            </td>
        </tr>
        <tr>";
        if ( $hour_num != 11) 
        {
        echo "<td align=center>
                <b><a href='' onclick='returnDate(\"".$h."\", \"30\", \"".$m."\", \"".$d."\", \"".$y."\")'>".$h.":30&nbsp;A.M.</a></b>
            </td>";
        }
    echo '</tr></table>';
}
function print_cal_dates_school($cl, $h, $m, $d)
{
    echo "
    <table cellpadding=0 cellspacing=0 border=0 class=".$cl." width=100%>
        <tr>
            <td align=center>
                <b><a href='' onclick='returnDate(\"".$h."\", \"00\", \"".$m."\", \"".$d."\")'>".$h.":00&nbsp;A.M.</a></b>
            </td>
        </tr>
        <tr>";
        if ( $hour_num != 11) 
        {
        echo "<td align=center>
                <b><a href='' onclick='returnDate(\"".$h."\", \"30\", \"".$m."\", \"".$d."\")'>".$h.":30&nbsp;A.M.</a></b>
            </td>";
        }
    echo '</tr></table>';
}
function season($m, $d)
{
    global $som, $sod, $scm, $scd, $fom, $fod, $fcm, $fcd;
    $s ='';
    
    if ($som > $m)
        {
            $s = "Off Season";
        }
    elseif ($m == $som)
    {
        if ($d >= $sod)
        {
            $s = "Spring";
        }
        else
        {
            $s = 'Off Season';
        }
    }
    elseif ($m > $som)
    {
        if ($m < $scm)
        {
            $s = "Spring";
        }
        elseif ($m == $scm)
        {
            if ($d <= $scd)
            {
                $s = "Spring";
            }
            elseif ($d > $scd)
            {
                $s = "Off Season";
            }
        }
        elseif ($m > $scm)
        {
            if ($m < $fom)
            {
                $s = "Off Season";
            }
            elseif ($m == $fom)
            {
                if ($d<$fod)
                {
                    $s = "Off Season";
                }
                elseif ($d>=$fod)
                {
                    $s = "Fall";
                }
            }
            elseif ($m > $fom)
            {
                if($m < $fcm)
                {
                    $s = "Fall";
                }
                elseif($m == $fcm)
                {
                    if ($d <= $fcd)
                    {
                        $s= "Fall";
                    }
                    elseif ($d > $fcd)
                    {
                        $s = "Off Season";
                    }
                }
                elseif($m > $fcm)
                {
                    $s = "Off Season";
                }
            }
        }
    }
    else
    {
        $s = "other";
    }
    return $s;
}
function season_num_day($m, $d)//returns int 0-4 to define season given $m for month and $d for day
{
    global $som, $sod, $scm, $scd, $fom, $fod, $fcm, $fcd;
    
    if ($som > $m)
        {
            $s = 0; //before spring
        }
    elseif ($m == $som)
    {
        if ($d >= $sod)
        {
            $s = 1; //spring
        }
        else
        {
            $s = 0; //before spring
        }
    }
    elseif ($m > $som)
    {
        if ($m < $scm)
        {
            $s = 1; //spring
        }
        elseif ($m == $scm)
        {
            if ($d <= $scd)
            {
                $s = 1; //spring
            }
            elseif ($d > $scd)
            {
                $s = 2; //between spring and fall
            }
        }
        elseif ($m > $scm)
        {
            if ($m < $fom)
            {
                $s = 2; //between spring and fall
            }
            elseif ($m == $fom)
            {
                if ($d<$fod)
                {
                    $s = 2; //between spring and fall
                }
                elseif ($d>=$fod)
                {
                    $s = 3; //fall
                }
            }
            elseif ($m > $fom)
            {
                if($m < $fcm)
                {
                    $s = 3; //fall
                }
                elseif($m == $fcm)
                {
                    if ($d <= $fcd)
                    {
                        $s= 3; //fall
                    }
                    elseif ($d > $fcd)
                    {
                        $s = 4; //after fall
                    }
                }
                elseif($m > $fcm)
                {
                    $s = 4; //after fall
                }
            }
        }
    }
    else
    {
        $s = 5; //error
    }
    return $s;
}
function season_num($m)
{
    global $som, $sod, $scm, $scd, $fom, $fod, $fcm, $fcd;
    $s ='';
    if ($som > $m)
        {
            $s = 0; //before spring
        }
    elseif ($m == $som)
    {
        $s = 1; // spring
    }
    elseif ($m > $som)
    {
        if ($m <= $scm)
        {
            $s = 1; // spring
        }
        elseif ($m > $scm)
        {
            if ($m < $fom)
            {
                $s = 2; //between
            }
            elseif ($m == $fom)
            {
                $s = 3; //fall
            }
            elseif ($m > $fom)
            {
                if($m <= $fcm)
                {
                    $s = 3; //Fall
                }
                elseif($m = $fcm)
                {
                    if($d>$fcd)
                    {
                        $s = 4; //after fall
                    }
                }
                if($m>$fcm)
                {
                    $s = 4; //after fall
                }
            }
        }
    }
    else
    {
        $s = 5; //something went wrong
    }
    return $s;
}
?>
