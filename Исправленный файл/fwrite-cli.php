<?php

$address = 'birthdays.txt';

$name = readline("Введите имя: ");
$date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

if(validate($date)){
    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');
    
    if(fwrite($fileHandler, $data)){
        echo "Запись $data добавлена в файл $address";
    }
    else {
        echo "Произошла ошибка записи. Данные не сохранены";
    }
    
    fclose($fileHandler);
}
else{
    echo "Введена некорректная информация";
}

function validate(string $date): bool {
    $dateBlocks = explode("-", $date);

    if(count($dateBlocks) < 3){
        return false;
    }

    if( ($dateBlocks[1] == 1) || ($dateBlocks[1] == 3) || ($dateBlocks[1] == 5) || ($dateBlocks[1] == 7) || ($dateBlocks[1] == 8) || ($dateBlocks[1] == 10) || ($dateBlocks[1] == 12))
    {
        if(isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
            return false;
        }
    }  

    if( ($dateBlocks[1] == 4) || ($dateBlocks[1] == 6) || ($dateBlocks[1] == 9) || ($dateBlocks[1] == 11)){
        if(isset($dateBlocks[0]) && $dateBlocks[0] > 30) {
            return false;
        }
    }
    

    if($dateBlocks[1] == 2){
        if(isset($dateBlocks[2]) && $dateBlocks[2] % 4 == 0){
            if(isset($dateBlocks[0]) && $dateBlocks[0] > 29) {
                return false;
            }
        }
        if(isset($dateBlocks[2]) && $dateBlocks[2] % 4 != 0){
            if(isset($dateBlocks[0]) && $dateBlocks[0] > 28) {
                return false;
            }
        }
    }

    if(isset($dateBlocks[1]) && $dateBlocks[1] > 12) {
        
        return false;
    }

    if(isset($dateBlocks[2]) && $dateBlocks[2] > date('Y')) {
        return false;
    }

    return true;
}
