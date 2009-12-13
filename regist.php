<?php
include("header.php");
?>
<form action="do_regist.php" method="post">

<table>
<tr>
<td><span>user name</span></td>
<td><input type="text" name="user_name" <?php if(isset($_GET['user_name']))echo 'value="'.$_GET['user_name'].'"';?> ></td>
<td>
<?php
if(isset($_GET['user_name_exists'])){
	echo '<span class="warning">user name already exists</span><br>';
}
?>
</td>
</tr>

<tr>
<td>
<span>password</span>
</td>
<td>
<input type="password" name="password">
</td>
<td>
<?php
if(isset($_GET['password_too_short'])){
	echo '<span class="warning">length of passwords must not be less than 6</span><br>';
}
?>
</td>
</tr>
<tr>
<td>
<span>repeat password</span>
</td>
<td>
<input type="password" name="repeated_password">
</td>
<td>
<?php
if(isset($_GET['different_password'])){
	echo '<span class="warning">two passwords are not the same</span><br>';
}
?>
</td>
</tr>
</table>
<br>
<input type="submit" value="submit">
</form>
<?php
include("footer.php");
?>
