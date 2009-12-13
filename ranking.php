<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:login_required.php");
}
?>
<?php
include("header.php");
echo '<div id="leaderboard">';
echo '<h1>GLOBAL TOP 10</h1>';
$query="SELECT * FROM achievement WHERE uid<>0 ORDER BY insane DESC,hard DESC,medium DESC,easy DESC limit 10";
$res=sql($query);
$row=mysql_fetch_array($res);
echo '<ol>';
while($row){
	echo '<li>'.get_user_name_by_uid($row['uid']).'</li>';
	$row=mysql_fetch_array($res);
}
echo '</ol>';
echo '</div>';
include("footer.php");
?>
