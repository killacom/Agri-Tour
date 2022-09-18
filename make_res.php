<?php
//MAKE RESERVATION FOR AGRI-TOURISM RESERVATION SYSTEM
//THOMAS PORTER 2018-2022 - THOMAS.PORTER.1991@GMAIL.COM
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'inc/config.php';

$pagetitle = 'Make A Reservation - '.$farm_name;
require_once 'inc/header.php';
$thisfile = 'make_res.php';
$timezone = new DateTimeZone( "EST" ); 
$date = new DateTime(); 
$date->setTimezone( $timezone ); 
$sent_time = $date->format( 'D, d M Y H:i:s' );  
$current_year = date('Y');
$contact_first = $contact_first_err = $contact_last = $contact_last_err = $contact_person = '';
$school_name = $school_name_err = $school_addr = $school_addr_err = '';
$num_children = $num_children_err = $num_teachers = $num_teachers_err = $num_adults = $num_adults_err ='';
$contact_phone = $contact_phone_err = $contact_ext = $alt_phone = $alt_phone_err = $alt_ext = '';
$contact_email = $contact_email_err = $arrival_hour = $arrival_min = $arrival_time_err ='';
$m = intval(date('n'));
$requested_month = $m;
$d = intval(date('j'));
$requested_day = $d;
$Y = intval(date('Y'));
$res_year = $Y;
$requested_date_err = $special_needs = $special_needs_err = '';
$comments = $comments_err = $submit_err = $password = $password2 = $password_err = '';
$id = 0;

if (isset($_POST['sent']))
{
    $valid=true;
    $sent=false;
    $contact_first = $_POST['contact_first'];
    if (!$contact_first) {$contact_first_err = $contact_first_name_missing_text; $valid=false;}
	$contact_last = $_POST['contact_last'];	
    if (!$contact_last) {$contact_last_err = $contact_last_name_missing_text; $valid=false;}
	$contact_person = $contact_first." ".$contact_last;
    $school_name = $_POST['school_name'];
    if (!$school_name) {$school_name_err = $school_name_missing_text; $valid=false;}
    $school_addr = $_POST['school_addr'];
    $num_children = $_POST['num_children'];
    if (!$num_children) {$num_children_err = $num_children_missing_text; $valid=false;}
    elseif (!is_numeric($num_children)) { $num_children_err = $must_be_num_text; $valid=false;}
    $num_teachers = $_POST['num_teachers'];
    if (!$num_teachers) {$num_teachers_err = $num_teachers_missing_text; $valid=false;}
    elseif (!is_numeric($num_teachers)) { $num_teachers_err = $must_be_num_text; $valid=false;}
	$num_adults = $_POST['num_adults'];
    $contact_phone = $_POST['contact_phone'];
    if (!$contact_phone) {$contact_phone_err = $phone_missing_text; $valid=false;}
    elseif (!is_numeric($contact_phone)) { $contact_phone_err = $must_be_num_text; $valid=false;}
    elseif (strlen($contact_phone) != 10) { $contact_phone_err = $must_be_10_text; $valid=false; }
    $contact_ext = $_POST['contact_ext'];
    $alt_phone = $_POST['alt_phone'];
    if ($alt_phone != '')
    {
        if (!is_numeric($alt_phone)) { $alt_phone_err = $must_be_num_text; $valid=false; }
        elseif (strlen($alt_phone) != 10) { $alt_phone_err = $must_be_10_text; $valid=false; }
    }
    $alt_ext = $_POST['alt_ext'];
    $contact_email = $_POST['contact_email'];
    if (!$contact_email) {$contact_email_err = 'Please enter contact email.'; $valid=false;}
        elseif (!validEmail($contact_email)) {$contact_email_err = "This email address is invalid."; $valid=false;}
    $arrival_hour = intval($_POST['arrival_hour']);
	$arrival_min = $_POST['arrival_min'];
    if ($arrival_hour > 8 && $arrival_hour < 12) {$arrival_ampm="A.M."; $hr24=$arrival_hour;} else {$arrival_ampm="P.M.";if($arrival_hour<12){$hr24=$arrival_hour+12;}else{$hr24=$arrival_hour;}}
    $arrival_time = $arrival_hour.":".$arrival_min." ".$arrival_ampm;
    $requested_month = $_POST['requested_month'];
	$requested_day = $_POST['requested_day'];
    $res_year = $_POST['res_year'];
    $d1 = $d+1;
    if ($res_year==$Y && $requested_month < $m) {$requested_date_err=$too_late_text; $valid=false;}
    elseif ($res_year==$Y && $requested_month == $m && $requested_day < $d1) {$requested_date_err=$too_late_text; $valid=false;}
    $dayOfWeek = date("l", strtotime($res_year."/".$requested_month."/".$requested_day));
    
    //optional line below closing reservations Saturday - Tuesday
    //if ($dayOfWeek == "Saturday" || $dayOfWeek == "Sunday" || $dayOfWeek == "Monday" || $dayOfWeek == "Tuesday") { $requested_date_err = "We are sorry. You cannot make a reservation Saturday through Tuesday at this time."; $valid = false; }
    
    
    $season = season($requested_month, $requested_day);
    if ($season == "Off Season") {$requested_date_err=$farm_closed_text; $valid=false; }
    $requested_date = $requested_month."/".$requested_day."/".$res_year;
    $num_kids = 0;
    $sql = "SELECT num_children FROM reservations WHERE requested_day = '".$requested_day."' AND requested_month = '".$requested_month."' AND res_year = '".$current_year."' AND arrival_hour = '".$arrival_hour."'";
    if ($result = $link->query($sql))
    {
        while ($row = $result->fetch_assoc()) 
        {
            $num_kids = $num_kids + intval($row['num_children']);
        }
    }
    $max = $max_kids+$orange_margin;
    $orange = $num_kids+$kc;
    if($orange>$max) {
        {$requested_date_err=$too_booked_text; $valid=false;}
    }
    $sql = "SELECT num_children FROM reservations WHERE requested_day = '".$requested_day."' AND requested_month = '".$requested_month."' AND res_year = '".$current_year."'";
    if ($result = $link->query($sql)) {
        while ($row = $result->fetch_assoc()) 
        {
            $num_kids = $num_kids + intval($row['num_children']);
        }
    }
    if($num_kids>$day_max_kids) {
        {$requested_date_err=$too_booked_text.'---'.$num_kids.'---'.$day_max_kids; $valid=false;}
    }
    $special_needs = $_POST['special_needs'];
    $comments = $_POST['comments']; 
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if ($password!=$password2) {$password_err = $password_mismatch_text; $valid=false;}
    $password = password_hash($password, PASSWORD_DEFAULT);
    if($valid) {
        if (!($stmt = $link->prepare("insert into `reservations` (`sent_time`, `school_name`, `school_addr`, `num_children`, 
                                            `num_teachers`, `num_adults`, `contact_person`, `contact_first`, 
                                            `contact_last`, `contact_phone`, `contact_ext`, `alt_phone`, `alt_ext`,
                                            `contact_email`, `password`, `res_year`, `requested_date`, `requested_month`, 
                                            `requested_day`, `arrival_time`, `arrival_hour`, `hr24`, `arrival_min`, 
                                            `special_needs`, `comments`) 
                                        values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"))) {
           echo "Prepare failed: (" . $link->errno . ") " . $link->error; 
        }
        else {
            if (!($stmt->bind_param("sssiiisssssssssisiisiiiss", $sent_time, $school_name, $school_addr, $num_children, 
                                           $num_teachers, $num_adults, $contact_person, $contact_first, 
                                           $contact_last, $contact_phone, $contact_ext, $alt_phone, $alt_ext, 
                                           $contact_email, $password, $res_year, $requested_date, $requested_month, 
                                           $requested_day, $arrival_time, $arrival_hour, $hr24, $arrival_min, 
                                           $special_needs, $comments))) {
                echo "Binding failed: (" . $link->errno . ") " . $link->error;     
            } else {
                if (!($stmt->execute())) {
                    echo "Execution failed: (" . $link->errno . ") " . $link->error;
                };
            }
            $stmt->close();
        }
        $sql = 'SELECT id FROM reservations WHERE requested_day = ? AND requested_month = ? AND res_year = ? AND arrival_hour = ? AND school_name = ? AND num_children = ? LIMIT 1'; 
        if($stmt = $link->prepare($sql)) {
            $stmt->bind_param('iiiisi', $requested_day, $requested_month, $res_year, $arrival_hour, $school_name, $num_children);
            $stmt->execute();
            $stmt->store_result();
            $num_of_rows = $stmt->num_rows;
            if ($num_of_rows == 1) {
                $stmt->bind_result($id);
                while ($stmt->fetch()) {$id=$id;}
                $stmt->free_result();
                $stmt->close();
                $link->close();
                $to      = $contact_email;
                $subject = $farm_name.' Field Trip Confirmation Email';
                $school_name=stripslashes($school_name);
                $message = '
                    <table width="100%" align="center" style="border: 4px solid #4CAF50">
                        <tr>
                            <th class="date" colspan="3" style="background-color: #4CAF50;color: white;align-content: center;border: 1px solid #4CAF50;margin: 0;padding: 0;"><span id="main" style="font-size: 30px">'.$farm_name.' Reservation Confirmation</span></th>
                        </tr>
                        <tr>
                            <td align="center" colspan="3" style="margin: 0;padding: 0;align-content: center">
                                Hello '.$contact_person.'!<br/>
                                Thank you for making a reservation for '.$school_name.' to come vist '.$farm_name.'!<br />
                                '.$confirmation_body.'<br />
                                View your reservation details below:
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3" style="background-color: #4CAF50;color: white;align-content: center;border: 1px solid #4CAF50;margin: 0;padding: 0;font-size: 20px">'.$school_name.' at '.$farm_name.'</th>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Date and Time Submitted :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$sent_time.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">School Name :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$school_name.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">School Address :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$school_addr.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Number of Children :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$num_children.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Number of Teachers :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$num_teachers.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Number of Visiting Adults :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$num_adults.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Contact Person :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$contact_person.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Telephone(10 digit format) :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$contact_phone.$contact_ext.' </td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Alternate Phone :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$alt_phone.$alt_ext.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Email address :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$contact_email.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Tour Date Requested :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$requested_date.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Expected Arrival Time :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$arrival_time.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" valign="top" style="margin: 0;padding: 0;align-content: center">Special Needs :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$special_needs.'</td>
                        </tr>
                        <tr>
                            <td width="50%" align="right" valign="top" style="margin: 0;padding: 0;align-content: center">Questions or Comments :</td>
                            <td style="margin: 0;padding: 0;align-content: center">'.$comments.'</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">You may make changes to your reservation by clicking the link below if you created a password when you placed the reservation. If you did not make a password, call 919-451-5534 to make changes to your reservation.</td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center" style="margin: 0;padding: 0;align-content: center"><a href="'.$site_url.'edit_res.php?id='.$id.'">Make A Change To Your Reservation</a></td>
                        </tr>
                    </table>';
                $headers = 'From: '.$farm_name.' <'.$admin_email.'>' . "\r\n" .
                            'Reply-To: '.$admin_email. "\r\n" .
                            'Cc: '.$admin_email_cc. "\r\n" .
                            'Bcc: '.$admin_email_bcc . "\r\n" .
                            "Content-Type: text/html; charset=\"iso-8859-1\"".
                            'X-Mailer: PHP/' . phpversion();;
                mail($to, $subject, $message, $headers);
                echo '<script type="text/javascript">
                <!--
                window.location = "success.php?id='.$id.'"
                -->
                </script>';
            } else {
                $submit_err = "Could not make reservation. Please try again or send an email with all the requested information on this form to <a href='mailto:".$admin_email."'>.$admin_email.</a>";
            } 
        } else {
            $submit_err = "Could not make reservation. Please try again or send an email with all the requested information on this form to <a href='mailto:.$admin_email.'>.$admin_email.</a>";
        } 
    } //valid
} else { 
    $season_num_day = season_num_day($m,$d);
    $season = season(date("n"), date("j"));
    if ($season_num_day == 0) {
        $requested_day = $spring_opening_day;
        $requested_month = $spring_opening_month;
    }
    if ($season_num_day == 4){
        $requested_day = $spring_opening_day;
        $requested_month = $spring_opening_month;
        $res_year = $Y+1;
    }
}
?>
        <main>
            <form action="<?php echo $thisfile; ?>" method="POST" name="resform" class="makeres">
                <div class="section-header">Make a Reservation at <?php echo $farm_name; ?></div>
                <div class="section-header-small">The farm will be open the following dates in 2022: <br> Spring: 
                            <?php echo getmonthname($spring_opening_month).' '.$spring_opening_day.' through '
                                .getmonthname($spring_closing_month).' '.$spring_closing_day.' <br>Fall: '
                                .getmonthname($fall_opening_month).' '.$fall_opening_day.' through '
                                .getmonthname($fall_closing_month).' '.$fall_closing_day; ?></div>

                <div class="section-content-wide">A star <span class="error">*</span> denotes a required field.</div>

                <div class="section-header-small">Contact Information</div>

                <!-- first name row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="contact_first">
                            <span class="error">*</span>Contact First Name:
                        </label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="contact_first" value="<?php echo $contact_first; ?>" maxlength="40" size="12"><br>
                        <span class="error"><?php echo $contact_first_err; ?></span>
                    </div>
                </div>

                <!-- last name row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="contact_last">
                            <span class="error">*</span> Contact Last Name:
                        </label>
                    </div>
                    <div class="section-content lh">    
                        <input type="text" name="contact_last" value="<?php echo $contact_last; ?>" maxlength="40" size="12"><br>
                        <span class="error"><?php echo $contact_last_err; ?></span>
                    </div>
                </div>

                <!-- phone number row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="contact_phone">
                            <span class="error">*</span> Contact Phone Number: <br><span class="smalltext">(10 digit format, no dashes)</span>
                        </label>
                    </div>
                    <div class="section-content lh">   
                        <input type="text" name="contact_phone" value="<?php echo $contact_phone; ?>" maxlength="10" size="12">
                        <span class=error><?php echo $contact_phone_err; ?></span>
                    </div>
                    <div class="section-content rh">
                        <label for="contact_ext">Ext: </label> 
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="contact_ext" maxlength="6" value="<?php echo $contact_ext; ?>" size="6">
                    </div>
                </div>

                <!-- alt phone number row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="alt_phone">Alternate Phone Number: </label><br>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="alt_phone" value="<?php echo $alt_phone; ?>" maxlength="10" size="12"> 
                        <span class=error><?php echo $alt_phone_err; ?></span>
                    </div>
                    <div class="section-content rh">
                    <label for="alt_ext">Ext: </label>
                    </div>
                    <div class="section-content lh">
                    <input type="text" name="alt_ext" value="<?php echo $alt_ext; ?>" maxlength="6" size="6">
                    </div>
                </div>

                <!-- email row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="contact_email"><span class="error">*</span> Contact Email Address</label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="contact_email" maxlength="80" value="<?php echo $contact_email; ?>"> 
                        <span class="error"><?php echo $contact_email_err; ?></span>
                    </div>
                </div>

                <!-- password row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="password">Enter a Password: <input type="button" class="button" onclick="alert('<?php echo $make_res_pw_info; ?>')" value="?"></label>
                    </div>
                    <div class="section-content lh">
                        <input type="password" name="password" maxlength="80">
                        <span class=error><?php echo $password_err; ?></span>
                    </div>
                </div>

                <!-- confirm password row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="password2">Confirm Password:</label>
                    </div>
                    <div class="section-content lh">
                        <input type="password" name="password2" maxlength="80">  
                    </div>
                </div>

                <!-- school info header -->
                <div class="section-header-small">School/Organization Information</div>

                <!-- school name row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for=""><span class="error">*</span> School/Organization Name</label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="school_name" maxlength="50" value="<?php echo $school_name; ?>">
                        <span class="error"><?php echo $school_name_err; ?></span>
                    </div>  
                </div>

                <!-- school addr row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="school_addr">School/Organization Address <br> <span class="smalltext">(Street, City, Zip)</span></label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="school_addr" maxlength="80" value="<?php echo $school_addr; ?>">
                        <span class="error"><?php echo $school_addr_err; ?></span>
                    </div>
                </div>

                <!-- num children row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="num_children"><span class="error">*</span> Estimated Number of Children</label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="num_children" maxlength="<?php echo $max_kids_length ?>" value="<?php echo $num_children; ?>"/>
                        <span class=error><?php echo $num_children_err; ?></span>
                    </div> 
                </div>

                <!-- num teachers row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="num_teachers"><span class="error">*</span>  Estimated Number of Teachers</label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="num_teachers" maxlength="3" value="<?php echo $num_teachers; ?>"/>
                        <span class=error><?php echo $num_teachers_err; ?></span>
                    </div> 
                </div>

                <!-- num parents row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="num_adults"><span class="error">*</span> Estimated Number of Adults(Other Than Teachers)</label>
                    </div>
                    <div class="section-content lh">
                        <input type="text" name="num_adults" maxlength="3" value="<?php echo $num_adults; ?>"/>
                        <span class="error"><?php echo $num_adults_err; ?></span>
                    </div> 
                </div>

                <!-- requested date/time header -->
                <div class="section-header-small">Requested Date/Time</div>

                <!-- requested date row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="requested_month"><span class="error">*</span> Desired Tour Date</label>
                    </div>
                    <div class="section-content lh">
                        <input class="calButton button" type="button" onClick="calpopup()" value="Click To Open Calendar"><br />
                        <select name="requested_month" id="requested_month">
                        <?php  $sm = 1; 
                            while ($sm != 13) {
                                echo '<option ';if($requested_month==$sm){echo'selected=selected ';}  echo 'value='.$sm.'>'.getmonthname($sm).'</option>'; $sm++;
                            }   ?>
                        </select>
                        <select name="requested_day" id="requested_day">
                        </select> 
                        <select name='res_year' id='res_year'>
                            <?php if($res_year==$Y){echo'<option selected=selected value='.$Y.'>'.$Y.'</option>'; }?>
                            <option <?php if($res_year==$Y+1){echo'selected=selected';} ?> value="<?php echo $Y+1; ?>"><?php echo $Y+1; ?></option>
                        </select> 
                        <span class=error><?php echo $requested_date_err; ?></span>
                    </div> 
                </div> 

                <!-- arrival time row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for=""><span class="error">*</span> Expected Arrival Time</label>
                    </div>
                    <div class="section-content lh">
                        <select name="arrival_hour" id="arrival_hour">
                            <option <?php if($arrival_hour==9){echo'selected=selected';} ?> value="9">9 AM</option>
                            <option <?php if($arrival_hour==10){echo'selected=selected';} ?> value="10">10 AM</option>
                            <option <?php if($arrival_hour==11){echo'selected=selected';} ?> value="11">11 AM</option>
                            <option <?php if($arrival_hour==12){echo'selected=selected';} ?> value="12">12 PM</option> 
                            <option <?php if($arrival_hour==1){echo'selected=selected';} ?> value="1">1 PM</option>
                            <option <?php if($arrival_hour==2){echo'selected=selected';} ?> value="2">2 PM</option>
                            <option <?php if($arrival_hour==3){echo'selected=selected';} ?> value="3">3 PM</option>
                            <option <?php if($arrival_hour==4){echo'selected=selected';} ?> value="4">4 PM</option>
                            <option <?php if($arrival_hour==5){echo'selected=selected';} ?> value="5">5 PM</option>
                        </select>:
                        <select name="arrival_min" id="arrival_min">
                            <option <?php if($arrival_min=="00"){echo'selected=selected';} ?> value="00">00</option>
                            <option <?php if($arrival_min=="15"){echo'selected=selected';} ?> value="15">15</option>
                            <option <?php if($arrival_min=="30"){echo'selected=selected';} ?> value="30">30</option>
                            <option <?php if($arrival_min=="45"){echo'selected=selected';} ?> value="45">45</option>
                        </select>		  
                            <span class="error"><?php echo $arrival_time_err; ?></span>
                    </div> 
                </div>

                <!-- special needs row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="special_needs">Please let us know if you have children or adults in your group that have special needs:</label>
                    </div>
                    <div class="section-content lh">
                        <textarea name="special_needs" id="special_needs" rows="3" cols="30"><?php echo $special_needs; ?></textarea>
                        <span class="error"><?php echo $special_needs_err; ?></span>
                    </div> 
                </div>

                <!-- questions or comments row -->
                <div class="row">
                    <div class="section-content rh">
                        <label for="">Questions or Comments:</label>
                    </div>
                    <div class="section-content lh">
                        <textarea name="comments" id="comments" rows="3" cols="30"><?php echo $comments; ?></textarea>
                        <span class="error"><?php echo $comments_err; ?></span>
                    </div> 
                </div>

                <!-- submit header -->
                <div class="section-header-small">Ready to submit?</div>

                <div class="row">
                    <div class="section-content-wide">
                        <label>You should recieve a confirmation email within a few minutes. <br>
                        If you do not recieve one, you may have to check your spam folder.</label>
                    </div>
                </div>


                <div class="row">
                    <div class="section-content-wide">
                        <input type="submit" class="button" name="sent" value="Click here to book reservation!"><br>
                        <span class="error"><?php echo $submit_err; ?></span><br>
                    </div>
                </div>
            </form>
            <script type="text/javascript">
                document.forms['resform'].elements['requested_month'].onchange = function(e) {
                    var relName = 'requested_day';
                    var relList = this.form.elements[ relName ];
                    var obj = Select_List_Data[ relName ][ this.value ];
                    removeAllOptions(relList, true);
                    appendDataToSelect(relList, obj);
                };
                var Select_List_Data = {
                    'requested_day': {
                        <?php echo $month_switcher; ?>
                    }
                };
                window.onload = function() {
                    var form = document.forms['resform'];
                    var sel = form.elements['requested_month'];
                    sel.selectedIndex = <?php echo $requested_month; ?>-1;
                    var relName = 'requested_day';
                    var rel = form.elements[ relName ];
                    var data = Select_List_Data[ relName ][ sel.value ];
                    appendDataToSelect(rel, data);
                    rel.selectedIndex = <?php echo $requested_day; ?>-1;
                };
            </script>
        </main>
    </body>
</html>