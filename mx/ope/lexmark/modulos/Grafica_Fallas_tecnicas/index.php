<?php
	$str_apl = 'grafico_fallas_tecnicas';
	if(is_file("_lib/friendly_url/" . $str_apl . '_ini.txt'))
	{
		$str_apl = file_get_contents("_lib/friendly_url/" . $str_apl . '_ini.txt');
	}
	else
	{
		$str_apl = $str_apl . '/';
	}
    Header("Location: " . $str_apl);
?>