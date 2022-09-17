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
require_once 'header.php';
?>
<table cellpadding=0 cellspacing=0 align=center>
    <tr>
        <th colspan=2 align=center class=title>View Your Page Farms Reservation</th>
    </tr>
	<tr>
		<td width=50% align=right>Date and Time Submitted:&nbsp;&nbsp;</td>
		<td><?php echo $sent_time; ?></td>
	</tr>
	<tr>
		<td width=50% align=right>School Name:&nbsp;&nbsp;</td>
		<td><?php echo $school_name; ?></td>
	</tr>
	<tr>
		<td width=50% align=right>School Address:&nbsp;&nbsp;</td>
		<td><?php echo $school_addr; ?></td>
	</tr>
	<tr>
		<td width=50% align=right>Number of Children:&nbsp;&nbsp;</td>
		<td><?php echo $num_children; ?></td>
	</tr>

	<tr>
		<td width=50% align=right>Number of Teachers:&nbsp;&nbsp;</td>
		<td><?php echo $num_teachers; ?></td>
	</tr>
    	<tr>
		<td width=50% align=right>Number of Visiting Adults:&nbsp;&nbsp;</td>
		<td><?php echo $num_adults; ?></td>
	</tr>
	<tr>
		<td width=50% align=right>Contact Person:&nbsp;&nbsp;</td>
		<td><?php echo $contact_person; ?></td>
	</tr>
	<tr>
		<td width=50% align=right>Telephone(10 digit format):&nbsp;&nbsp;</td>
		<td><?php echo $contact_phone; if ($contact_ext>0){echo"x".$contact_ext;} ?></td>
	</tr>
	<tr>
		<td width=50% align=right>Alternate Phone:&nbsp;&nbsp;</td>
		<td><?php echo $alt_phone; if ($contact_ext>0){echo"x".$contact_ext;} ?></td>
	</tr>
	<tr>
		<td width=50% align=right>Email address:&nbsp;&nbsp;</td>
		<td><?php echo $contact_email; ?></td>
	</tr>
	<tr>
		<td width=50% align=right>Tour Date Requested:&nbsp;&nbsp;</td>
		<td><?php echo $requested_date; ?></td>
	</tr>
	<tr>
	  	<td align=right>Expected Arrival Time:&nbsp;&nbsp;</td>
		<td><?php echo $arrival_time; ?></td>
  </tr>
	<tr>
	  <td align=right valign=top>Special Needs:&nbsp;&nbsp;</td>
	  <td><?php echo $special_needs; ?></td>
  </tr>
	<tr>
	  <td align=right valign=top>Questions or Comments:&nbsp;&nbsp;</td>
	  <td><?php echo $comments; ?></td>
  </tr>
    <tr>
        <td colspan=2 align=center><a href="edit_res.php?id=<? echo $id ?>">Make A Change To Your Reservation</a></td>
    </tr>
</table>
<?
require_once 'footer.php';
?>