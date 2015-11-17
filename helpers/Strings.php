<?php

namespace app\helpers;

class Strings
{
    /**
     * @param $number int число чего-либо
     * @param $titles array варинаты написания для количества 1, 2 и 5
     * @return string
     */
    public static function humanPlural($number,array $titles){
        $cases = [2, 0, 1, 1, 1, 2];
        return $number . " " . $titles[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
    }
}