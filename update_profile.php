<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:login_required.php");
}
?>
<?php
include("header.php");

$uid=get_uid();
$user_name=get_user_name_by_uid($uid);
$password=get_password_by_uid($uid);
?>
<form action="do_update_profile.php" method="post">
<table>
<tr>
<td><span>user name</span></td> <td><b><?php echo $user_name;?></b></td>
</tr>
<tr>
<td><span>password</span></td> <td><input type="password" name="password" value="<?php echo $password?>"></td>
<td>
<?php
if(isset($_GET['password_too_short'])){
	echo '<span class="warning">length of passwords must not be less than 6</span>';
}
?>
</td>
</tr>
<tr>
<td><span>repeat password</span></td><td><input type="password" name="repeated_password" value="<?php echo $password?>"></td>
<td>
<?php
if(isset($_GET['different_password'])){
	echo '<span class="warning">two passwords are not the same</span><br>';
}
?>
</td>
</tr>
</table>

<input type="submit" value="submit">
</form>
<a href="do_delete_user.php">delete user</a>
<?php
include("footer.php");
?>
