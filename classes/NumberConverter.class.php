<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 26.04.2015
 * Time: 14:16
 */

class NumberConverter {

    public static function convert($number) {
        $numberStrings = array('Én', 'To', 'Tre', 'Fire', 'Fem', 'Seks', 'Sju', 'Åtte', 'Ni', 'Ti', 'Elleve', 'Tolv');
        if ($number <= 12) {
            return $numberStrings[$number - 1];
        }
        else {
            return $number;
        }
    }
}