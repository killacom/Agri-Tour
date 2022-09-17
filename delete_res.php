<?php
require_once 'config.php';
require_once 'header.php';
require_once 'adminnav.php';
$id = $_POST['id'];
$sql = "SELECT * FROM reservations WHERE id = '".$id."'";
if ($result = $link->query($sql))
{
    while ($row = $result->fetch_assoc())
    {
        $school_name = $row['school_name'];
        $num_children = $row['num_children'];
        $num_adults = $row['num_adults'];
        $num_teachers = $row['num_teachers'];
        $contact_email = $row['contact_email'];
        $requested_date = $row['requested_date'];
        $arrival_time = $row['arrival_time'];
    }
}
$sql = "DELETE FROM reservations WHERE id = '".$id."' "; 
if (mysqli_query($link, $sql)) 
{
    $to      = $contact_email;
    $subject = 'Page Farms Field Trip Deletion Confirmation';
    $message = 'This email is to confirm that your reservation for '.$school_name.' was deleted.<br>'
              .'If you did not request this deletion please contact us at 919-451-5534.<br>'
              .'The time you had reserved is '.$arrival_time.' on '.$requested_date.'. <br>'
              .'Number of kids: '.$num_children.' <br>'
              .'Number of teachers: '.$num_teachers.' <br>'
              .'Number of visiting adults: '.$num_adults.' <br>';
    $headers = 'From: Page Farms <'.$admin_email.'>' . "\r\n" .
               'Reply-To: '.$admin_email. "\r\n" .
               'Cc: '.$admin_email_cc. "\r\n" .
               'Bcc: '.$admin_email_bcc . "\r\n" .
               'Content-Type: text/html; charset="iso-8859-1"'.
               'X-Mailer: PHP/' . phpversion();;
    $message = nl2br($message);
    mail($to, $subject, $message, $headers);
    ?>
    <table border=0 cellpadding=0 cellspacing=0 align=center>
    <tr>
        <td align=center><b><span class="error">Reservation Deleted</span></b></td>
    </tr>
    <tr>
        <td align=center><br /><? echo $school_name; ?>&nbsp;<br /></td>
    </tr>
    <tr>
        <td align=center><br /><? echo $requested_date; ?>&nbsp;<br /></td>
    </tr>
    <tr>
        <td align=center><br /><? echo $arrival_time; ?>&nbsp;<br /></td>
    </tr>
    </table>
<?
    }
require_once 'footer.php';
?>


