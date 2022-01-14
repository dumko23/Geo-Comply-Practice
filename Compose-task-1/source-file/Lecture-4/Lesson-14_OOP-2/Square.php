<?php

class Square extends Figure
{
    public const SIDES_COUNT = 4;


    public function __construct(private float $a)
    {
    }

    public function getArea(): string
    {
        return 'Area: ' . $this->square = $this->a * $this->a;
    }

    public final function infoAbout(): string
    {
        return 'This is a ' . self::class . ' class. It have ' . self::SIDES_COUNT . ' sides';
    }
}