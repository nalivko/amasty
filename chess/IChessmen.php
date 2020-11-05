<?php

interface IChessmen
{
    public function __construct($x, $y);

    public function move($moveX, $moveY);

    public function getPosition();
}
