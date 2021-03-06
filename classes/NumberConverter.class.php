<?php

/**
 * Class NumberConverter inneholder en statisk metode for å konvertere tall til norske ord.
 */
class NumberConverter {

    /**
     * Metoden returner det norske ordet for et tall dersom dette er under eller lik 12. Etter norske rettskrivingsreegler.
     *
     * @param int $number Tallet som skal bil gjort om til et ord.
     * @return int|string Returnerer tallet dersom over 12, ordet hvis 12 eller under.
     */
    public static function convert($number) {
        $numberStrings = array('Én', 'To', 'Tre', 'Fire', 'Fem', 'Seks', 'Sju', 'Åtte', 'Ni', 'Ti', 'Elleve', 'Tolv');
        if ($number <= 12) {
            // Array index starter på 0.
            return $numberStrings[$number - 1];
        }
        // Tallet er over 12. Returnerer tallet.
        else {
            return $number;
        }
    }
}