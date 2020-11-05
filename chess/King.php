<?php


class King extends AbstractChessmen
{
    public function move($moveX, $moveY)
    {
        if (!$this->checkCoordinates($moveX, $moveY)) {
            throw new Exception('Недопустимые координаты');
        }

        try {
            $this->x = $moveX;
            $this->y = $moveY;
            echo 'Ход ' . get_class() .': x:'.$moveX.' y:'.$moveY.'<br>';
        } catch (Exception $exception) {
            echo 'Ошибка: '.$exception->getMessage();
        }

        return $this;
    }

    private function checkCoordinates($moveX, $moveY)
    {
        if (($moveX < 1 || $moveX > 8) || ($moveY < 1 || $moveY > 8)) {
            return false;
        }
        $currentX = $this->x;
        $newPosX = $moveX;
        if ($this->y == $moveY || $currentX == $newPosX) {
            return true;
        }

        $d = abs($newPosX - $currentX);
        $c = abs($moveY - $this->y);

        if (($d == $c) == 1) {
            return true;
        } else {
            return false;
        }
    }
}