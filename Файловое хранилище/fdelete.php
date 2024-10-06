<?php

$address = 'birthdays.txt';

$str = readline("Введите имя и фамилию или дату рождения для удаления всей строчки: ");
//$str = "Иванов Иван";
function deleteFileLine($dir, $string){
    if(file_exists($dir)){
        $data = file_get_contents($dir);
        
        echo "Начало: $data";
        // $data = str_replace("Иванов Иван,06-10-1975", '', $data);
        // echo "\n$data";
        $array = explode("\n", $data);

        for($i = 0; $i < count($array); $i++)
        {
            $arrayLine = explode(",", $array[$i]);
            for($j = 0; $j < count($arrayLine) - 1; $j++)
            {
                if(($arrayLine[0] === $string) || (verefyDateBirthday($string, $arrayLine[1])))
                //if(strcmp())
                {
                    echo "Найдено";
                    echo $string . ";" .$arrayLine[1] . ";";
                    $data = str_replace($array[$i], '', $data);
                }
                else 
                {
                    echo "Не найдено";
                    echo $string . ";" . $arrayLine[1] . ";";

                }
            }
        }

        echo "Итог:$data";
        file_put_contents($dir, $data);
    }
}

function verefyDateBirthday($date_str, $date)
{
    $dateBlocks = explode("-", $date);
    $strDateBlocks = explode("-", $date_str);
    if(($dateBlocks[0] == $strDateBlocks[0]) && ($dateBlocks[1] == $strDateBlocks[1]) )
    {
        return true;
    }
    return false;
}

deleteFileLine($address, $str);