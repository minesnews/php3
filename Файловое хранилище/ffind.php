<?php

$address = 'birthdays.txt';

function readFile1($string){
    $data = file_get_contents($string);
    $array = explode("\n", $data);
	$num = count($array) - 1;
	for($i = 0; $i < $num; $i++)
	{
        
        $arrayLine = explode(",", $array[$i]);
        for($j = 0; $j < count($arrayLine) -1 ; $j++)
        {
            if (validateDataBirthday($arrayLine[1]))
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
    
}

function validateDataBirthday(string $date):bool
{
    $dateBlocks = explode("-", $date);
    $currentDateBlocks = explode("-", date('d-m-Y', time()));
    if(($dateBlocks[0] == $currentDateBlocks[0]) && ($dateBlocks[1] == $currentDateBlocks[1]) )
    {
        return true;
    }
    return false;
}

readFile1($address);