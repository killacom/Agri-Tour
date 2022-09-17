<? 
$pagetitle = 'Page Farms - Edit Your Reservation';
require_once 'header.php';
require_once 'config.php';
$id = $_GET['id'];
?>
<table align=center>
    <tr>
        <th colspan=2 align=center class=title>Edit Your Page Farms Reservation</th>
    </tr>
    
    <tr>
        <td colspan=2 align=center>
            <? echo $edit_success_text; ?><br /><br />
            <a href="schoolcal.php">View School Calender</a><br /><br />
            <a href="view_res.php?id=<? echo $id ?>">View Reservation Details</a><br /><br />
            <a href="edit_res.php?id=<? echo $id ?>">Make Another Change</a>
        </td>
    </tr>
<? require_once 'footer.php'; ?>