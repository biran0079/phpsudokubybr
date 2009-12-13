<?php
include("init.php");
$uid=get_uid();
$puzzle=$_POST['puzzle'];
$solution=$_POST['solution'];
$state='';
for($i=0;$i<9;$i++){
	for($j=0;$j<9;$j++){
		$t=$_POST[$i*9+$j];
		if($t>=1 && $t<=9){
			$state.=$t;
		}else{
			$state.='0';
		}
	}
}
$game['uid']=$uid;
$game['puzzle']=$puzzle;
$game['solution']=$solution;
$game['state']=$state;
update_gamestate($game);
if($game['state']==$game['solution']){
	$_SESSION["win"]=true;
}
header("location: game.php?old_game=true");
?>
