<?
session_start();
require_once 'config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    }
else{
    header("location: dailyreport.php");
    exit;
}
?>