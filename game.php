<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:login_required.php");
}
?>

<?php
include("header.php");
$block_idx=array(array(0,1,2,9,10,11,18,19,20),
	array(3,4,5,12,13,14,21,22,23),
	array(6,7,8,15,16,17,24,25,26),
	array(27,28,29,36,37,38,45,46,47),
	array(30,31,32,39,40,41,48,49,50),
	array(33,34,35,42,43,44,51,52,53),
	array(54,55,56,63,64,65,72,73,74),
	array(57,58,59,66,67,68,75,76,77),
	array(60,61,62,69,70,71,78,79,80));
$highlight=get_highlight_by_uid(get_uid());

function show_fixed_cell($name,$v){
	global $highlight;
	$cell_events='onkeyup="check_input('.$name.')" ';
	if($highlight==='ON'){
		$cell_events.='onmouseOver="highlight_related('.$name.')" 
			onmouseOut="un_highlight_related('.$name.')"  ';
	}
	echo '<input ';
	echo 'AUTOCOMPLETE="off"';
	echo $cell_events;
	echo 'type="text" readonly="readonly" class="fixed" name="'.$name.'" 	id="cell'.$name.'"  value="'.$v.'">';
}
function show_normal_cell($name,$v){
	global $highlight;
	$cell_events='onclick="popout('.$name.')" onkeyup="check_input('.$name.')" ';
	if($highlight==='ON'){
		$cell_events.='onmouseOver="highlight_related('.$name.')" 
			onmouseOut="un_highlight_related('.$name.')"  ';
	}
	if($v==0)$v='';
	echo '<input ';
	echo 'AUTOCOMPLETE="off"';
	echo $cell_events;
	echo 'type="text" readonly="readonly" 
		class="normal"  name="'.$name.'" id="cell'.$name.'" value="'.$v.'">';
}
function show_collosion_cell($name,$v){
	global $highlight;
	$cell_events='onclick="popout('.$name.')" onkeyup="check_input('.$name.')" ';
	if($highlight==='ON'){
		$cell_events.='onmouseOver="highlight_related('.$name.')" 
			onmouseOut="un_highlight_related('.$name.')"  ';
	}
	echo '<input ';
	echo 'AUTOCOMPLETE="off"';
	echo $cell_events;
	echo 'type="text" readonly="readonly" 
		class="collision"  name="'.$name.'" id="cell'.$name.'"  value="'.$v.'">';
}
function show_block($game,$idx){
	global $block_idx,$collision_state;
	echo '<div class="block">';
	echo '<table>';
	$puzzle=$game['puzzle'];
	$state=$game['state'];
	for($i=0;$i<3;$i++){
		echo '<tr>';
		for($j=0;$j<3;$j++){
			echo '<td>';
			$t=$block_idx[$idx][$i*3+$j];
			if($collision_state[$t]=='0'){
				show_fixed_cell($t,$puzzle[$t]);
				//echo '<input type="text" readonly="readonly" style="width:30px;color:red" name="'.$t.'" value="'.$puzzle[$t].'">';
			}elseif($collision_state[$t]=='1'){
				show_normal_cell($t,$state[$t]);
				//echo '<input type="text" style="width:30px;" name="'.$t.'" value="'.$state[$t].'">';
			}else{
				show_collosion_cell($t,$state[$t]);
				//echo '<input type="text" style="width:30px;" name="'.$t.'">';
			}
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
	echo '</div>';
}
function show_game($game){
	show_pop();
	echo '<table id="sudoku">';
	for($i=0;$i<3;$i++){
		echo '<tr>';
		for($j=0;$j<3;$j++){
			echo '<td>';
			show_block($game,$i*3+$j);
			echo '</td>';
		}
		echo '</tr>';
	}
	echo '</table>';
}




function div($a,$b){
	return ($a - $a % $b) / $b;
}
function collision_detected($state,$i){
	global $block_idx;
	$rn = div($i,9);
	$cn = $i % 9;
	$bn = div($rn,3) * 3 + div($cn,3);
	for($k=0;$k<9;$k++){
		$t=9 * $rn + $k;
		if($t != $i && $state[$t]==$state[$i])
			return true;
		$t=9 * $k + $cn;;
		if($t != $i && $state[$t]==$state[$i])
			return true;
		$t=$block_idx[$bn][$k];
		if($t != $i && $state[$t]==$state[$i])
			return true;
	}
	return false;
}
function show_pop(){
	echo '<table id="pop" style="visibility:hidden;" >
		<tr><td><input onclick=choose(1) type="text" readonly="readonly"  value=1>
		</td><td><input onclick=choose(2) type="text" readonly="readonly" value=2>
		</td><td><input onclick=choose(3) type="text" readonly="readonly" value=3>
		</td></tr>
		<tr><td><input onclick=choose(4) type="text" readonly="readonly"  value=4>
		</td><td><input onclick=choose(5) type="text" readonly="readonly" value=5>
		</td><td><input onclick=choose(6) type="text" readonly="readonly" value=6>
		</td></tr>
		<tr><td><input onclick=choose(7) type="text" readonly="readonly"  value=7>
		</td><td><input onclick=choose(8) type="text" readonly="readonly" value=8>
		</td><td><input onclick=choose(9) type="text" readonly="readonly" value=9>
		</td></tr>
		</table>';
}


/*
 * 	if $hint is "ON", then
 * 		returns a string 81 chars of {0,1,2}.
 *		0 is fixed cell, 
 *		1 is normal cell, 
 *		2 is collision cell
 *	else
 *		return a string 81 chars of {0,1}.
 *		0 is fixed cell, 
 *		1 is normal cell, 
 * */
function find_collision(){
	global $game;
	$res="";
	$state=$game['state'];
	$puzzle=$game['puzzle'];
	if(get_hint_by_uid(get_uid())=='ON'){
		for($i=0;$i<9;$i++){
			for($j=0;$j<9;$j++){
				$t=$i*9+$j;
				if($puzzle[$t]!='0'){
					$res.='0';
				}else{
					if($state[$t]!=0 && collision_detected($state,$t)){
						$res.='2';
					}else{
						$res.='1';
					}
				}
			}
		}
	}else{
		for($i=0;$i<81;$i++){
			if($puzzle[$i]!=0){
				$res.='0';
			}else{
				$res.='1';
			}
		}
	}
	return $res;
}



if($_GET["old_game"]=="true"){
	$t=get_old_game_by_uid(get_uid());
	$game['uid']=get_uid();
	$game['puzzle']=$t['puzzle'];
	$game['state']=$t['state'];
	$game['solution']=$t['solution'];
}else if($_GET["new_game"]=="true"){
	$diff=get_diff_by_uid(get_uid());
	$t=get_puzzle_and_solution_by_diff($diff);
	$game['uid']=get_uid();
	$game['puzzle']=$t['puzzle'];
	$game['state']=$t['puzzle'];
	$game['solution']=$t['solution'];
}

$collision_state=find_collision();

echo '<script src="js/highlight.js"></script>';
echo '<script src="js/check_input.js"></script>';
echo '<script src="js/pop.js"></script>';
echo "<h1>DIFFICULTY: ".diff_of_puzzle($game['puzzle'])."</h1>";
echo '<form action="do_submit.php" method="post">';
show_game($game);
echo '<input type="hidden" name="puzzle" value="'.$game['puzzle'].'">';
echo '<input type="hidden" name="solution" value="'.$game['solution'].'">';
if($game['state']===$game['solution']){
	if($_SESSION["win"]=='true'){
		echo '<strong style="padding-left:100px">CONTRATULATIONS!</strong><br>';
		$_SESSION["win"]=false;
		update_achievement(get_uid(),diff_of_puzzle($game['puzzle']));
	}
	echo '<a style="padding-left:100px" href="game.php?new_game=true">start a new game</a><br>';
}else{
	echo '<br><input style="margin-left:100px" type="submit" value="submit" class="submit"><br>';
	echo '<br>';
	echo '<a style="padding-left:100px" href="do_show_solution.php">show solution</a><br>';
}
echo '</form>';
echo '<br>';
//echo $game['solution'];
include("footer.php");
?>
