<?php
//SETTINGS PAGE FOR AGRI-TOURISM RESERVATION SYSTEM
//PAGE FARMS VERSION
//THOMAS PORTER 2018-2021 - THOMAS.PORTER.1991@GMAIL.COM
session_start();
require_once 'config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    }
require_once 'header.php';
require_once 'adminnav.php';
if (!$link) 
{
    die("Connection failed: " . mysqli_connect_error());
}
?>
<table>
	<tr>
		<th class=date colspan=2>Updates</th>
	</tr>
	<tr>
		<td>09/12/2022</td><td>-- Fixed minor issue on Daily report causing last day of report not to show</td>
	</tr>
	<tr>
		<td>09/12/2022</td><td>-- Updated make reservation page with more phone friendly design</td>
	</tr>
	<tr>
		<td>08/14/2022</td><td>-- Corrected Issue on Daily Report making default date range not show anything in between seasons</td>
	</tr>
	<tr>
		<td>12/25/2021</td><td>-- Added rich text functionality to confirmation email body on settings page</td>
	</tr>
	<tr>
		<td>11/7/2021</td><td>-- Reworked daily report coding to work more efficiently with season and year changes</td>
	</tr>
	<tr>
		<td>10/24/2021</td><td>-- Completed work on adding year functionality to daily report</td>
	</tr>
	<tr>
		<td>10/23/2021</td><td>-- Added updates page, started work on adding year functionality to daily report page</td>
	</tr>
</table>
	
	
<? require_once'footer.php'; ?>

