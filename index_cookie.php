<?php 
session_start();
//setcookie('token', $passHash, time()-3600);
require_once 'config.php';
$isAuth = false;
	if(isset($_COOKIE['token']) OR $_SESSION['passHash'] == $dbPass)
	{
		$token = $_COOKIE['token'];
		if($token == $dbPass OR $_SESSION['passHash'] == $dbPass)
			$isAuth = true;
	}
?>
<?php if($isAuth) : ?>
	<h1>
		Здравствуйте, <?=$dbEmail ?>
	</h1>
<? else : ?>
<form method="post" action="auth.php">
	<input type="email" name="email" value="pupkin@example.com"><br>
	<input type="password" name="password" value="1234">
	<br>
	<label>
		<input type="checkbox" name="remember_me" value="1">
		Запомнить меня
	</label><br>
	<button type="submit">Войти</button>
</form>
<? endif; ?>	