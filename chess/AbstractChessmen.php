<?php


abstract class AbstractChessmen implements IChessmen
{
    public $x;
    public $y;

    public function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getPosition()
    {
        echo get_class($this).' --- x:'. $this->x . '  y:' . $this->y . '<br>';
    }
}