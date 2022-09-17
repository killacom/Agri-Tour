<?php

//check login
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

//includes
require_once "config.php";

//some variables
$pagetitle = "Admin Login - ".$farm_name." - Reservation System";
$username = $password = "";
$username_err = $password_err = "";

//if already submitted check out their info
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            header("location: index.php"); //login sucessfull
                        } else {
                            $password_err = $userpass_combo_bad_text;
                        }
                    }
                } else {
                    $username_err = $userpass_combo_bad_text;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($link);
}

//otherwise display form
$body = '
    <p>Please fill in your credentials to login.</p>
        <form action="login.php" method="POST">
            <label>Username</label>
            <input type="text" name="username" class="" value="'.$username.'">
            <span class="error">'.$username_err.'</span>
            <label>Password</label>
            <input type="password" name="password" class="">
            <span class="error">'.$password_err.'</span>
            <input type="submit" value="Login">
        </form> 
';

//display
require_once 'header.php';
echo $body;
require_once 'footer.php';
?>