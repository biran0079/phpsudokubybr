<?php
if(!isset($_SESSION['uid'])){
	header("location:login_required.php");
}
?>
<?php
include("init.php");
$query="SELECT * FROM games WHERE uid=".get_uid();
$res=sqlres($query);
$query='UPDATE games SET state="'.$res['solution'].'" WHERE uid='.get_uid();
sql($query);
header("Location: game.php?old_game=true");
?>
