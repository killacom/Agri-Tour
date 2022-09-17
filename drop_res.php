<?php
require_once 'config.php';
$id = $_POST['id'];
$sql = 'SELECT * FROM `reservations` WHERE `id` = "'.$id.'" LIMIT 1'; 
if ($result = $link->query($sql))
{
    while ($row = $result->fetch_assoc())
    {
        $school_name = $row['school_name'];
        $date = $row['requested_date'];
        $arrival_time = $row['arrival_time'];
    }
}
require_once 'header.php';
require_once 'adminnav.php';
?>
<form method=post action='delete_res.php'>
<input type=hidden value='<? echo $id; ?>' name=id>
<table border=0 cellpadding=0 cellspacing=0 align=center>
    <tr>
        <td align=center><b><span class="error">Are you sure you want to delete this reservation? This cannot be undone!</span></b></td>
    </tr>
    <tr>
        <td align=center><br /><? echo $school_name; ?>&nbsp;<br /></td>
    </tr>
    <tr>
        <td align=center><br /><? echo $date; ?>&nbsp;<br /></td>
    </tr>
    <tr>
        <td align=center><br /><? echo $arrival_time; ?>&nbsp;<br /></td>
    </tr>
    <tr>
        <td align=center><br /><input type="submit" value="Delete"><br /></td>
    </tr>
</table>
</form>
<?
require_once 'footer.php';
?>