	</div>

			<div id="right">

				<div class="gray">

<?php
if($login_state){
	print_logout_form();
	if(get_old_game_by_uid(get_uid())){
		echo '<a href="game.php?old_game=true">load saved game</a>';
	}
}else{
	print_login_form();
}
?>

				</div>

			</div>

			<div class="cleaner"></div>
		</div>

		<p id="footer">(c) 2009 Bi Ran <a style="color: gray;" href="mailto:biran0079@gmail.com">biran0079@gmail.com</a></p>

	</body>
</html>
