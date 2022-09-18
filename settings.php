<?php
//SETTINGS PAGE FOR AGRI-TOURISM RESERVATION SYSTEM
//THOMAS PORTER 2018-2021 - THOMAS.PORTER.1991@GMAIL.COM
session_start();
require_once 'config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
$pagetitle='Administrator Settings';
require_once 'header.php';
require_once 'adminnav.php';
$end_message = '';

if (isset($_POST['sent'])) { 
    $farm_name_new = $_POST['farm_name_new'];
    $spring_opening_month_new = intval($_POST['spring_opening_month_new']);
    $spring_opening_day_new = intval($_POST['spring_opening_day_new']);	
    $spring_closing_month_new = intval($_POST['spring_closing_month_new']);
    $spring_closing_day_new = intval($_POST['spring_closing_day_new']);
    $spring_open_hour_new = intval($_POST['spring_open_hour_new']);
    $spring_open_min_new = intval($_POST['spring_open_min_new']);
    $spring_close_hour_new = intval($_POST['spring_close_hour_new']);
    $spring_close_min_new = intval($_POST['spring_close_min_new']);
    $fall_opening_month_new = intval($_POST['fall_opening_month_new']);
    $fall_opening_day_new = intval($_POST['fall_opening_day_new']);	
    $fall_closing_month_new = intval($_POST['fall_closing_month_new']);
    $fall_closing_day_new = intval($_POST['fall_closing_day_new']);
    $fall_open_hour_new = intval($_POST['fall_open_hour_new']);
    $fall_open_min_new = intval($_POST['fall_open_min_new']);
    $fall_close_hour_new = intval($_POST['fall_close_hour_new']);
    $fall_close_min_new = intval($_POST['fall_close_min_new']);
    $max_kids_new = intval($_POST['max_kids_new']);
    $day_max_kids_new = intval($_POST['day_max_kids_new']);
    $orange_margin_new = intval($_POST['orange_margin_new']);
    $site_url_new = $_POST['site_url_new'];	
    $admin_email_new = $_POST['admin_email_new'];
    $admin_email_cc_new = $_POST['admin_email_cc_new'];
    $admin_email_bcc_new = $_POST['admin_email_bcc_new'];
    $confirmation_body_new = $_POST['confirmation_body_new'];
    if (!($stmt = $link->prepare("UPDATE `settings` SET `farm_name` = ?, `spring_opening_month` =  ?, `spring_opening_day` =  ?, `spring_closing_month` =  ?, `spring_closing_day` =  ?, `spring_open_hour` =  ?, `spring_open_min` =  ?, `spring_close_hour` =  ?, `spring_close_min` =  ?, `fall_opening_month` =  ?, `fall_opening_day` =  ?, `fall_closing_month` =  ?, `fall_closing_day` =  ?, `fall_open_hour` =  ?, `fall_open_min` =  ?, `fall_close_hour` =  ?, `fall_close_min` =  ?, `max_kids` =  ?, `day_max_kids` =  ?, `orange_margin` =  ?, `confirmation_body` =  ?, `site_url` =  ?, `admin_email` =  ?, `admin_email_cc` = ?, `admin_email_bcc` = ?  WHERE `index`=1 LIMIT 1 "))) {
        echo "Prepare failed: (" . $link->errno . ") " . $link->error; 
    } else {
        $stmt->bind_param("siiiiiiiiiiiiiiiiiiisssss", $farm_name_new, $spring_opening_month_new, $spring_opening_day_new, $spring_closing_month_new, $spring_closing_day_new, $spring_open_hour_new, $spring_open_min_new, $spring_close_hour_new, $spring_close_min_new, $fall_opening_month_new, $fall_opening_day_new, $fall_closing_month_new, $fall_closing_day_new, $fall_open_hour_new, $fall_open_min_new, $fall_close_hour_new, $fall_close_min_new, $max_kids_new, $day_max_kids_new, $orange_margin_new, $confirmation_body_new, $site_url_new, $admin_email_new, $admin_email_cc_new, $admin_email_bcc_new);
        if($stmt->execute()) {
            $end_message = "Settings updated sucessfully!";
            $farm_name = $farm_name_new;
            $max_kids = $max_kids_new;
            $day_max_kids = $day_max_kids_new;
            $orange_margin = $orange_margin_new;
            $confirmation_body = $confirmation_body_new;
            $site_url = $site_url_new;
            $admin_email = $admin_email_new;
            $admin_email_cc = $admin_email_cc_new;
            $admin_email_bcc = $admin_email_bcc_new;
            $spring_opening_day = $spring_opening_day_new;
            $spring_opening_month = $spring_opening_month_new;
            $spring_closing_day = $spring_closing_day_new;
            $spring_closing_month = $spring_closing_month_new;
            $spring_open_hour = $spring_open_hour_new;
            $spring_open_min = $spring_open_min_new;
            $spring_close_hour = $spring_close_hour_new;
            $spring_close_min = $spring_close_min_new;
            $fall_opening_day = $fall_opening_day_new;
            $fall_opening_month = $fall_opening_month_new;
            $fall_closing_day = $fall_closing_day_new;
            $fall_closing_month = $fall_closing_month_new;
            $fall_open_hour = $fall_open_hour_new;
            $fall_open_min = $fall_open_min_new;
            $fall_close_hour = $fall_close_hour_new;
            $fall_close_min = $fall_close_min_new;
            $stmt->close();
        } else {
            echo "Error updating record: " . mysqli_error($link);
        }
    }
}
?>
<body>
    <form action="settings.php" method=post>
        <table border=0 cellpadding=0 cellspacing=0 align=center>
            <tr>
                <td align=center colspan=2><h1>Farm Reservation Settings</h1></td>
            </tr>
            <tr>
                <td align=center colspan=2><div class=error><?php echo $end_message; ?></div></td>
            </tr>
            <tr>
                <td align=right><b>Farm Name: </b></td>
                <td> <input type=text name="farm_name_new" value="<?php echo $farm_name; ?>"></td>
            </tr>
            <tr>
                <td align=center colspan=2><h3>Spring Hours</h3></td>
            </tr>
            <tr>
                <td align=right width=50%><b>Spring Opening Date: </b></td>
                <td> 
                    <select name=spring_opening_month_new>
                        <option value=1 <?php if($spring_opening_month==1){echo'selected=selected';} ?>>January</option>
                        <option value=2 <?php if($spring_opening_month==2){echo'selected=selected';} ?>>February</option>
                        <option value=3 <?php if($spring_opening_month==3){echo'selected=selected';} ?>>March</option>
                        <option value=4 <?php if($spring_opening_month==4){echo'selected=selected';} ?>>April</option>
                        <option value=5 <?php if($spring_opening_month==5){echo'selected=selected';} ?>>May</option>
                        <option value=6 <?php if($spring_opening_month==6){echo'selected=selected';} ?>>June</option>
                        <option value=7 <?php if($spring_opening_month==7){echo'selected=selected';} ?>>July</option>
                        <option value=8 <?php if($spring_opening_month==8){echo'selected=selected';} ?>>August</option>
                        <option value=9 <?php if($spring_opening_month==9){echo'selected=selected';} ?>>September</option>
                        <option value=10 <?php if($spring_opening_month==10){echo'selected=selected';} ?>>October</option>
                        <option value=11 <?php if($spring_opening_month==11){echo'selected=selected';} ?>>November</option>
                        <option value=12 <?php if($spring_opening_month==12){echo'selected=selected';} ?>>December</option>
                    </select>
                    <input type=text name=spring_opening_day_new value="<?php echo $spring_opening_day; ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=right><b>Spring Closing Date: </b></td>
                <td> 
                    <select name=spring_closing_month_new>
                        <option value=1 <?php if($spring_closing_month==1){echo'selected=selected';} ?>>January</option>
                        <option value=2 <?php if($spring_closing_month==2){echo'selected=selected';} ?>>February</option>
                        <option value=3 <?php if($spring_closing_month==3){echo'selected=selected';} ?>>March</option>
                        <option value=4 <?php if($spring_closing_month==4){echo'selected=selected';} ?>>April</option>
                        <option value=5 <?php if($spring_closing_month==5){echo'selected=selected';} ?>>May</option>
                        <option value=6 <?php if($spring_closing_month==6){echo'selected=selected';} ?>>June</option>
                        <option value=7 <?php if($spring_closing_month==7){echo'selected=selected';} ?>>July</option>
                        <option value=8 <?php if($spring_closing_month==8){echo'selected=selected';} ?>>August</option>
                        <option value=9 <?php if($spring_closing_month==9){echo'selected=selected';} ?>>September</option>
                        <option value=10 <?php if($spring_closing_month==10){echo'selected=selected';} ?>>October</option>
                        <option value=11 <?php if($spring_closing_month==11){echo'selected=selected';} ?>>November</option>
                        <option value=12 <?php if($spring_closing_month==12){echo'selected=selected';} ?>>December</option>
                    </select> 
                    <input type=text name=spring_closing_day_new value="<?php echo $spring_closing_day; ?>" size=2>            
                </td>
            </tr>
            <tr>
                <td align=right><b>Spring Daily Open Time: </b></td>
                <td> 
                    <input type=text name=spring_open_hour_new value="<?php echo $spring_open_hour; ?>" size=2> : <input type=text name=spring_open_min_new value="<?php echo $spring_open_min ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=right><b>Spring Daily Close Time: </b></td>
                <td> 
                    <input type=text name=spring_close_hour_new value="<?php echo $spring_close_hour; ?>" size=2> : <input type=text name=spring_close_min_new value="<?php echo $spring_close_min ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=center colspan=2>&nbsp;</td>
            </tr>
            <tr>
                <td align=center colspan=2><h3>Fall Hours</h3></td>
            </tr>
            <tr>
                <td align=right><b>Fall Opening Date: </b></td>
                <td> 
                    <select name=fall_opening_month_new>
                        <option value=1 <?php if($fall_opening_month==1){echo'selected=selected';} ?>>January</option>
                        <option value=2 <?php if($fall_opening_month==2){echo'selected=selected';} ?>>February</option>
                        <option value=3 <?php if($fall_opening_month==3){echo'selected=selected';} ?>>March</option>
                        <option value=4 <?php if($fall_opening_month==4){echo'selected=selected';} ?>>April</option>
                        <option value=5 <?php if($fall_opening_month==5){echo'selected=selected';} ?>>May</option>
                        <option value=6 <?php if($fall_opening_month==6){echo'selected=selected';} ?>>June</option>
                        <option value=7 <?php if($fall_opening_month==7){echo'selected=selected';} ?>>July</option>
                        <option value=8 <?php if($fall_opening_month==8){echo'selected=selected';} ?>>August</option>
                        <option value=9 <?php if($fall_opening_month==9){echo'selected=selected';} ?>>September</option>
                        <option value=10 <?php if($fall_opening_month==10){echo'selected=selected';} ?>>October</option>
                        <option value=11 <?php if($fall_opening_month==11){echo'selected=selected';} ?>>November</option>
                        <option value=12 <?php if($fall_opening_month==12){echo'selected=selected';} ?>>December</option>
                    </select> 
                    <input type=text name=fall_opening_day_new value="<?php echo $fall_opening_day; ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=right><b>Fall Closing Date: </b></td>
                <td> 
                    <select name=fall_closing_month_new>
                        <option value=1 <?php if($fall_closing_month==1){echo'selected=selected';} ?>>January</option>
                        <option value=2 <?php if($fall_closing_month==2){echo'selected=selected';} ?>>February</option>
                        <option value=3 <?php if($fall_closing_month==3){echo'selected=selected';} ?>>March</option>
                        <option value=4 <?php if($fall_closing_month==4){echo'selected=selected';} ?>>April</option>
                        <option value=5 <?php if($fall_closing_month==5){echo'selected=selected';} ?>>May</option>
                        <option value=6 <?php if($fall_closing_month==6){echo'selected=selected';} ?>>June</option>
                        <option value=7 <?php if($fall_closing_month==7){echo'selected=selected';} ?>>July</option>
                        <option value=8 <?php if($fall_closing_month==8){echo'selected=selected';} ?>>August</option>
                        <option value=9 <?php if($fall_closing_month==9){echo'selected=selected';} ?>>September</option>
                        <option value=10 <?php if($fall_closing_month==10){echo'selected=selected';} ?>>October</option>
                        <option value=11 <?php if($fall_closing_month==11){echo'selected=selected';} ?>>November</option>
                        <option value=12 <?php if($fall_closing_month==12){echo'selected=selected';} ?>>December</option>
                    </select> 
                    <input type=text name=fall_closing_day_new value="<?php echo $fall_closing_day; ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=right><b>Fall Fall Daily Open Time: </b></td>
                <td> 
                    <input type=text name=fall_open_hour_new value="<?php echo $fall_open_hour; ?>" size=2> : <input type=text name=fall_open_min_new value="<?php echo $fall_open_min ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=right><b>Fall Daily Close Time: </b></td>
                <td> 
                    <input type=text name=fall_close_hour_new value="<?php echo $fall_close_hour; ?>" size=2> : <input type=text name=fall_close_min_new value="<?php echo $fall_close_min ?>" size=2>
                </td>
            </tr>
            <tr>
                <td align=center colspan=2>&nbsp;</td>
            </tr>
            <tr>
                <td align=center colspan=2><h3>Other Settings</h3></td>
            </tr>
            <tr>
                <td align=right><b>Max kids per day:</b></td>
                <td align=left> 
                    <input type=text name=day_max_kids_new value="<?php echo $day_max_kids; ?>" size=3>
                </td>
            </tr>
            <tr>
                <td align=right><b>Max kids per hour block:</b></td>
                <td align=left> 
                    <input type=text name=max_kids_new value="<?php echo $max_kids; ?>" size=3>
                </td>
            </tr>
            <tr>
                <td align=right><b>Calendar "Orange" Margin:</b></td>
                <td> 
                    <input type=text name=orange_margin_new value="<?php echo $orange_margin; ?>" size=3>
                </td>
            </tr>
            <tr>
                <td colspan=2>&nbsp;</td>
            </tr>
            <tr>
                <td align=center valign=top colspan=2><b>Confirmation Email Body:</b></td>
            </tr>
            <tr> 
                <td align=center valign=top colspan=2>
                    <textarea id=confirmation_body_new name=confirmation_body_new rows=20 cols=70>
                        <?php echo $confirmation_body; ?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td colspan=2>&nbsp;</td>
            </tr>
            <tr>
                <td align=right><b>Site URL: </b></td>
                <td> 
                    <input type=text name="site_url_new" value="<?php echo $site_url; ?>"> (Used to send edit reservation link in confirmation email.)
                </td>
            </tr>
            <tr>
                <td align=right><b>Admin Email: </b></td>
                <td> 
                    <input type=text name="admin_email_new" value="<?php echo $admin_email; ?>"> Reply to address for confirmation emails. (No automatic emails sent here)
                </td>
            </tr>
            <tr>
                <td align=right><b>Confirmation Emails CC: </b></td>
                <td> 
                    <input type=text name="admin_email_cc_new" value="<?php echo $admin_email_cc; ?>"> All customer emails will be sent here when sent to customer.
                </td>
            </tr>
            <tr>
                <td align=right><b>Confirmation Emails BCC: </b></td>
                <td> 
                    <input type=text name="admin_email_bcc_new" value="<?php echo $admin_email_bcc; ?>"> All customer emails will be BCC here.
                </td>
            </tr>
            <tr>
                <td align=center colspan=2><br />
                    <input type=submit class=button value="Submit Changes" name=sent><br /><br />
                </td>
            </tr>
        </table>
    </form>
	<script>
        CKEDITOR.replace('confirmation_body_new');
    </script>
</body>
</html>