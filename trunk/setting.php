<?php
session_start();
if(!isset($_SESSION['uid'])){
	header("location:login_required.php");
}
?>
<?php
include("header.php");
$uid=get_uid();
$diff=get_diff_by_uid($uid);
$hint=get_hint_by_uid($uid);
$highlight=get_highlight_by_uid($uid);
echo '<form action="do_setting.php" method="post">';
echo '<table><tr>';
echo '<td><span>Difficulty:</span></td>
	<td><select name="diff">';
if($diff==="EASY"){
	echo 	'<option value="EASY" selected="selected">EASY</option>';
}else{
	echo 	'<option value="EASY">EASY</option>';
}
if($diff==="MEDIUM"){
	echo 	'<option value="MEDIUM" selected="selected">MEDIUM</option>';
}else{
	echo 	'<option value="MEDIUM">MEDIUM</option>';
}
if($diff==="HARD"){
	echo 	'<option value="HARD" selected="selected">HARD</option>';
}else{
	echo 	'<option value="HARD">HARD</option>';
}
if($diff==="INSANE"){
	echo 	'<option value="INSANE" selected="selected">INSANE</option>';
}else{
	echo 	'<option value="INSANE">INSANE</option>';
}
echo '</select></td></tr>';
echo '<tr><td><span>Hint:</span></td><td>';
if($hint==="ON"){
	echo '<input type="radio" name="hint" value="ON" checked="checked">on';
	echo '<input type="radio" name="hint" value="OFF">off';
}else{
	echo '<input type="radio" name="hint" value="ON">on';
	echo '<input type="radio" name="hint" value="OFF" checked="checked">off';
}
echo '</td></tr>';
echo '<tr><td><span>Highlight:</span></td><td>';
if($highlight==="ON"){
	echo '<input type="radio" name="highlight" value="ON" checked="checked">on';
	echo '<input type="radio" name="highlight" value="OFF">off';
}else{
	echo '<input type="radio" name="highlight" value="ON">on';
	echo '<input type="radio" name="highlight" value="OFF" checked="checked">off';
}
echo '</td></tr>';
echo '</table>';
echo '<br><input type=submit value="submit">';
echo '</form>';

include("footer.php");
?>
