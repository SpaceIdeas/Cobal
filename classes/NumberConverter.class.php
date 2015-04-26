<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 26.04.2015
 * Time: 14:16
 */

class NumberConverter {
    private $numberStrings = array('En', 'To', 'Tre', 'Fire', 'Fem', 'Seks', 'Sju', 'Åtte', 'Ni', 'Ti', 'Elleve', 'Tolv');

    public function convert($number) {
        if ($number <= 12) {
            return $this->numberStrings[$number];
        }
        else {
            return -1;
        }
    }
}