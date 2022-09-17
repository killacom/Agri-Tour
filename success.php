<? 
require_once 'header.php';
require_once 'config.php';
if (isset($_GET['id']))
{
    if (is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
    }
}
?>
<table align=center>
    <tr>
        <th colspan=2 align=center class=title>Make a Reservation at Page Farms</th>
    </tr>
    <tr>
        <td colspan=2 align=center>
            <? echo $reservation_success_text; ?><br /><br />
            <a href="schoolcal.php">View School Calender</a><br /><br />
            <a href="edit_res.php?id=<? echo $id ?>">Make A Change To Your Reservation</a>
        </td>
    </tr>

<?
require_once 'footer.php';
?>
    