<?php
include("init.php");
$user_name=$_POST["user_name"];
$password=$_POST["password"];
if(login($user_name,$password)){
	header("location: home.php");
}else{
	header("location: home.php?login_fail&user_name=".$user_name);
}
?>
