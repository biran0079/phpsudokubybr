<?php
include("init.php");
$uid=get_uid();
set_diff($uid,$_POST['diff']);
set_hint($uid,$_POST['hint']);
set_highlight($uid,$_POST['highlight']);
header('location: home.php');
?>
