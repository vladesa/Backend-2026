<?php

echo "Завдання 1: Факторіали \n";
$numbers1 = [];
for ($i = 0; $i < 5; $i++) {
    $numbers1[] = rand(1, 10);
}
function factorial($n) {
    return ($n <= 1) ? 1 : $n * factorial($n - 1);
}
$factorials = array_map('factorial', $numbers1);
echo "Початковий масив: "; print_r($numbers1);
echo "Факторіали: "; print_r($factorials);


echo "\n Завдання 2: Сума кратних 3 і 5 \n";
$arr2 = [];
$sum2 = 0;
for ($i = 0; $i < 30; $i++) {
    $arr2[] = rand(1, 100);
}
foreach ($arr2 as $num) {
    if ($num % 3 == 0 && $num % 5 == 0) {
        $sum2 += $num;
    }
}
echo "Сума: " . $sum2 . "\n";


echo "\n Завдання 3: Найбільше значення \n";
$inputArray3 = [12, 45, 7, 89, 23, 10];
$maxValue = max($inputArray3);
echo "Найбільше значення: " . $maxValue . "\n";


echo "\n Завдання 4: Кількість простих чисел \n";
$arr4 = [];
for ($i = 0; $i < 20; $i++) {
    $arr4[] = rand(10, 100);
}
function isPrime($num) {
    if ($num < 2) return false;
    for ($i = 2; $i <= sqrt($num); $i++) {
        if ($num % $i == 0) return false;
    }
    return true;
}
$primeCount = 0;
foreach ($arr4 as $num) {
    if (isPrime($num)) {
        $primeCount++;
    }
}
echo "Кількість простих чисел: " . $primeCount . "\n";


echo "\n Завдання 5: Заміна парних індексів на 0 \n";
$arr5 = [];
for ($i = 0; $i < 20; $i++) {
    $arr5[] = rand(1, 30);
}
for ($i = 0; $i < count($arr5); $i += 2) {
    $arr5[$i] = 0;
}
print_r($arr5);


echo "\n Завдання 6: Сума елементів кратних 3 \n";
$arr6 = [];
$sum6 = 0;
for ($i = 0; $i < 12; $i++) {
    $arr6[] = rand(-20, 20);
}
foreach ($arr6 as $num) {
    if ($num % 3 == 0) {
        $sum6 += $num;
    }
}
echo "Сума елементів, кратних 3: " . $sum6 . "\n";


echo "\n Завдання 7: Стислий формат ПІБ \n";
$input7 = "Пастушенко Владислава";
$parts = explode(" ", $input7);
if (count($parts) >= 2) {
    $lastName = $parts[0];
    $initial = mb_substr($parts[1], 0, 1);
    $shortName = $lastName . " " . $initial . ".";
    echo "Короткий формат: " . $shortName . "\n";
}


echo "\n Завдання 8: Найменший високосний рік \n";
$years8 = [2022, 2024, 2015, 2016, 2030];
function isLeapYear($year) {
    return (($year % 4 == 0) && ($year % 100 != 0)) || ($year % 400 == 0);
}
$leapYears = array_filter($years8, 'isLeapYear');
$smallestLeapYear = !empty($leapYears) ? min($leapYears) : null;
echo "Найменший високосний рік: " . $smallestLeapYear . "\n";


echo "\n Завдання 9: Обмін мінімального та максимального елементів \n";
$arr9 = [];
for ($i = 0; $i < 10; $i++) {
    $arr9[] = rand(1, 100);
}
$minKey = array_search(min($arr9), $arr9);
$maxKey = array_search(max($arr9), $arr9);

$temp = $arr9[$minKey];
$arr9[$minKey] = $arr9[$maxKey];
$arr9[$maxKey] = $temp;
echo "Масив після обміну мін/макс: ";
print_r($arr9);


echo "\n Завдання 10: Сума квадратів \n";
$n = 5;
$sumOfSquares = 0;
echo "Квадрати: ";
for ($i = 1; $i <= $n; $i++) {
    $square = $i * $i;
    echo $square . " ";
    $sumOfSquares += $square;
}
echo "\nСума квадратів: " . $sumOfSquares . "\n";

?>
