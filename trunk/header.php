<?php
include("init.php");
function print_login_form(){
	$login_form='
		<form action="do_login.php" method="post">
		<span>user name</span><input type="text" name="user_name">
		<span>password</span><input type="password" name="password">
		<input type="submit" value="log in" class="submit">
		</form>';
	echo $login_form;
	echo '<a href="regist.php">regist</a><br>';
	echo '<a href="login_as_guest.php">play as a guest</a>';
}
function print_logout_form(){
	show_achievement(get_uid());
	echo '<a href="update_profile.php" id="profile">profile</a>';
	echo '<a href="do_logout.php" id="logout">Logout</a><br>';
}
function print_menu(){
	global $login_state;
	if($login_state){
		echo '<li><a href="game.php?new_game=true">New Game</a></li>';
		echo '<li><a href="setting.php">Customize</a></li>';
		echo '<li><a href="ranking.php">Leader Board</a></li>';
	}
}
$login_state=check_login();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='cs' lang='cs'>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv='Content-Language' content='cs' />   
		<meta name="author" content="br" />
		<meta name="keywords" content="sudoku" />  
		<meta name="description" content="sudoku game written in php" />  

		<link rel="stylesheet" href="styl.css" type="text/css" />

		<title>SODOKU</title>


	</head>
	<body>

		<div id="header">
			<h2><a href="home.php" title="home">SUDOKU</a></h2>

			<ul id="menu-top">
<?php
print_menu();
?>
			</ul>
		</div>

		<div id="contain">

			<div id="left">
