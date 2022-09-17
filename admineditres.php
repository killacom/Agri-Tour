<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
    header('location: login.php');
    exit;
}
if (!isset($_GET['id']) && !isset($_POST['id'])) 
{ 
    ?>
    <form action='admineditres.php' method=post>
    Please enter the reservation id to edit: <input type=text size=5 name=id /><input type=submit value='Go!'/>
    </form>
    <?
}
else 
{
    $id = $_POST['id'];
    require_once 'config.php';
    require_once 'texts.php';
    require_once 'header.php'; 
    require_once 'adminnav.php';
    $sql = 'SELECT * FROM `reservations` WHERE `id` = "'.$id.'" LIMIT 1';
    if ($result = $link->query($sql))
    {
        while ($row = $result->fetch_assoc())
        {
            $sent_time = $row['sent_time'];
            $school_name = $row['school_name'];
            $school_addr = $row['school_addr'];
            $num_children = $row['num_children'];
            $num_teachers = $row['num_teachers'];
            $num_adults = $row['num_adults'];
            $contact_person = $row['contact_person'];
            $contact_phone = $row['contact_phone'];
            $contact_ext = $row['contact_ext'];
            $alt_phone = $row['alt_phone'];
            $alt_ext = $row['alt_ext'];
            $contact_email = $row['contact_email'];
            $requested_date = $row['requested_date'];
            $requested_month = $row['requested_month'];
            $requested_day = $row['requested_day'];
            $arrival_time = $row['arrival_time'];
            $arrival_hour = $row['arrival_hour'];
            $arrival_min = $row['arrival_min'];
            $special_needs = $row['special_needs'];
            $comments = $row['comments'];
            $oldpassword = $row['password'];
        }
    }
    $timezone = new DateTimeZone( "EST" ); 
    $date = new DateTime(); 
    $date->setTimezone( $timezone ); 
    $current_year = date('Y');
    $sent = $_POST['sent'];
    $contact_person_err = '';
    $school_name_err = '';
    $school_addr_err = '';
    $num_children_err ='';
    $num_teachers_err ='';
    $num_adults_err ='';
    $contact_phone_err = '';
    $contact_email_err = '';
    $arrival_time_err ='';
    $requested_date_err = '';
    $special_needs_err = '';
    $comments_err = '';
    $submit_err = '';
    $password = '';
    $password2 = '';
    $password_err = '';
    if ($sent)
    {
        $valid=true;
        $sent=false;
        $id = $_POST['id'];
        $contact_person = $_POST['contact_person'];
        $school_name = $_POST['school_name'];
        $school_addr = $_POST['school_addr'];
        $num_children = $_POST['num_children'];
        $num_teachers = $_POST['num_teachers'];
        $num_adults = $_POST['num_adults'];
        $contact_phone = $_POST['contact_phone'];
        $contact_ext = $_POST['contact_ext'];
        $alt_phone = $_POST['alt_phone'];
        $alt_ext = $_POST['alt_ext'];
        $contact_email = $_POST['contact_email'];
        $sendemail = $_POST['sendemail'];
        $arrival_hour = intval($_POST['arrival_hour']);
        $arrival_min = $_POST['arrival_min'];
        if ($arrival_hour > 8) {$arrival_ampm='A.M.';} else {$arrival_ampm='P.M.';}
        $arrival_time = $arrival_hour.':'.$arrival_min.' '.$arrival_ampm;
        $requested_month = $_POST['requested_month'];
        $requested_day = $_POST['requested_day'];
        $requested_date = $requested_month.'/'.$requested_day.'/'.$current_year;
        $special_needs = $_POST['special_needs'];
        $comments = $_POST['comments']; 
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if ($password!=$password2) {$password_err='Passwords do not match.'; $valid=false;}
        if (!$password && !$password2)
        {
            $password = $oldpassword;
        }
        else
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }
        if($valid)
        {    
            if (!($stmt = $link->prepare('UPDATE `reservations` SET `contact_person` =  ?, `school_name` =  ?, `school_addr` =  ?, `num_children` =  ?,
                                         `num_teachers` =  ?, `num_adults` =  ?, `contact_phone` =  ?, `contact_ext` =  ?, `alt_phone` =  ?, `alt_ext` =  ?,
                                         `contact_email` =  ?, `password` = ?, `arrival_hour` =  ?, `arrival_min` =  ?, `arrival_time` = ?, `requested_month` =  ?,
                                         `requested_day` =  ?, `requested_date` =  ?, `special_needs` =  ?, `comments` =  ?
                                         WHERE  `reservations`.`id` = ? LIMIT 1 ')))
            {
                echo 'Prepare failed: ('.$link->errno.') '.$link->error; 
            }
            else
            {
                $stmt->bind_param('sssiiissssssiisiisssi', $contact_person, $school_name, $school_addr, $num_children,
                                  $num_teachers, $num_adults, $contact_phone, $contact_ext, $alt_phone, $alt_ext,
                                  $contact_email, $password, $arrival_hour, $arrival_min, $arrival_time, $requested_month,
                                  $requested_day, $requested_date, $special_needs, $comments, $id);
                if($stmt->execute())
                {
                    if($sendemail)
                    {
                        $to      = $contact_email;
                        $subject = 'Page Farms Field Trip Edit Confirmation';
                        $message = '
                            <table width="100%" align="center" style="border: 4px solid #4CAF50">
                                <tr>
                                    <th class="date" colspan="3" style="background-color: #4CAF50;color: white;align-content: center;border: 1px solid #4CAF50;margin: 0;padding: 0;"><span id="main" style="font-size: 30px">Page Farms Reservation Confirmation</span></th>
                                </tr>
                                <tr>
                                    <td align="center" colspan="3" style="margin: 0;padding: 0;align-content: center">
                                        Hello '.$contact_person.'!<br/>
                                        This email is to confirm that you made changes to your reservation for '.$school_name.'<br />
                                        '.$confirmation_body.'<br />
                                        View your reservation details below:
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="3" style="background-color: #4CAF50;color: white;align-content: center;border: 1px solid #4CAF50;margin: 0;padding: 0;font-size: 20px">'.$school_name.' at Page Farms</th>
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
                                    <td colspan="3" align="center">If you did not make these changes please contact us at 919-451-5534 or respond to this email.</td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center" style="margin: 0;padding: 0;align-content: center"><a href="'.$site_url.'edit_res.php?id='.$id.'">Make Another Change To Your Reservation</a></td>
                                </tr>
                            </table>';
                        $headers = 'From: Page Farms <'.$admin_email.'>' . "\r\n" .
                            'Reply-To: '.$admin_email. "\r\n" .
                            'Cc: '.$admin_email_cc. "\r\n" .
                            'Bcc: '.$admin_email_bcc . "\r\n" .
                            "Content-Type: text/html; charset=\"iso-8859-1\"".
                            'X-Mailer: PHP/' . phpversion();;
                        mail($to, $subject, $message, $headers);    
                    }
                    echo '<script type="text/javascript">
                          <!--
                          window.location = "dailyreport.php"
                          -->
                          </script>';
                }
                else
                {
                    $submit_err = 'Could not edit reservation.';
                }
            } 
        } //valid
    } //sent
    ?>
    <form action='admineditres.php' method=post name=resform>
    <input type=hidden name=cyear value="<?php echo $current_year;?>">
    <input type=hidden name=id value="<?php echo $id;?>">
    <table align=center>
        <tr>
            <th colspan=2 align=center class=title>Edit Reservation</th>
        </tr>
        <tr>
            <td colspan=2 align=center>A star (<b>*</b>) denotes a required field.</td>
        </tr>
        <tr>
            <th colspan=2 align=center>The farm will be open for reservations <br />
                <? echo getmonthname($spring_opening_month).' '.$spring_opening_day.' through '
                       .getmonthname($spring_closing_month).' '.$spring_closing_day.' and <br />'
                       .getmonthname($fall_opening_month).' '.$fall_opening_day.' through '
                       .getmonthname($fall_closing_month).' '.$fall_closing_day; ?></th>
        </tr>
        <tr>
            <th colspan=2 align=center>Contact Information</th>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b>Contact Person
            </td>
            <td>
                <input type=text name=contact_person size=20 maxlength=50 value="<? echo $contact_person; ?>"/>
                <span class=error><?php echo $contact_person_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b> School/Organization Name
            </td>
            <td>
                <input type=text name=school_name size=20 maxlength=50 value="<? echo $school_name; ?>"/>
                <span class=error><?php echo $school_name_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                School/Organization Address (Street, City, Zip)
            </td>
            <td>
                <input type=text name=school_addr size=40 maxlength=80 value="<? echo $school_addr; ?>"/>
                <span class=error><?php echo $school_addr_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b> Estimated Number of Children
            </td>
            <td>
                <input type=text name=num_children size=10 maxlength="<? echo $max_kids_length ?>" value="<? echo $num_children; ?>"/>
                <span class=error><?php echo $num_children_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b> Estimated Number of Teachers
            </td>
            <td>
                <input type=text name=num_teachers size=10 maxlength=3 value="<? echo $num_teachers; ?>"/>
                <span class=error><?php echo $num_teachers_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b> Estimated Number of Adults(Other Than Teachers)
            </td>
            <td>
                <input type=text name=num_adults size=10 maxlength=3 value="<? echo $num_adults; ?>"/>
                <span class=error><?php echo $num_adults_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b> Contact Phone Number(10 digit format, no dashes)
            </td>
            <td>
                <input type=text name=contact_phone size=20 maxlength=10 value="<? echo $contact_phone; ?>"/> 
                Ext: <input type=text name=contact_ext size=5 maxlength=6 value="<? echo $contact_ext; ?>"/>
                <span class=error><?php echo $contact_phone_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                Alternate Contact Phone
            </td>
            <td>
                <input type=text name=alt_phone size=20 maxlength=10 value="<? echo $alt_phone; ?>"/> 
                Ext: <input type=text name=alt_ext size=5 maxlength=6 value="<? echo $alt_ext; ?>"/>
                <span class=error><?php echo $alt_phone_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                <b>*</b> Contact Email Address
            </td>
            <td>
                <input type=text name=contact_email size=30 maxlength=80 value="<? echo $contact_email; ?>"/> 
                <span class=error><?php echo $contact_email_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                Change Password:            
                <input type=button class=button onclick="alert('If the customer did not set a password or does not remember it you can set one for them here.')" value="?">
            </td>
            <td>
                <input type=password name=password size=30 maxlength=80 />
                <span class=error><?php echo $password_err; ?></span>
            </td>
        </tr>
        <tr>
            <td width=50% align=right>
                Confirm Password:
            </td>
            <td>
                <input type=password name=password2 size=30 maxlength=80 />             
            </td>
        </tr>
        <tr>
            <th colspan=2 align=center>Reservation</th>
        </tr>
        <tr>
            <td colspan=2 align=center>
                <input class=button type=button onClick="calpopup()" value="View Calendar for Availability">
            </td>
        </tr>
        <tr>
            <td align=right valign=middle>* Expected Arrival Time:</td>
            <td>
                <select name=arrival_hour id=arrival_hour>
                    <option <? if($arrival_hour==9){echo'selected=selected';} ?> value="9">9 AM</option>
                    <option <? if($arrival_hour==10){echo'selected=selected';} ?> value="10">10 AM</option>
                    <option <? if($arrival_hour==11){echo'selected=selected';} ?> value="11">11 AM</option>
                    <option <? if($arrival_hour==12){echo'selected=selected';} ?> value="12">12 PM</option> 
                    <option <? if($arrival_hour==1){echo'selected=selected';} ?> value="1">1 PM</option>
                    <option <? if($arrival_hour==2){echo'selected=selected';} ?> value="2">2 PM</option>
                    <option <? if($arrival_hour==3){echo'selected=selected';} ?> value="3">3 PM</option>
                    <option <? if($arrival_hour==4){echo'selected=selected';} ?> value="4">4 PM</option>
                    <option <? if($arrival_hour==5){echo'selected=selected';} ?> value="5">5 PM</option>
                </select>:&nbsp;
                <select name=arrival_min id=arrival_min>
                    <option <? if($arrival_min=="00"){echo'selected=selected';} ?> value="00">00</option>
                    <option <? if($arrival_min=="15"){echo'selected=selected';} ?> value="15">15</option>
                    <option <? if($arrival_min=="30"){echo'selected=selected';} ?> value="30">30</option>
                    <option <? if($arrival_min=="45"){echo'selected=selected';} ?> value="45">45</option>
                </select>		  
                <span class=error><?php echo $arrival_time_err; ?></span>
            </td>
            <tr>
            <td width=50% align=right>* Desired Tour Date:</td>
            <td>
                <select name=requested_month id=requested_month>
                    <option <? if($requested_month=="1"){echo'selected=selected';} ?> value="1">January</option>
                    <option <? if($requested_month=="2"){echo'selected=selected';} ?> value="2">February</option>
                    <option <? if($requested_month=="3"){echo'selected=selected';} ?> value="3">March</option>
                    <option <? if($requested_month=="4"){echo'selected=selected';} ?> value="4">April</option>
                    <option <? if($requested_month=="5"){echo'selected=selected';} ?> value="5">May</option>
                    <option <? if($requested_month=="6"){echo'selected=selected';} ?> value="6">June</option>
                    <option <? if($requested_month=="7"){echo'selected=selected';} ?> value="7">July</option>
                    <option <? if($requested_month=="8"){echo'selected=selected';} ?> value="8">August</option>
                    <option <? if($requested_month=="9"){echo'selected=selected';} ?> value="9">September</option>
                    <option <? if($requested_month=="10"){echo'selected=selected';} ?> value="10">October</option>
                    <option <? if($requested_month=="11"){echo'selected=selected';} ?> value="11">November</option>
                    <option <? if($requested_month=="12"){echo'selected=selected';} ?> value="12">December</option>
                </select>
                <select name=requested_day id=requested_day>
                </select> <?php echo $current_year; ?>
                <span class=error><?php echo $requested_date_err; ?></span>
            </td>
        </tr>
        <tr>
          <td align=right valign=top>Please let us know if you have children or adults<br />in your group that have special needs:</td>
          <td>
            <textarea name=special_needs id=special_needs rows=6 cols=38><?php echo $special_needs; ?></textarea>
            <span class=error><?php echo $special_needs_err; ?></span>
          </td>
        </tr>
        <tr>
          <td align=right valign=top>Questions or Comments:</td>
          <td>
            <textarea name=comments id=comments rows=6 cols=38><?php echo $comments; ?></textarea>
            <span class=error><?php echo $comments_err; ?></span>
          </td>  
        </tr>
        <tr>
            <th colspan=2 align=center>Submit!</th>
        </tr>
        <tr>
            <td align=center colspan=2>
                <input type=checkbox name=sendemail value="True">Send confirmation email to contact email<br>
                <input type=submit name=sent class=button value="Submit">
                <span class=error><?php echo $submit_err; ?></span>
                <br />The customer will be sent an email as well as the admin.
            </td>
        </tr>
    </table>
    </form>
    <script type="text/javascript">
    document.forms['resform'].elements['requested_month'].onchange = function(e) {
        var relName = 'requested_day';
        var relList = this.form.elements[ relName ];
        var obj = Select_List_Data[ relName ][ this.value ];
        removeAllOptions(relList, true);
        appendDataToSelect(relList, obj);
    };
    var Select_List_Data = 
    {
        'requested_day': 
        {
            <? echo $month_switcher; ?>
        }
    };
    window.onload = function() {
        var form = document.forms['resform'];
        var sel = form.elements['requested_month'];
        sel.selectedIndex = <? echo $requested_month; ?>-1;
        var relName = 'requested_day';
        var rel = form.elements[ relName ];
        var data = Select_List_Data[ relName ][ sel.value ];
        appendDataToSelect(rel, data);
        rel.selectedIndex = <? echo $requested_day; ?>-1;
    };
    </script>
    <? 
    require_once 'footer.php'; 
}
?>