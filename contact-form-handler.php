<?php
session_start();
require_once 'functions.php';
$max_file_size = 102400;//kb
$allowed_types = ['image/jpeg', 'image/png'];
$allowed_extensions = ['jpg', 'jpeg', 'png'];

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);



if(empty($name) OR empty($email) OR empty($message))
{
    set_message('Пожалуйста, заполните все поля!');
}
elseif(mb_strlen($name) > 250 OR mb_strlen($email) > 250)
{
    set_message('Слишком длинное имя или email');
}
elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
{
    set_message('Введите правильный email');
}
else
{
	$upload_url = array();// uploaded links array , see below
	$image = $_FILES['image'];
	$tmp_name = $image['tmp_name'];
	$original_name = $image['name'];
	$files_ammount = count($original_name);
	for ($i=0; $i < $files_ammount; $i++) 
	{
		if($original_name[$i])
		{
			$dotpos = strripos($original_name[$i],'.');
			$extension = substr($original_name[$i], $dotpos+1);

			if(filesize($tmp_name[$i])>($max_file_size)*1024)
			{
				set_message('Размер загружаемого файла превышает допустимый');
			}
			elseif (!in_array($image['type'][$i], $allowed_types) AND !in_array($extension, $allowed_extensions)) 
			{
				set_message('Этот файл запрещен к загрузке');
			}
			else
			{
				$dir = 'uploads';
				$subdir = mt_rand(0,10);
				$path = $dir . '/' . $subdir;
				if(!is_dir($path))
					mkdir($path);
				do {
					$randname = generate_random_string(8);
					$filename = $randname . '.' . $extension;
					$is_exists = file_exists($path . '/' . $filename);
				} while ($is_exists);
				
				$result = move_uploaded_file($tmp_name[$i], $path . '/' . $filename);	
				if(!$result)
				{
					set_message('Файл успешно загружен');
				}
			}
			array_push($upload_url, 'http://beetroot.local/' . $path . '/' . $filename);// we put each uploaded file link into string array			
		}
	}

	if(file_exists('data/requests.txt'))// using different fopen for differnt situations
		$fh = fopen('data/requests.txt', 'a');
	else
		$fh = fopen('data/requests.txt', 'w');
	$date = date('F d, o, H:i');
	fwrite($fh, $date . PHP_EOL);
	fwrite($fh, 'Имя: ' . $name . PHP_EOL);
	fwrite($fh, 'Email: ' . $email . PHP_EOL);
	fwrite($fh, $message . PHP_EOL);
	$a = 0;// i just like it to be clear
	foreach($upload_url as $file)// scope thru the array to write each link to file
	{
		$a++;
		fwrite($fh, 'Файл #' . $a . ': ' . $file . PHP_EOL);
	}
	fwrite($fh, '======================' . PHP_EOL);
	fclose($fh);
   
   
}
set_message('Спасибо за отправку формы');
header('Location: index.php');