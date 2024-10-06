<?php

function searchBy(array $config):string {
    $address = $config['storage']['address'];
    $data = file_get_contents($address);
    $array = explode("\n", $data);
	$num = count($array) - 1;
	for($i = 0; $i < $num; $i++)
	{
	        $arrayLine = explode(",", $array[$i]);
	        for($j = 0; $j < count($arrayLine) -1 ; $j++)
	        {
	            if (validateDataBirthday($arrayLine[1], date('d-m-Y', time())))
	            {
	                $result = $arrayLine[0] . ", " . $arrayLine[1] . "- поздравляем, вы именнинник!\n";
	                echo $result;
	            }
	            else
	            {
	
	                 $result = $arrayLine[0] . ", " . $arrayLine[1] . "- вы не именнинник, ждите своего дня рождения!\n";
	                 echo $result;
                     
	            }
	        }
	}
    return "";
}
