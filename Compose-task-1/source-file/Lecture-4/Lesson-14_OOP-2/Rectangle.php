<?php

class Rectangle extends Figure
{
    public const SIDES_COUNT = 4;

    private float $a;
    private float $b;

    public function __construct(float $a, float $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function getArea(): string
    {
        return 'Area: ' . $this->square = $this->a * $this->b;
    }

    public function infoAbout(): string
    {
        return 'This is a ' . self::class . ' class. It have ' . self::SIDES_COUNT . ' sides';
    }
}