# Основы PHP

## Домашнее задание № 3.

1. Обработка ошибок. Посмотрите на реализацию функции в файле fwrite-cli.php в исходниках. Может ли пользователь ввести некорректную информацию (например, дату в виде 12-50-1548)? Какие еще некорректные данные могут быть введены? Исправьте это, добавив соответствующие обработки ошибок.

### Решение:

Изначальный файл:

```
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

    if(isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
        return false;
    }

    if(isset($dateBlocks[1]) && $dateBlocks[0] > 12) {
        return false;
    }

    if(isset($dateBlocks[2]) && $dateBlocks[2] > date('Y')) {
        return false;
    }

    return true;
}

```
Попробуем ввести некорректную дату 12-50-1548, итог:

```
PS D:\Учеба\Основы PHP\Seminar\php3\Исправленный файл> php fwrite-cli.php
Введите имя: tester
Введите дату рождения в формате ДД-ММ-ГГГГ: 12-50-1548
Запись tester, 12-50-1548
 добавлена в файл birthdays.txt

```
Для решения этой проблемы исправим строчку:

```
if(isset($dateBlocks[1]) && $dateBlocks[0] > 12) {
        return false;
    }
```
на следующую строку

```
if(isset($dateBlocks[1]) && $dateBlocks[1] > 12) {
        return false;
    }
```

итог:

```
PS D:\Учеба\Основы PHP\Seminar\php3\Исправленный файл> php fwrite-cli.php
Введите имя: tester1
Введите дату рождения в формате ДД-ММ-ГГГГ: 12-50-1548
Введена некорректная информация
```

Кроме того, что в некоторых месяцах не 31 день, а 30, а в феврале в зависимости от того, что високосный год или нет зависит 28 или 29 дней будет в месяце. Это не учтено в программе, поэтому сразу исправим это:

```
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
```

Итог:

```
Введите имя: tester
Введите дату рождения в формате ДД-ММ-ГГГГ: 29-02-2023
Введена некорректная информация

Введите имя: tester
Введите дату рождения в формате ДД-ММ-ГГГГ: 28-02-2023
Запись tester, 28-02-2023
 добавлена в файл birthdays.txt

Введите дату рождения в формате ДД-ММ-ГГГГ: 30-02-2024
Введена некорректная информация
PS D:\Учеба\Основы PHP\Seminar\php3\Исправленный файл> php fwrite-cli.php

Введите имя: tester
Введите дату рождения в формате ДД-ММ-ГГГГ: 29-02-2023
Запись tester, 28-02-2023
 добавлена в файл birthdays.txt

Введите имя: tester
Введите дату рождения в формате ДД-ММ-ГГГГ: 31-09-2024
Введена некорректная информация

Введите дату рождения в формате ДД-ММ-ГГГГ: 30-09-2024
Запись tester, 30-09-2024
 добавлена в файл birthdays.txt

Введите имя: tester
Введите дату рождения в формате ДД-ММ-ГГГГ: 31-10-2024
1
Запись tester, 31-10-2024

```

Теперь для продолжения работы перенесем полученные файлы fwrite-cli.php и birthdays.txt в папку Файловое хранилище.

2. Поиск по файлу. Когда мы научились сохранять в файле данные, нам может быть интересно не только чтение, но и поиск по нему. Например, нам надо проверить, кого нужно поздравить сегодня с днем рождения среди пользователей, хранящихся в формате:

Василий Васильев, 05-06-1992

И здесь нам на помощь снова приходят циклы. Понадобится цикл, который будет построчно читать файл и искать совпадения в дате. Для обработки строки пригодится функция explode, а для получения текущей даты – date.

### Решение: файл ffind.php

```
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

```

3. Удаление строки. Когда мы научились искать, надо научиться удалять конкретную строку. Запросите у пользователя имя или дату для удаляемой строки. После ввода либо удалите строку, оповестив пользователя, либо сообщите о том, что строка не найдена.

### Решение: файл fdelete.php

```
<?php

$address = 'birthdays.txt';

$str = readline("Введите имя и фамилию или дату рождения для удаления всей строчки: ");
function deleteFileLine($dir, $string){
    if(file_exists($dir)){
        $data = file_get_contents($dir);
        
        echo "Начало: $data";
        $array = explode("\n", $data);

        for($i = 0; $i < count($array); $i++)
        {
            $arrayLine = explode(",", $array[$i]);
            for($j = 0; $j < count($arrayLine) - 1; $j++)
            {
                if(($arrayLine[0] === $string) || (verefyDateBirthday($string, $arrayLine[1])))
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
```

4. Добавьте новые функции в итоговое приложение работы с файловым хранилищем.

### Решение: все коды расположены в папке Итоговое хранилище/code/src
