<?php
include("config.php");
function write_log($s){
	/*
	$f=fopen("log.txt","a");
	fwrite($f,$s);
	fwrite($f,"\n");
	fclose($f);
	 */
}


$con=mysql_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD);
mysql_select_db(DATABASE_NAME,$con);


function get_puzzle_and_solution(){
	$query="SELECT * FROM puzzles ORDER BY RAND() LIMIT 1";
	return sqlres($query);
}
function random_fillin($puz,$sol,$n){
	$top=0;
	for($i=0;$i<81;$i++){
		if($puz[$i]=='0')
			$a[$top++]=$i;
	}
	shuffle($a);
	for($i=0;$i<$n;$i++){
		$puz[$a[$i]]=$sol[$a[$i]];
	}
	return $puz;
}
function diff_of_puzzle($puzzle){
	$t=0;
	for($i=0;$i<81;$i++)
		if($puzzle[$i]!='0')
			$t++;
	$t-=17;
	if($t<=3){
		return 'INSANE';
	}elseif($t<=20){
		return 'HARD';
	}elseif($t<=40){
		return 'MEDIUM';
	}else{
		return 'EASY';
	}
}
function update_achievement($uid,$diff){
	if($uid==0)return;
	$query="SELECT * from achievement where uid=".get_uid();
	$res=sqlres($query);
	$diff=strtolower($diff);
	$n=$res[$diff];
	$n++;
	$query="UPDATE achievement SET ".$diff.'='.$n.' WHERE uid='.$uid;
	sql($query);
}



function get_puzzle_and_solution_by_diff($diff){
	$res=get_puzzle_and_solution();
	$sol=$res['solution'];
	$puz=$res['puzzle'];
	if($diff=='EASY'){
		$res['puzzle']=random_fillin($puz,$sol,60);
	}elseif($diff=='MEDIUM'){
		$res['puzzle']=random_fillin($puz,$sol,40);
	}elseif($diff=='HARD'){
		$res['puzzle']=random_fillin($puz,$sol,20);
	}elseif($diff=='INSANE'){
		$res['puzzle']=random_fillin($puz,$sol,3);
	}
	$res['state']=$res['puzzle'];
	return $res;
}
function check_login(){
	session_start();
	return isset($_SESSION['uid']);
}
function get_user_name_by_uid($uid){
	$query="SELECT user_name FROM users WHERE uid=".$uid;
	$res=sqlres($query);
	return $res['user_name'];
}
function get_uid(){
	session_start();
	return $_SESSION['uid'];
}
function get_diff_by_uid($uid){
	$query="SELECT diff FROM setting WHERE uid=".$uid;
	$res=sqlres($query);
	return $res['diff'];
}
function get_hint_by_uid($uid){
	$query="SELECT hint FROM setting WHERE uid=".$uid;
	$res=sqlres($query);
	return $res['hint'];
}
function get_highlight_by_uid($uid){
	$query="SELECT highlight FROM setting WHERE uid=".$uid;
	$res=sqlres($query);
	return $res['highlight'];
}
function get_password_by_uid($uid){
	$query="SELECT password FROM users WHERE uid=".$uid;
	$res=sqlres($query);
	return $res['password'];
}
function delete_user($uid){
	$query="DELETE FROM users WHERE uid=".$uid;
	sql($query);
	$query="DELETE FROM achievement WHERE uid=".$uid;
	sql($query);
	$query="DELETE FROM setting WHERE uid=".$uid;
	sql($query);
	$query="DELETE FROM games WHERE uid=".$uid;
	sql($query);
}
function create_user($user_name,$password){
	$query='INSERT INTO users(user_name,password) VALUES("'.$user_name.'","'.$password.'")';
	sql($query);
	$query='SELECT uid FROM users WHERE user_name="'.$user_name.'"';
	$res=sqlres($query);
	$query='INSERT INTO achievement(uid) VALUES('.$res['uid'].')';
	sql($query);
	$query='INSERT INTO setting(uid) VALUES('.$res['uid'].')';
	sql($query);
}
function get_old_game_by_uid($uid){
	$query="SELECT * FROM games WHERE uid=".$uid;
	return sqlres($query);
}
function user_exist($user_name){
	$query='SELECT * FROM users WHERE user_name="'.$user_name.'"';
	$res=sqlres($query);
	return $res;
}
function sql($query){
	write_log($query);
	global $con;
	$result=mysql_query($query,$con);
	return $result;
}
function sqlres($query){
	$res=mysql_fetch_array(sql($query));
	write_log(print_r($res,true));
	return $res;
}
function set_hint($uid,$hint){
	$query='UPDATE setting SET hint="'.strtoupper($hint).'" WHERE uid='.$uid;
	sql($query);
}
function set_diff($uid,$diff){
	$query='UPDATE setting SET diff="'.strtoupper($diff).'" WHERE uid='.$uid;
	sql($query);
}
function set_highlight($uid,$highlight){
	$query='UPDATE setting SET highlight="'.strtoupper($highlight).'" WHERE uid='.$uid;
	sql($query);
}


function validate_user($user_name,$password){
	$query='SELECT * FROM users WHERE user_name="'.$user_name.'" AND password="'.$password.'"';
	return sqlres($query);
}
function login($user_name,$password){
	$res=validate_user($user_name,$password);
	if($res){
		// clean up the session storage
		session_start();
		
		// store information into $_SESSION
		$_SESSION['uid'] = $res['uid'];
		return true;
	}else{
		return false;
	}
}
function update_gamestate($game){
	$uid=get_uid();
	$query='DELETE FROM games WHERE uid='.$uid;
	sql($query);
	$query='INSERT INTO games(uid,puzzle,state,solution) VALUES('.$uid.',"'.$game["puzzle"].'","'.$game["state"].'","'.$game["solution"].'")';
	sql($query);
}
function logout(){
	session_start();
	session_destroy();
}
function show_achievement($uid){
	$query="SELECT * FROM achievement WHERE uid=".$uid;
	$res=sqlres($query);
	$user_name=get_user_name_by_uid($uid);
	echo '<span id="achievement">';
	echo '<span class="property">USER NAME: </span><span class="value">'.$user_name.'</span><br>';
	echo '<span class="property">EASY: </span><span class="value">'.$res['easy'].'</span><br>';
	echo '<span class="property">MEDIUM: </span><span class="value">'.$res['medium'].'</span><br>';
	echo '<span class="property">HARD: </span><span class="value">'.$res['hard'].'</span><br>';
	echo '<span class="property">INSANE: </span><span class="value">'.$res['insane'].'</span><br>';
	echo '</span>';
}

?>
