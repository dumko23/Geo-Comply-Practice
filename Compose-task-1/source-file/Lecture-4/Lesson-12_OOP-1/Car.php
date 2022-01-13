<?php

class Car
{
    public const ONE = 1;
    public const TWO = 3;
    public const THREE = 4;

    public string $color;
    public float $price;
    public string $type = 'cab';
    public float $fuel;
    public float $fuelConsumption;

    public function __construct(
        float $price,
        string $color,
        float $fuel,
    )
    {
        $this->$price = $price;
        $this->color = $color;
        $this->fuel = $fuel;
    }
    public function fuelConsumption(float $distance): float|int
    {
        return $this->fuelConsumption = $this->fuel * $distance;
    }

    public function getMaxConstant(){
//TODO function
    }
}