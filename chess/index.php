<?php

include_once 'IChessmen.php';
include_once 'AbstractChessmen.php';
include_once 'King.php';
include_once 'Queen.php';

$king = new King(4,3);
$king->getPosition();

$queen = new Queen(1,1);
$queen->getPosition();
echo '<br>';
$king->move(3,3)->move(2,2)->getPosition();
echo '<br>';
$queen->move(7,1)->move(7,3)->getPosition();
