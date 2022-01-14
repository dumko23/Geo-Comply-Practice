<?php

class Rectangle extends Figure
{
    public const SIDES_COUNT = 4;


    public function __construct(private float $a, private float $b)
    {
    }

    public function getArea(): float
    {
        return $this->square = $this->a * $this->b;
    }

    public final function infoAbout(): string
    {
        return 'This is a ' . self::class . ' class. It have ' . self::SIDES_COUNT . ' sides';
    }
}