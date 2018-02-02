<?php 
require_once 'config.php';



if(empty($_POST['email']) OR empty($_POST['password']))
{
	die('Пожалуйста, заполните все поля');
}
else
{
	$email = $_POST['email'];
	$pass = $_POST['password'];
	if ($email == $dbEmail) 
	{
		$_SESSION['email'] = $email;
		$passHash = md5($pass);
		if($passHash == $dbPass)
		{
			$_SESSION['passHash'] = $passHash;
			$expires = time() + 86400 * 7;
			if(isset($_POST['remember_me']))
			{
				setcookie('token', $passHash, $expires, '/');
			}
			//echo $_COOKIE['token'];
			die('Добро пожаловать');
		}
		else
		{
			die('Пароль введен неверно');
		}
	}
	else
	{
		die('Такого пользователя нет');
	}
}



