<?php

$id = $_GET['id'];
require_once 'config.php';
$sql = 'SELECT * FROM reservations WHERE id = '.$id; 
if ($result = $link->query($sql))
{
    while ($row = $result->fetch_assoc())
    {
        $sent_time = $row['sent_time'];
        $school_name = $row['school_name'];
        $school_addr= $row['school_addr'];	
        $num_children = $row['num_children'];
        $num_adults = $row['num_adults'];
        $num_teachers = $row['num_teachers'];
        $num_classes = $row['num_classes'];
        $contact_person = $row['contact_person'];
        $contact_phone = $row['contact_phone'];
        $contact_ext = $row['contact_ext'];
        $alt_phone = $row['alt_phone'];
        $alt_ext = $row['alt_ext'];
        $contact_email = $row['contact_email'];
        $requested_date = $row['requested_date'];
        $arrival_time = $row['arrival_time'];
        $special_needs = $row['special_needs'];
        $comments = $row['comments'];
    }
}
if ($contact_ext>0){$contact_ext = " Ext: ".$contact_ext;}
if ($alt_ext>0){$alt_ext = " Ext: ".$alt_ext;}



$make_res_email = '
<html>
<body style="font-family: Verdana, Arial, Helvetica, sans-serif;text-indent: 10px;padding: 0;margin: 0;list-style-position: outside">
    
    <table width="100%" align="center" style="border: 4px solid #4CAF50">
        <tr><th class="date" colspan="10" style="background-color: #4CAF50;color: white;align-content: center;border: 1px solid #4CAF50;margin: 0;padding: 0;"><span id="main" style="font-size: 30px">Page Farms Reservation Confirmation</span></th></tr>
        <tr>
            <td align="center" style="margin: 0;padding: 0;align-content: center">
                Hello '.$contact_person.'!<br/>
                Thank you for making a reservation for '.$school_name.' to come vist Page Farms! <br/>
                View your reservation details below:<br/>
                <table cellpadding="0" cellspacing="0" align="center" style="border: 4px solid #4CAF50">
                    <tr>
                        <th colspan="2" align="center" class="title" style="background-color: #4CAF50;color: white;align-content: center;border: 1px solid #4CAF50;margin: 0;padding: 0;font-size: 20px">'.$school_name.' at Page Farms</th>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Date and Time Submitted :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$sent_time.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">School Name :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$school_name.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">School Address :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$school_addr.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Number of Children :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$num_children.'</td>
                    </tr>

                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Number of Teachers :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$num_teachers.'</td>
                    </tr>
                        <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Number of Visiting Adults :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$num_adults.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Contact Person :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$contact_person.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Telephone(10 digit format) :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$contact_phone.$contact_ext.' </td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Alternate Phone :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$alt_phone.$alt_ext.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Email address :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$contact_email.'</td>
                    </tr>
                    <tr>
                        <td width="50%" align="right" style="margin: 0;padding: 0;align-content: center">Tour Date Requested :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$requested_date.'</td>
                    </tr>
                    <tr>
                        <td align="right" style="margin: 0;padding: 0;align-content: center">Expected Arrival Time :  </td>
                        <td style="margin: 0;padding: 0;align-content: center">'.$arrival_time.'</td>
                  </tr>
                    <tr>
                      <td align="right" valign="top" style="margin: 0;padding: 0;align-content: center">Special Needs :  </td>
                      <td style="margin: 0;padding: 0;align-content: center">'.$special_needs.'</td>
                  </tr>
                    <tr>
                      <td align="right" valign="top" style="margin: 0;padding: 0;align-content: center">Questions or Comments :  </td>
                      <td style="margin: 0;padding: 0;align-content: center">'.$comments.'</td>
                  </tr>
                    <tr>
                        <td colspan="2" align="center" style="margin: 0;padding: 0;align-content: center"><a href="edit_res.php?id=">Make A Change To Your Reservation</a></td>
                    </tr>
                </table>
            </td></tr>
    </table>
    

    
    </body>
</html>';

echo $make_res_email;
?>