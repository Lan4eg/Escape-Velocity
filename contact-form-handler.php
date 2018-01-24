<?php

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

    header('Location: index.php');
}