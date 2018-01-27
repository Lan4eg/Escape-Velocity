<?php
	$file = fopen('products_export.csv','r');
	$row = 0;
	$final = array();
	$my_name = 'Dima Bezborodov';
	while (($data = fgetcsv($file, 10000)) !== FALSE)
	{
		if($row == 0)
		{
			$header = $data;
		}
		else
		{
			$pre_final=array_combine($header, $data);
			array_push($final,$pre_final);
		}
		$row++;
	}
	foreach ($final as &$value)
	{
		if($value['author'] == 'Alan Barnes')
			{
				$value['author'] = $my_name;
			}
	}
	$fh = fopen('products_export.csv', 'w');
	foreach ($final as $string) 
	{
		fputcsv($file,$string);	
	}
	echo "<pre>";
	print_r($final);
	echo "</pre>";
	fclose($file);
?>
