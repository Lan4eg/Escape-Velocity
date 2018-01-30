<?php
$max_file_size = 102400;//kb
$allowed_types = ['image/jpeg', 'image/png'];
$allowed_extensions = ['jpg', 'jpeg', 'png'];

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);



if(empty($name) OR empty($email) OR empty($message))
{
    die('Пожалуйста, заполните все поля!');
}
elseif(mb_strlen($name) > 250 OR mb_strlen($email) > 250)
{
    die('Слишком длинное имя или email');
}
elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
{
    die('Введите правильный email');
}
else
{
	$fh = fopen('data/requests.csv', 'a');

    $date = date('d.m.Y H:i');
    $row = [$date, $name, $email, $message];
    fputcsv($fh, $row);

    fclose($fh);


	
	$image = $_FILES['image'];
	$tmp_name = $image['tmp_name'];
	$original_name = $image['name'];
	$files_ammount = count($original_name);
	for ($i=0; $i < $files_ammount; $i++) 
	{
		 if($original_name)
		{
			$dotpos = strripos($original_name[$i],'.');
			$extension = substr($original_name[$i], $dotpos+1);

			echo "<pre>";
			var_dump($extension);
			echo "</pre>";

			if(filesize($tmp_name[$i])>($max_file_size)*1024)
			{
				die('Размер загружаемого файла превышает допустимый');
			}
			elseif (!in_array($image['type'][$i], $allowed_types) AND !in_array($extension, $allowed_extensions)) 
			{
				die('Этот файл запрещен к загрузке');
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
					die('Файл успешно загружен');
				}
				echo '<pre>';
				var_dump($filename);
				echo '</pre>';
			}

			echo "<pre>";
			var_dump($_FILES);
			echo "</pre>";
			exit;
		}
	}
	
	
    

   // header('Location: index.php');
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