<?php

class Car
{
    public const ONE = 1;
    public const TWO = 5;
    public const THREE = 4;

    public string $type = 'cab';

    public function __construct(
        public float  $price,
        public string $color,
        public float  $fuelPer100,
    )
    {
    }

    public function fuelConsumption(float $distance): float|int
    {
        return $this->fuelPer100 * $distance / 100;
    }

    public static function getMaxConstant()
    {
        $array = [self::ONE, self::TWO, self::THREE];
        return max($array);
    }
}