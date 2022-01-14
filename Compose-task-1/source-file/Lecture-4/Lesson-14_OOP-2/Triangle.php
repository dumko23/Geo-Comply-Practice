<?php

class Triangle extends Figure
{
    public const SIDES_COUNT = 3;


    public function __construct(private float $a, private float $b, private float $c)
    {
    }

    public function getArea(): string
    {
        $p = ($this->a + $this->b + $this->c) / 2;
        return 'Area: ' . $this->square = sqrt($p * ($p - $this->a) * ($p - $this->b) * ($p - $this->c));
    }

    public final function infoAbout(): string
    {
        return 'This is a ' . self::class . ' class. It have ' . self::SIDES_COUNT . ' sides';
    }
}