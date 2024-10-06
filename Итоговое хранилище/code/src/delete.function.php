<?php

function deleteFileLine(array $config):string
{
    $address = $config['storage']['address'];
    $str = readline("Введите имя и фамилию или дату рождения для удаления всей строчки: ");
    if(file_exists($address)){
        $data = file_get_contents($address);
        
        echo "Начало: $data";
        $array = explode("\n", $data);

        for($i = 0; $i < count($array); $i++)
        {
            $arrayLine = explode(",", $array[$i]);
            for($j = 0; $j < count($arrayLine) - 1; $j++)
            {
                if(($arrayLine[0] === $str) || (validateDataBirthday($str, $arrayLine[1])))
                {
                    echo "Найдено";
                    echo $str . ";" .$arrayLine[1] . ";";
                    $data = str_replace($array[$i], '', $data);
                }
                else 
                {
                    echo "Не найдено";
                    echo $str. ";" . $arrayLine[1] . ";";

                }
            }
        }

        echo "Итог:$data";
        file_put_contents($address, $data);
    }
    return "";
}