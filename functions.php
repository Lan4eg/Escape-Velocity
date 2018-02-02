<?php

function set_message($message, $type = 'success')
{
	$messages = $_SESSION['messages'] ?? [];
	$messages[] = $message;
	$_SESSION['messages'] = $messages;
}

function print_message()
{
	$messages = $_SESSION['messages'] ?? [];
	if($messages)
	{
		foreach($messages as $message)
			foreach($message as $type => $text)
			{
				if($type == 'success')
					echo $message . '<br>';
				elseif($type == 'error')
					echo 'Сожалеем';
			}
		unset($_SESSION['messages']);
	}
}

function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}