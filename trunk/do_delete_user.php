<?php
include("init.php");
$uid=get_uid();
delete_user($uid);
logout();
header("location:home.php");
?>
