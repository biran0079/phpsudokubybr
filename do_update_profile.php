<?php
include("init.php");
$uid=get_uid();
$password=$_POST['password'];
$repeated_password=$_POST['repeated_password'];
$user_name=get_user_name_by_uid($uid);

if($password!=$repeated_password){
	$dest="Location: change_password.php?user_name=".$user_name."&different_password";
	header($dest);
}elseif(strlen($password)<6){
	$dest="Location: change_password.php?user_name=".$user_name."&password_too_short";
	header($dest);
}else{
	$query='UPDATE users SET password="'.$password.'" WHERE uid='.$uid;
	sql($query);
	header("Location: home.php");
}
?>
