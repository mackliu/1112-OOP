<?php

/* echo Car::$type;
echo Car::speed();
Car::$type="賓士";
echo Car::$type; */

$carA=Car::$type;
echo $carA;
$carA="賓士";
Car::$type='賓士';
echo Car::$type;
echo $carA;
Car::$type="馬沙拉帝";
$carB=Car::$type;
echo "B:". $carB;

/* $car=new Car;
echo $car->type; */

/* $car=new Car;
echo $car->speed();
 */
echo Car::YEAR;

class Car{
    public static $type='裕隆';
    public const YEAR='2022';
    public static function speed(){
        return 60;
    }
}


?>