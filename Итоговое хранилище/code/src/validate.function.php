<?php

function validate(string $date): bool {
    $dateBlocks = explode("-", $date);

    if(count($dateBlocks) < 3){
        return false;
    }

    if(isset($dateBlocks[1]) && $dateBlocks[1] == 1 && $dateBlocks[1] == 3 && $dateBlocks[1] == 5 && $dateBlocks[1] == 7 && $dateBlocks[1] == 8 && $dateBlocks[1] == 10 && $dateBlocks[1] == 12)
    if(isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
        return false;
    }

    if(isset($dateBlocks[1]) && $dateBlocks[1] == 4 && $dateBlocks[1] == 6 && $dateBlocks[1] == 9 && $dateBlocks[1] == 11)
    if(isset($dateBlocks[0]) && $dateBlocks[0] > 30) {
        return false;
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

function validateDataBirthday(string $date, string $date2):bool
{
    $dateBlocks = explode("-", $date);
    $currentDateBlocks = explode("-", $date2);
    if(($dateBlocks[0] == $currentDateBlocks[0]) && ($dateBlocks[1] == $currentDateBlocks[1]) )
    {
        return true;
    }
    return false;
}